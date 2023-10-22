<?php

namespace App\Services;

use App\Jobs\AssignManager;
use App\Models\User;
use App\Models\Issue;
use App\Models\Comment;
use App\Models\Company;
use App\Mail\IssueSolve;
use App\Jobs\ReviewIssue;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Jobs\IssueSolve as JobsIssueSolve;
use App\Jobs\IssueStatusChanged;
use App\Jobs\SendIssueCreatorNotification;

class IssueService
{

    protected $issue;
    protected $commentService;

    public function __construct(){
        $this->issue = new Issue;
        $this->commentService = new CommentService();
    }

    public function index($request){
        $hrId = $request->company;
        $user = User::where('company_id', $hrId)->get();
        return ['hrs' => $user];
    }

    public function store($request){
        $slug = Str::slug($request->title, '-', Str::random(5));
        $company = Company::where('uuid', $request->issueUuid)->first();
        $this->issue->fill($request->all());
        $this->issue->slug = $slug;
        $this->issue->company_id = $company->id;
        $this->issue->save();
        return ['success' => __('entity.entityCreated', ['entity' => 'Issue'])];
    }

    public function show($id){
        return Issue::with(['user', 'company', 'hr'])->findOrFail($id);
    }

    public function edit($issue){
        $hrId = auth()->user()->id;
        if ($hrId == $issue->hr_id) {
            return User::where('parent_id', $hrId)->get();
        } else {
            return abort(404);
        }
    }

    public function update($id, $request){
        $issue = Issue::find($id);
        $requestManagerId = (int) $request->manager_id;

        if ($request->status == 'COMPLETED') {
            $email = $issue->email;
            JobsIssueSolve::dispatchSync([
                'email' => $email,
                'issue' => $issue,
            ]);
        }

        if (auth()->user()->hasRole('manager') && $request->status === 'OPEN') {
            Issue::find($id)->fill($request->except('status'))->save();
            return ['error' => 'You do not have the required role to set the status to "Open."'];
        }
        $issue->fill($request->all())->save();

        if ($issue->manager_id !== $requestManagerId) {
            $user = User::find($issue->manager_id);
            AssignManager::dispatchSync($user->email, $issue);
            SendIssueCreatorNotification::dispatchSync($issue->email, $user);
        }

        if (auth()->user()->hasRole(config('site.role.hr'))) {
            if ($request->status == $issue->status) {
                if ($issue->status !== 'SEND_FOR_REVIEW') {
                    $user = $issue->user;
                    IssueStatusChanged::dispatchSync($issue, $user);
                }
            }
        } else if (auth()->user()->hasRole(config('site.role.manager'))) {
            if ($request->status == $issue->status) {
                $user = $issue->hr;
                IssueStatusChanged::dispatchSync($issue, $user);
            }
        }

        if ($request->body) {
            $this->commentService->store($request, $id);
        }
        return  ['success' => __('entity.entityUpdated', ['entity' => 'Issue'])];
    }


    public function destroy($id){
        Issue::find($id)->delete();
        return  ['success' => __('entity.entityDeleted', ['entity' => 'Company']),];
    }

    public function collection($query, $request){
        $query = Issue::with('company');
        switch ($request->table) {
            case config('site.table.admin'):
                $query->with(['manager', 'hr']);
                break;

            case config('site.table.hr'):
                $id = auth()->user()->id;
                $query->with('manager')->where('hr_id', $id);

                if ($request->type == 'pending') {
                    $query->whereNull(['due_date', 'manager_id']);
                } elseif ($request->type == 'review-issue') {
                    $query->where('status', 'SEND_FOR_REVIEW');
                }
                break;

            case config('site.table.manager'):
                $companyId = auth()->user()->id;
                $query->where('manager_id', $companyId);

                if ($request->type == 'pending') {
                    $query->where('status', '<>', 'SEND_FOR_REVIEW')->where('status', '<>', 'COMPLETED');
                }
                break;
        }
        $this->filters($request, $query);
        return $query;
    }

    public function filters($request, $query)
    {
        if ($request->filter) {
            $query->where('priority', $request->filter);
        }
        if ($request->duedate) {
            $query->where('due_date', $request->duedate);
        }
        if ($request->company) {
            $query->where('company_id', $request->company);
        }
    }
}
