<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Services\IssueService;
use App\Services\CompanyService;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class IssueController extends Controller{

    protected $issueService;
    protected $companyService;

    public function __construct(IssueService $issueService){
        $this->issueService = $issueService;
        $this->companyService = new CompanyService();
    }

    public function index(Request $request){
        if ($request->ajax()) {
            $query = $this->issueService->collection($request);
            return DataTables::of($query)
                ->orderColumn('title', function ($query, $order) {
                    $query->orderBy('id', $order);
                })
                ->editColumn('due_date', function ($row) {
                    if ($row->due_date) {
                        return [
                            'display' => e($row->created_at->format(config('site.date'))),
                            'timestamp' => $row->created_at
                         ];
                    } else {
                        return [
                            'display' => 'Due date is not selected',
                            'timestamp' => $row->created_at
                        ];
                    }
                 })
                 ->editColumn('status', function ($row) {
                        return [
                            'display' => e(str_replace('_', ' ', ucwords(strtolower($row->status)))),
                            'status' => $row->status
                         ];
                 })
                ->addColumn('action', function ($row) {
                    $showRoute = route('admin.issue.show', ['issue' => $row->id]);
                    $actionBtn = '<a href=' . $showRoute . ' data-issue-id="' . $row->id . '" class="view btn btn-primary btn-sm"><i class="fa-solid fa-eye" style="margin:0 5px 0 0"></i>View</a> <a href="delete" data-issue-id="' . $row->id . '"  class="delete  btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteIssue"><i class="fas fa-trash" style="margin: 0 5px 0 0;"></i>Delete</a>';
                    return $actionBtn;
                })
                ->make(true);
        }
        $companies = $this->companyService->index();
        return view('admin.Issue.index', ['companies' => $companies]);
    }

    public function show($id){
        $issue = $this->issueService->show($id);
        return view('admin.issue.show', ['issue' => $issue, 'route' => route('admin.issue.index')]);
    }

    public function destroy($id){
        return $this->issueService->destroy($id);
    }
}
