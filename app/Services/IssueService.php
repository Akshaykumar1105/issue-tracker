<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Issue;
use App\Models\Comment;
use App\Models\Company;
use App\Mail\IssueSolve;
use App\Jobs\ReviewIssue;
use App\Jobs\AssignManager;
use Illuminate\Support\Str;
use App\Jobs\IssueStatusChanged;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Jobs\IssueSolve as JobsIssueSolve;
use App\Jobs\SendIssueCreatorNotification;

class IssueService
{

    protected $issue;
    protected $commentService;

    public function __construct()
    {
        $this->issue = new Issue;
        $this->commentService = new CommentService();
    }

    public function index($request)
    {
        $companyId = $request->company;
        $user = User::where('company_id', $companyId)->whereNull('parent_id')->get();
        return ['hrs' => $user];
    }

    public function store($request)
    {
        $originalSlug = Str::slug($request->title, '-', Str::random(5));
        $slug = $originalSlug;
        $count = 2;
        while (Issue::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        $company = Company::where('uuid', $request->issueUuid)->first();
        $this->issue->fill($request->all());
        $this->issue->slug = $slug;
        if ($request->company_id) {
            $this->issue->company_id = $request->company_id;
        } else {
            $this->issue->company_id = $company->id;
        }
        $this->issue->save();
        return ['success' => __('entity.entityCreated', ['entity' => 'Issue'])];
    }

    public function show($id)
    {
        return Issue::with(['manager', 'company', 'hr'])->findOrFail($id);
    }

    public function edit($issue)
    {
        $hrId = auth()->user()->id;
        if ($hrId == $issue->hr_id) {
            return User::where('parent_id', $hrId)->get();
        } else {
            return abort(404);
        }
    }

    public function update($id, $request)
    {
        $issue = Issue::find($id);
        if (auth()->user()->hasRole(config('site.role.manager'))) {
            if ($issue->status == 'OPEN') {
                Issue::find($id)->fill($request->all())->save();
            } else if ($request->status === 'OPEN' && $issue->status !== 'OPEN') {
                Issue::find($id)->fill($request->except('status'))->save();
                return ['error' => 'You do not have the required role to set the status to "Open."'];
            }
            Issue::find($id)->fill($request->all())->save();
        }

        if ($request->body) {
            $this->commentService->store($request, $id);
        }
        if (auth()->user()->hasRole(config('site.role.hr'))) {
            $this->updateIssueByHr($request, $issue);
        } else if (auth()->user()->hasRole(config('site.role.manager'))) {
            $this->updateIssueByManager($request, $issue);
        }

        return  ['success' => __('entity.entityUpdated', ['entity' => 'Issue'])];
    }


    public function destroy($id)
    {
        Issue::find($id)->delete();
        return  ['success' => __('entity.entityDeleted', ['entity' => 'Company']),];
    }

    public function collection($request)
    {
        $query = Issue::with('company');
        switch ($request->table) {
            case config('site.table.admin'):
                $query->with(['manager', 'hr'])->filter($request);
                break;

            case config('site.table.hr'):
                $id = auth()->user()->id;
                $query->with('manager')->where('hr_id', $id)->filter($request);

                if ($request->type == 'pending') {
                    $query->whereNull(['due_date', 'manager_id']);
                } elseif ($request->type == 'review-issue') {
                    $query->where('status', 'SEND_FOR_REVIEW');
                }
                break;

            case config('site.table.manager'):
                $managerId = auth()->user()->id;
                $query->where('manager_id', $managerId)->filter($request);

                if ($request->type == 'pending') {
                    $query->where('status', '<>', 'SEND_FOR_REVIEW')->where('status', '<>', 'COMPLETED');
                }
                break;
        }
        return $query;
    }

    private function updateIssueByManager($request, $issue)
    {
        if ($request->status !== $issue->status) {
            $user = $issue->hr;
            IssueStatusChanged::dispatch($issue, $user);
        }
        $issue->fill($request->all())->save();
    }

    private function updateIssueByHr($request, $issue)
    {
        if ($issue->manager_id !== $request->manager_id) {
            $user = User::find($request->manager_id);
            // Assign manager email
            AssignManager::dispatch($user->email, $issue);
        }
        if ($request->status == 'COMPLETED') {
            $email = $issue->email;
            // Issue resolve email
            JobsIssueSolve::dispatch([
                'email' => $email,
                'issue' => $issue,
            ]);
        } else {
            $email = $issue->email;
            SendIssueCreatorNotification::dispatch($email, $user);
        }

        $issue->fill($request->all());
        $issue->assign_at = Carbon::now();
        $issue->save();
    }
}
