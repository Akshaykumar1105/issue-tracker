<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Services\CommentService;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{

    protected $commentService;

    public function __construct(CommentService $commentService){
        $this->commentService = $commentService;
    }

    public function index(Request $request){
        $comment = $this->commentService->index($request);
        return ['comments' => $comment];
    }

    public function update($id, Request $request){
        return $this->commentService->update($id,$request);
    }

    public function destroy($id){
        $this->commentService->destroy($id);
        return [
            'success' => __('entity.entityDeleted', ['entity' => 'Comment']),
        ];
    }
}
