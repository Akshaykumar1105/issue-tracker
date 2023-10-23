@props(['comment' , 'vote'])

<div class="rating">
    @if (!$comment->commentUpvotes->isEmpty())
        <div class="rating">
            <!-- Thumbs up -->
            <div class="like grow {{ $comment->id == $vote->comment_id ? 'active' : '' }}"
                data-user="{{ in_array(auth()->user()->id, $votes) ? 'true' : 'false' }}"
                data-upvote="{{ in_array(auth()->user()->id, $votes) ? 'true' : 'false' }}"
                data-comment-id="{{ $comment->id }}">
                <i class="fa fa-thumbs-up fa-2x likethumb" aria-hidden="true"></i>
            </div>
        </div>
        <p style="margin: 0 0 0 60px;" >Total Votes: {{ count($comment->commentUpvotes) }}</p>
    @else
        <div class="rating">
            <!-- No upvotes, display a like button without the active class -->
            <div class="like grow" data-user="{{ auth()->user()->id }}"
                data-comment-id="{{ $comment->id }}">
                <i class="fa fa-thumbs-up fa-2x likethumb" aria-hidden="true"></i>
            </div>
        </div>
        <p style="margin: 0 0 0 60px;" value="{{ count($comment->commentUpvotes) }}">Total Votes: {{ count($comment->commentUpvotes) }}
        </p>
    @endif
</div>