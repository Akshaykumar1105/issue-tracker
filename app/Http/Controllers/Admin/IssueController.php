<?php

namespace App\Http\Controllers\Admin;

use App\Models\Issue;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use App\Services\User\IssueService;
use Yajra\DataTables\Facades\DataTables;

class IssueController extends Controller
{

    protected $issueService;

    public function __construct(IssueService $issueService)
    {
        $this->issueService = $issueService;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Issue::with('company');
            if ($request->filter) {
                $query->where('priority', $request->filter);
            }
            if ($request->duedate) {
                $query->where('due_date', $request->duedate);
            }
            if ($request->company) {
                $query->where('company_id', $request->company);
            }
            return DataTables::of($query)
                ->orderColumn('title', function ($query, $order) {
                    $query->orderBy('id', $order);
                })
                ->addColumn('action', function ($row) {
                    $editRoute = route('admin.issue.show', ['issue' => $row->id]);
                    $actionBtn = '<a href=' . $editRoute . ' data-issueId="' . $row->id . '" class="view btn btn-primary btn-sm">View</a> <a href="delete" data-issueId="' . $row->id . '"  class="delete  btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteIssue">Delete</a>';
                    return $actionBtn;
                })
                ->make(true);
        }
        $company = Company::where('is_active', config('site.status.active'))->get();
        return view('admin.Issue.index', ['companies' => $company]);
    }

    public function show($id)
    {
        $issue = $this->issueService->show($id);
        return view('admin.issue.show', ['issue' => $issue, 'route' => route('admin.issue.index')]);
    }

    public function destroy(Request $request)
    {
        // dd($request);
        return $this->issueService->destroy($request);
    }
}
