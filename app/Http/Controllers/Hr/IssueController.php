<?php

namespace App\Http\Controllers\Hr;

use App\Models\Issue;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\IssueUser;
use App\Models\User;
use App\Services\User\IssueService;
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
                $actionBtn = '<a href=' . $editRoute . ' data-issueId="' . $row->id . '" class="view btn btn-primary btn-sm">View</a>';
                return $actionBtn;
            })
            
            ->rawColumns(['status', 'action'])
            ->make(true);
        }
        return view('hr.issue.index');
    }

    public function edit(Issue $issue){
        $manager = $this->issueService->edit($issue);
        $comments = Comment::with('users.media')->where('issue_id', $issue->id)->orderBy('created_at')->get();

        return view('hr.issue.create', ['issue' => $issue, 'managers' => $manager, 'comments' => $comments]);
    }

    public function update(Request $request, $id){
        return $this->issueService->update($id, $request);
    }
}
