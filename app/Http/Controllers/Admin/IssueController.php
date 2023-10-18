<?php

namespace App\Http\Controllers\Admin;

use App\Models\Issue;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use App\Services\CompanyService;
use App\Services\IssueService;
use Yajra\DataTables\Facades\DataTables;

class IssueController extends Controller{

    protected $issueService;
    protected $companyService;

    public function __construct(IssueService $issueService, CompanyService $companyService){
        $this->issueService = $issueService;
        $this->companyService = new CompanyService();
    }

    public function index(Request $request){
        if ($request->ajax()) {
            $query = $this->issueService->collection($query = null, $request);
            return DataTables::of($query)
                ->orderColumn('title', function ($query, $order) {
                    $query->orderBy('id', $order);
                })
                ->addColumn('action', function ($row) {
                    $editRoute = route('admin.issue.show', ['issue' => $row->id]);
                    $actionBtn = '<a href=' . $editRoute . ' data-issue-id="' . $row->id . '" class="view btn btn-primary btn-sm">View</a> <a href="delete" data-issue-id="' . $row->id . '"  class="delete  btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteIssue">Delete</a>';
                    return $actionBtn;
                })
                ->make(true);
        }
        $company = $this->companyService->index();
        return view('admin.Issue.index', ['companies' => $company]);
    }

    public function show($id){
        $issue = $this->issueService->show($id);
        return view('admin.issue.show', ['issue' => $issue, 'route' => route('admin.issue.index')]);
    }

    public function destroy($id){
        return $this->issueService->destroy($id);
    }
}
