<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\CommentUpVoteService;

class CommentUpvoteController extends Controller{

    protected $commentUpVoteService;

    public function __construct(CommentUpVoteService $commentUpVoteService){
        $this->commentUpVoteService = $commentUpVoteService;
    }

    public function store($commentId){
        return $this->commentUpVoteService->store($commentId);
    }

    public function destroy($commentId){
        return $this->commentUpVoteService->destroy($commentId);
    }
}
