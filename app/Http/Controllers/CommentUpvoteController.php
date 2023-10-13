<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CommentUpvotes;
use App\Services\CommentService;
use Illuminate\Http\Request;

class CommentUpvoteController extends Controller{

    protected $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function store($commentId, Request $request){
        return $this->commentService->storeUpvote($commentId);
    }

    public function destroy($commentId){
        return $this->commentService->destroyUpvote($commentId);
    }
}
