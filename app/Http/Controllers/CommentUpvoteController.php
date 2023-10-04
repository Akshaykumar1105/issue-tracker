<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CommentUpvotes;
use Illuminate\Http\Request;

class CommentUpvoteController extends Controller
{

    public function store($commentId, Request $request)
    {
        $existingUpvote = CommentUpvotes::where('user_id', auth()->id())
            ->where('comment_id', $commentId)
            ->first();

        if (!$existingUpvote) {
            // User hasn't upvoted, so create a new upvote
            CommentUpvotes::create([
                'user_id' => auth()->id(),
                'comment_id' => $commentId,
            ]);
        }

        return response()->json(['message' => 'Upvoted successfully']);
    }

    public function destroy($commentId)
    {
        CommentUpvotes::where('user_id', auth()->id())
            ->where('comment_id', $commentId)
            ->delete();

        // You can return a response indicating success if needed
        return response()->json(['message' => 'Upvote removed successfully']);
    }
}
