<?php

namespace App\Services;

use App\Models\CommentUpvotes;

class CommentUpVoteService {
    public function store($commentId){
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
        return CommentUpvotes::where('user_id', auth()->id())
            ->where('comment_id', $commentId)
            ->delete();
    }
}

?>