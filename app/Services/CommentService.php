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
        $comments = Comment::with('users.media')
            ->with('commentUpvotes')
            ->where('issue_id', $request->issueId)
            ->orderBy('created_at')
            ->get();
        return view('comment', ['comments' => $comments])->render();
    }

    public function store($request, $id){
        $comment = Comment::create([
            'issue_id' => $id,
            'body' => $request->body,
            'status' => $request->status
        ]);
        $commentId = $comment->id;
        $user = auth()->user();
        $user->comments()->attach([$commentId => ['user_id' => $user->id]]);
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

    public function storeUpvote($commentId){
        $upvote = CommentUpvotes::where('user_id', auth()->id())
            ->where('comment_id', $commentId)
            ->first();

        if (!$upvote) {
            CommentUpvotes::create([
                'user_id' => auth()->id(),
                'comment_id' => $commentId,
            ]);
        }
    }

    public function destroyUpvote($commentId){
        return CommentUpvotes::where('user_id', auth()->id())
            ->where('comment_id', $commentId)
            ->delete();
    }
}
