<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CommentUpvotes;
use Illuminate\Http\Request;

class CommentUpvoteController extends Controller{

    public function store($commentId, Request $request){
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

    public function destroy($commentId){
        CommentUpvotes::where('user_id', auth()->id())
            ->where('comment_id', $commentId)
            ->delete();
    }
}
