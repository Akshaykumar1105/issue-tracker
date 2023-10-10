<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CommentService;
use App\Http\Controllers\Controller;
use App\Models\Comment;

class CommentController extends Controller
{

    protected $commentService;
    protected $comment;

    public function __construct(CommentService $commentService){
        $this->commentService = $commentService;
        $this->comment = new Comment();
    }

    public function index(Request $request){
        $comment = $this->commentService->index($request);
        return ['comments' => $comment];
    }

    public function edit($id, Request $request){
       
    }

    public function update($id, Request $request){
        $comment = $this->comment->where('id', $id)->first();

        $comment->update([
            'body' => $request->body
        ]);
    }

    public function destroy($id){
        $comment = $this->comment->where('id', $id)->first();
        $comment->delete();
        return [
            'success' => __('entity.entityDeleted', ['entity' => 'Comment']),
        ];
    }
}
