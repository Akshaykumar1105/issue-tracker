<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CommentUpvotes;
use App\Services\CommentService;
use App\Services\CommentUpVoteService;
use Illuminate\Http\Request;

class CommentUpvoteController extends Controller{

    protected $commentUpVoteService;

    public function __construct(CommentUpVoteService $commentUpVoteService)
    {
        $this->commentUpVoteService = $commentUpVoteService;
    }

    public function store($commentId, Request $request){
        return $this->commentUpVoteService->store($commentId);
    }

    public function destroy($commentId){
        return $this->commentUpVoteService->destroy($commentId);
    }
}
