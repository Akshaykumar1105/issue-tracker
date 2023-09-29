<?php

namespace App\Http\Controllers\Hr;

use App\Models\Issue;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
            return $this->issueService->collection($request);
        }
        return view('hr.issue.index');
    }

    public function edit(Issue $issue){
        return $this->issueService->edit($issue);
    }

    public function update(Request $request, $id){
        return $this->issueService->update($id, $request);
    }
}
