<?php

namespace App\Http\Controllers\Manager;

use App\Models\Issue;
use Illuminate\Http\Request;
use App\Services\IssueService;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\Issue\Update;
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
            $query = $this->issueService->collection($request);
            return DataTables::of($query)->addIndexColumn()
                ->orderColumn('title', function ($query, $order) {
                    $query->orderBy('id', $order);
                })
                ->addColumn('dueDate', function ($row) {
                    if ($row->due_date) {
                        return date( config('site.date'), strtotime($row->due_date));
                    } else {
                        return 'Not select due date';
                    }
                })
                ->addColumn('action', function ($row) {
                    $editRoute = route('manager.issue.edit', ['issue' => $row->id]);
                    $actionBtn = '<a href=' . $editRoute . ' class="view btn btn-success btn-sm"><i class="fas fa-pencil-alt" style="margin: 0 5px 0 0"></i>Edit</a>';
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

    public function update($id, Update $request){
        return $this->issueService->update($id, $request);
    }
}
