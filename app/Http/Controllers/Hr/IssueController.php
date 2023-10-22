<?php

namespace App\Http\Controllers\Hr;

use App\Models\Issue;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\IssueUser;
use App\Models\User;
use App\Services\IssueService;
use Yajra\DataTables\Facades\DataTables;

class IssueController extends Controller{

    protected $issueService;

    public function __construct(IssueService $issueService){
        $this->issueService = $issueService;
    }

    public function index(Request $request){
        if ($request->ajax()) {
            $query = $this->issueService->collection($query =null, $request);
            return DataTables::of($query)
            ->orderColumn('title', function ($query, $order) {
                $query->orderBy('id', $order);
            })
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $editRoute = route('hr.issue.edit', ['issue' => $row->id]);
                $actionBtn = '<a href=' . $editRoute . ' class="view btn btn-success btn-sm"><i class="fas fa-pencil-alt" style="margin: 0 5px 0 0"></i>Edit</a>';
                return $actionBtn;
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
        }
        return view('hr.issue.index');
    }

    public function edit(Issue $issue){
        $managers = $this->issueService->edit($issue);      
        return view('hr.issue.create', ['issue' => $issue, 'managers' => $managers]);
    }

    public function update(Request $request, $id){
        return $this->issueService->update($id, $request);
    }
}
