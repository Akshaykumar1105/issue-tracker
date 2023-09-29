<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Issue;
use App\Services\User\IssueService;
use Illuminate\Http\Request;

class IssueController extends Controller
{

    protected $issueService;

    public function __construct(IssueService $issueService){
        $this->issueService = $issueService;
    }

    public function index(Request $request){
        if($request->ajax()){
            return $this->issueService->collection($request);
        }
        return view('manager.issue.index');
    }

    public function edit(Issue $issue){
        return view('manager.issue.create', ['issue' => $issue]);
    }

    public function update($id, Request $request){
        return $this->issueService->update($id, $request);
        // dd($id);
        // Issue::find($id)->fill($request->all())->save();

        // return  response()->json([
        //     'success' => __('entity.entityUpdated', ['entity' => 'Issue']),
        //     'route' => route('manager.issue.index')
        // ]);
    }
}
