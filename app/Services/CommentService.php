<?php

namespace App\Services;

use App\Models\Comment;
use Illuminate\Support\Facades\View;


class CommentService
{
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
}
