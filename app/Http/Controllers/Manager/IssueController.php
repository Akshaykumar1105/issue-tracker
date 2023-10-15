<?php

namespace App\Http\Controllers\Manager;

use App\Models\Issue;
use Illuminate\Http\Request;
use App\Services\IssueService;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;


class IssueController extends Controller
{

    protected $issueService;

    public function __construct(IssueService $issueService)
    {
        $this->issueService = $issueService;
    }

    public function index(Request $request){
        if ($request->ajax()) {
            $query = $this->issueService->collection($query = null, $request);
            return DataTables::of($query)
                ->orderColumn('title', function ($query, $order) {
                    $query->orderBy('id', $order);
                })
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editRoute = route('manager.issue.edit', ['issue' => $row->id]);
                    $actionBtn = '<a href=' . $editRoute . ' data-issueId="' . $row->id . '" class="view btn btn-primary btn-sm">View</a>';
                    return $actionBtn;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }
        return view('manager.issue.index');
    }

    public function edit(Issue $issue){
        return view('manager.issue.create', ['issue' => $issue]);
    }

    public function update($id, Request $request){
        return $this->issueService->update($id, $request);
    }
}
