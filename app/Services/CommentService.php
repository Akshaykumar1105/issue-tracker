<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\CommentUpvotes;
use Illuminate\Support\Facades\View;

class CommentService{

    protected $comment;

    public function __construct(){
        $this->comment = new Comment();
    }

    public function index($request){
        $comments = Comment::with('user.media')
            ->with('commentUpvotes')
            ->where('issue_id', $request->issueId)
            ->orderBy('created_at')
            ->get();
        return view('comment', ['comments' => $comments])->render();
    }

    public function store($request, $id){
        $userId = auth()->user()->id;
        $comment = Comment::create([
            'issue_id' => $id,
            'body' => $request->body,
            'status' => $request->status,
            'user_id' => $userId
        ]);
        $commentId = $comment->id;
        // $user->comments()->attach([$commentId => ['user_id' => $user->id]]);
    }

    public function update($id, $request){
        $comment = $this->comment->where('id', $id)->first();
        $comment->update([
            'body' => $request->body
        ]);
        return  [
            'success' => __('entity.entityUpdated', ['entity' => 'Comment']),
        ];
    }

    public function destroy($id){
        $comment = $this->comment->where('id', $id)->first();
        $comment->delete();
        return  [
            'success' => __('entity.entityDeleted', ['entity' => 'Comment']),
        ];
    }
}
