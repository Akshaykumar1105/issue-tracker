<section class="msger">
    <header class="msger-header">
        <div class="msger-header-title">
            <i class="fas fa-comment-alt"></i> Comment Box
        </div>
        <div class="msger-header-options">
            <span><i class="fas fa-cog"></i></span>
        </div>
    </header>

    @if (!$comments->isEmpty())
        <main class="msger-chat" style="max-height: 400px; overflow-y: auto;">
            @foreach ($comments as $comment)
                {{-- Define $votes here --}}
                @php
                    $votes = [];
                @endphp
                @if ($comment->users->count() > 0)
                    {{-- Move $user definition inside this loop --}}
                    @foreach ($comment->users as $user)
                        @foreach ($user->media as $img)
                        @endforeach
                    @endforeach



                    @foreach ($comment->commentUpvotes as $vote)
                        {{-- Populate $votes array --}}
                        @php
                            $votes[] = $vote->user_id;
                        @endphp
                    @endforeach

                    @if ($user->pivot->user_id == auth()->user()->id)
                        <div class="msg right-msg">
                            <div style="padding: 25px; margin: 0 0 0 10px;background-size: cover; background-image: url('@if (isset(auth()->user()->getMedia('user')->first()->filename)) {{ asset('storage/user/' .auth()->user()->getMedia('user')->first()->filename .'.' .auth()->user()->getMedia('user')->first()->extension) }}');" @else{{ asset('/asset/dist/img/AdminLTELogo.png') }} @endif class="img-circle
                                elevation-2" alt="User Image"></div>
                            <div class="dropdown">
                                <div class="custom-dropdown">
                                    <div class="selected-option"><i class="fa-solid fa-ellipsis-vertical"></i></div>
                                    <ul class="options">
                                        <li data-value="option1"><a id="comment{{ $comment->id }}"
                                                data-comment-id="{{ $comment->id }}" class="edit-comment"
                                                href="">Edit</a></li>
                                        <li data-value="option2">
                                            <a id="commentDelete{{ $comment->id }}" class="commentDelete"
                                                data-comment-id="{{ $comment->id }}" data-bs-toggle="modal" data-bs-target="#deleteComment">Delete</a>
                                        </li>
                                    </ul>
                                </div>

                            </div>

                            <div class="msg-bubble d-block" style="width: 100%;">
                                <div class="msg-info">
                                    <div class="msg-info-name">{{ auth()->user()->name }}</div>
                                    <div class="msg-info-time">{{ $comment->created_at->toDayDateTimeString() }}</div>
                                </div>

                                <div class="msg-text">
                                    <div class="comment-text" id="comment-text-{{ $comment->id }}">
                                        {{ $comment->body }}
                                    </div>
                                    <textarea class="comment-edit form-control" name="body" style="display: none;">{{ $comment->body }}</textarea>
                                    <div class="comment-buttons">
                                        <button class="save-comment btn btn-primary mt-2"
                                            data-comment-id="{{ $comment->id }}" style="display: none;">Save</button>
                                    </div>
                                </div>

                                <div class="msg-text">
                                    Status:-{{ $comment->status }}
                                </div>

                                <div class="rating">
                                    @if (!$comment->commentUpvotes->isEmpty())
                                        <div class="rating">
                                            <!-- Thumbs up -->
                                            <div class="like grow {{ $comment->id == $vote->comment_id ? 'active' : '' }}"
                                                data-user="{{ in_array(auth()->user()->id, $votes) ? 'true' : 'false' }}"
                                                data-upvote="{{ in_array(auth()->user()->id, $votes) ? 'true' : 'false' }}"
                                                data-commentid="{{ $comment->id }}"
                                                data-authid="{{ auth()->user()->id }}">
                                                <i class="fa fa-thumbs-up fa-2x likethumb" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                        <p style="margin: 0 0 0 60px;" id="voteCount"> Total Vote:
                                            <span>{{ count($comment->commentUpvotes) }}
                                        </p>
                                    @else
                                        <div class="rating">
                                            <!-- No upvotes, display a like button without the active class -->
                                            <div class="like grow" data-authid="{{ auth()->user()->id }}"
                                                data-commentid="{{ $comment->id }}"
                                                data-user="{{ in_array(auth()->user()->id, $votes) ? 'true' : 'false' }}"
                                                data-upvote="{{ in_array(auth()->user()->id, $votes) ? 'true' : 'false' }}">
                                                <i class="fa fa-thumbs-up fa-2x likethumb" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                        <p style="margin: 0 0 0 60px;" id="voteCount"> Total Vote:
                                            <span>{{ count($comment->commentUpvotes) }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="msg left-msg">
                            <div style="padding: 25px; margin: 0 10px 10px 0 ;background-size: cover; background-image: url('@if (isset($img->filename)) {{ asset('storage/user/' . $img->filename . '.' . $img->extension) }}');" @else{{ asset('/asset/dist/img/AdminLTELogo.png') }} @endif class="img-circle
                                elevation-2" alt="User Image"></div>
                            <div class="msg-bubble d-block">
                                <div class="msg-info">
                                    <div class="msg-info-name">{{ $user->name }}</div>
                                    <div class="msg-info-time">{{ $comment->created_at->toDayDateTimeString() }}</div>
                                </div>

                                <div class="msg-text">
                                    {{ $comment->body }}
                                </div>
                                <div class="msg-text">
                                    Status:-{{ $comment->status }}
                                </div>

                                <div class="rating">
                                    @if (!$comment->commentUpvotes->isEmpty())
                                        <div class="rating">
                                            <!-- Thumbs up -->
                                            <div class="like grow {{ $comment->id == $vote->comment_id ? 'active' : '' }}"
                                                data-user="{{ in_array(auth()->user()->id, $votes) ? 'true' : 'false' }}"
                                                data-upvote="{{ in_array(auth()->user()->id, $votes) ? 'true' : 'false' }}"
                                                data-commentid="{{ $comment->id }}"
                                                data-authid="{{ auth()->user()->id }}">
                                                <i class="fa fa-thumbs-up fa-2x likethumb" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                        <p style="margin: 0 0 0 60px;" id="voteCount">Total Vote:
                                            <span>{{ count($comment->commentUpvotes) }}
                                        </p>
                                    @else
                                        <div class="rating">
                                            <!-- No upvotes, display a like button without the active class -->
                                            <div class="like grow" data-user="{{ auth()->user()->id }}"
                                                data-commentid="{{ $comment->id }}">
                                                <i class="fa fa-thumbs-up fa-2x likethumb" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                        <p style="margin: 0 0 0 60px;" id="voteCount">Total Vote:
                                            <span>{{ count($comment->commentUpvotes) }}
                                        </p>
                                    @endif
                                </div>

                                {{-- <x-vote :comment="$comment" :vote="$vote" --}}
                            </div>
                        </div>
                    @endif
                @endif
            @endforeach
        </main>
    @else
        <p style="margin: 30px;text-align:center; font-size: 32px;">No comment yet.</p>
    @endif
</section>
