<?php

namespace App\Services;

use App\Jobs\IssueSolve as JobsIssueSolve;
use App\Jobs\ReviewIssue;
use App\Mail\IssueSolve;
use App\Models\Comment;
use App\Models\Company;
use App\Models\User;
use App\Models\Issue;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class IssueService
{

    protected $issue;

    public function __construct()
    {
        $this->issue = new Issue; // Use $this->issue to assign the instance to the class property.
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
        return Issue::with('user')->findOrFail($id);
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
        if ($request->status == 'COMPLETED') {
            $email = $issue->email;
            JobsIssueSolve::dispatch([
                'email' => $email,
                'issue' => $issue,
            ])->delay(now()->addMinutes(5));
        }

        if ($request->status == 'SEND_FOR_REVIEW') {
            $email = $issue->email;
            ReviewIssue::dispatch([
                'email' => $email,
                'issue' => $issue,
            ])->delay(now()->addMinutes(5));
        }

        if (auth()->user()->hasRole('manager') && $request->status === 'OPEN') {
            Issue::find($id)->fill($request->except('status'))->save();
            return ['error' => 'You do not have the required role to set the status to "Open."'];
        }
        Issue::find($id)->fill($request->all())->save();

        if ($request->body) {
            $comment = Comment::create([
                'issue_id' => $id,
                'body' => $request->body,
                'status' => $request->status
            ]);
            $commentId = $comment->id;
            $user = auth()->user();
            $user->comments()->attach([$commentId => ['user_id' => $user->id]]);
        }
        return  ['success' => __('entity.entityUpdated', ['entity' => 'Issue'])];
    }


    public function destroy($request){
        Issue::find($request->id)->delete();
        return  ['success' => __('entity.entityDeleted', ['entity' => 'Company']),];
    }

    public function collection($query, $request){
        if ($request->table == config('site.table.admin')) {
            $query = Issue::with('company');
            $this->filters($request, $query);
        } else if ($request->table == config('site.table.hr')) {
            $id = auth()->user()->id;
            $query = Issue::with('user')->where('hr_id', $id);

            if ($request->listing == 'pending') {
                $query = Issue::with('user')->whereNull(['due_date', 'manager_id'])->where('hr_id', $id);
            }
            else if($request->listing == 'review-issue'){
                $query = Issue::with('user')->where('hr_id', $id)->where('status' , 'SEND_FOR_REVIEW');
            }
            $this->filters($request, $query);
        } else if ($request->table == config('site.table.manager')) {
            $companyId = auth()->user()->id;
            $query = Issue::where('manager_id', $companyId);
            if ($request->listing == 'pending') {
                $query->where('status' , 'SEND_FOR_REVIEW');
            }
            $this->filters($request, $query);
        }
        return $query;
    }

    public function filters($request, $query){
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
