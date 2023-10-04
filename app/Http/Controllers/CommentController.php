<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;


class CommentController extends Controller
{
    public function index(Request $request){
        $comments = Comment::with('users.media')
        ->with('commentUpvotes')
        ->where('issue_id', $request->issueId)
        ->orderBy('created_at')
        ->get();

    // Render the Blade template and pass the $comments variable to it
    $html = View::make('comment', ['comments' => $comments])->render();


    // Return the HTML content as a JSON response
    return response()->json(['html' => $html]);
    }
}
