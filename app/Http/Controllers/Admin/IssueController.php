<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Services\IssueService;
use App\Services\CompanyService;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Issue;
use App\Models\User;
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
                            'display' => e(date(config('site.date'), strtotime($row->due_date))),
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
                    $editRoute = route('admin.issue.edit', ['issue' => $row->id]);
                    $actionBtn = '<a href=' . $editRoute . ' data-issue-id="' . $row->id . '" class="view btn btn-success btn-sm"><i class="fas fa-pencil-alt" style="margin: 0 5px 0 0"></i>Edit</a> <a href="delete" data-issue-id="' . $row->id . '"  class="delete  btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteIssue"><i class="fas fa-trash" style="margin: 0 5px 0 0;"></i>Delete</a>';
                    return $actionBtn;
                })
                ->make(true);
        }
        $companies = $this->companyService->index();
        return view('admin.Issue.index', ['companies' => $companies]);
    }

    public function edit($id, Request $request){
        $issue = Issue::with(['manager', 'company', 'hr'])->findOrFail($id);
        $companies = Company::where('is_active', config('site.status.active'))->get();
        $hrs = User::where('company_id', $issue->company_id)->whereNull('parent_id')->get();
        if($request->ajax()){
            $managers = User::where('parent_id', $request->hr_id)->get();
            return response()->json($managers);
        }
        return view('admin.issue.create', ['issue' => $issue, 'companies' => $companies, 'hrs' => $hrs, 'route' => route('admin.issue.index')]);
    }

    public function update($id, Request $request){
        Issue::find($id)->fill($request->all())->save();
        return  ['success' => __('entity.entityUpdated', ['entity' => 'Issue'])];
    }

    public function destroy($id){
        return $this->issueService->destroy($id);
    }
}
