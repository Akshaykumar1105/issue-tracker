@extends('dashboard.layout.master')
@section('style')
    <link href="{{ asset('asset/css/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('asset/css/datepicker.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('asset/css/comment.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('asset/css/loader.css') }}">
@endsection
@section('content')
    <x-loader />
    <section class="content pt-3">
        <div class="card">
            <div class="card-header ">
                <h3 class="card-title">Issue Detail</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-12 ">

                        <div class="row">
                            @php
                                $issueId = $issue->id;
                            @endphp
                            <form method="post" action="{{ route('manager.issue.update', ['issue' => $issueId]) }}"
                                id="issueEdit">
                                @method('patch')
                                @csrf

                                <div class="col-md-12 mt-3">
                                    <label class="form-label fw-bold" for="name">Title</label>
                                    <p>{{ $issue->title }}</p>
                                </div>

                                <div class="col-md-12 mt-4">
                                    <label class="form-label fw-bold" for="name">Description</label>
                                    <p class="">{{ $issue->description }}</p>
                                </div>

                                <div class="col-md-12 d-flex ">
                                    <div class="col-md-6 p-0">
                                        <label for="email" class="form-label fw-bold">Priority</label>
                                        <p>{{ ucwords(strtolower($issue->priority)) }}</p>
                                    </div>

                                    <div class="col-md-6 p-0">
                                        <label class="d-block font-weight-bold">Due Date</label>
                                        <p>{{ $issue->due_date }}</p>
                                    </div>
                                </div>
                                <div class="col-md-3 form-group">
                                    <label for="email" class="form-label fw-bold">Status<span
                                            class="text-danger ms-1">*</span></label>
                                    @if ($issue->status == 'COMPLETED' || $issue->status == 'SEND_FOR_REVIEW')
                                        <div>{{ str_replace('_', ' ', ucwords(strtolower($issue->status))) }}</div>
                                    @else
                                        <select name="status" class="d-block form-control" style="appearance: revert;">
                                            <option value="default">Select Status</option>
                                            <option data-status="OPEN" value="OPEN"
                                                {{ $issue->status == 'OPEN' ? 'selected' : '' }}>Open</option>
                                            <option vlaue="IN_PROGRESS" data-status="IN_PROGRESS"
                                                {{ $issue->status == 'IN_PROGRESS' ? 'selected' : '' }}>In Progress
                                            </option>
                                            <option value="ON_HOLD" data-status="ON_HOLD"
                                                {{ $issue->status == 'ON_HOLD' ? 'selected' : '' }}>On Hold</option>
                                            <option value="SEND_FOR_REVIEW" data-status="SEND_FOR_REVIEW"
                                                {{ $issue->status == 'SEND_FOR_REVIEW' ? 'selected' : '' }}>Send For Review
                                            </option>
                                        </select>
                                    @endif
                                </div>
                                @if ($issue->status == 'COMPLETED' || $issue->status == 'SEND_FOR_REVIEW')
                                @else
                                    <div class="col-md-4 form-group">
                                        <label class="d-block font-weight-bold ">Comment</label>
                                        <input id="body" name="body" class="d-block form-control"
                                            placeholder="Enter your comment">
                                    </div>
                                @endif
                                <div class="col-md-4 d-flex" style="gap:10px;">
                                    @if ($issue->status == 'COMPLETED' || $issue->status == 'SEND_FOR_REVIEW')
                                    @else
                                        <div class="">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    @endif
                                    <a href="{{ route('manager.issue.index', ['type' => 'all-issue']) }}" class="btn btn-outline-secondary">Back</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </section>

    <div id="commentBox"></div>

    <div class="modal fade" id="deleteComment" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Comment Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{ __('messages.conformation.delete', ['attribute' => 'comment?']) }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="comment-delete" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('asset/js/jquery-datatables.min.js') }}"></script>
    <script src="{{ asset('asset/js/datatable.min.js') }}"></script>
    <script src="{{ asset('asset/js/datepicker.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.5.2/dist/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.datepicker').datepicker({});
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            function commentBox() {
                $.ajax({
                    url: "{{ route('issue.comment.index') }}",
                    type: "get",
                    data: {
                        issueId: {{ $issue->id }}
                    },
                    success: function(response) {
                        $('#commentBox').html(response.comments);

                        $(".selected-option").on("click", function(e) {
                            $(this).next(".options").show(); // Show the dropdown
                        });

                        $(document).on("click", function(e) {
                            if (!$(e.target).closest(".custom-dropdown").length) {
                                $(".options").hide();
                            }
                        });

                        $(".edit-comment").on("click", function(e) {
                            e.preventDefault();
                            var commentId = $(this).data("comment-id");
                            $("#comment-text-" + commentId).hide();
                            $("#comment-edit-" + commentId).show();
                            const rightMsg = $(this).parents('.right-msg');
                            rightMsg.find('.comment-edit, .save-comment').show();
                            rightMsg.find('.options').hide();
                            $(this).hide();
                        });

                        $(".save-comment").on("click", function(e) {
                            e.preventDefault();
                            const commentId = $(this).data("comment-id");
                            $(this).parents('.right-msg').find('.edit-comment').show()
                            $(this).parent().prev().hide();
                            $(this).parent().prev().prev().show();
                            $(this).parents('.msg-bubble').find('.edit-comment').show();
                            $(this).hide();

                            let commentBody = $(this).parent().prev().val()
                            $.ajax({
                                url: "{{ route('issue.comment.update', ['commentId' => ':id']) }}".replace(':id', commentId),
                                type: "PATCH",
                                data: {
                                    _token: csrfToken,
                                    body: commentBody
                                },
                                success: function(response) {
                                    $("#comment-text-" + commentId).text(
                                        commentBody);
                                    toastr.options = {
                                        closeButton: true,
                                        progressBar: true,
                                    };
                                    toastr.success(response.success);
                                }
                            })
                        });
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        console.error('Error: ' + textStatus);
                        alert('An error occurred while loading comments.');
                    }
                });
                let deleteCommentId;
                let deleteComment;
                $(document).on('click', '.commentDelete', function() {
                    deleteCommentId = $(this).data("comment-id");
                    deleteComment = $(this);
                });

                $(document).on("click", "#comment-delete", function(event) {
                    event.preventDefault();
                    commentDelete(deleteCommentId, deleteComment);
                });

                function commentDelete(deleteCommentId, deleteComment) {
                    $.ajax({
                        url: "{{ route('issue.comment.destroy', ['commentId' => ':id']) }}".replace(':id',
                            deleteCommentId),
                        type: "delete",
                        data: {
                            _token: csrfToken,
                        },
                        success: function(response) {
                            $("#deleteComment").modal("toggle");
                            deleteComment.parents(".right-msg").hide();
                            toastr.options = {
                                closeButton: true,
                                progressBar: true,
                            };
                            toastr.success(response.success);
                        }
                    });
                }
            }
            commentBox();

            $("#commentDropdown").click(function() {
                $("#commentMenu").toggle();
            });

            $(".edit-comment").click(function() {
                alert("Edit Comment clicked");
                $("#commentMenu").hide();
            });

            $(".delete-comment").click(function() {
                alert("Delete Comment clicked");
                $("#commentMenu").hide();
            });

            $(document).click(function(event) {
                if (!$(event.target).closest(".dropdown").length) {
                    $("#commentMenu").hide();
                }
            });

            $(document).on("click", ".like", function() {
                event.preventDefault();
                var likeButton = $(this);
                $(this).addClass('active');
                let userId = $(this).data('user');
                let commentId = $(this).data('comment-id');

                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                var voteCountElement = likeButton.closest('.rating').next().children();
                var currentVoteCount = parseInt(voteCountElement.text());
                if (userId == true) {
                    var voteCountElement = likeButton.closest('.rating').next().children();
                    var currentVoteCount = parseInt(voteCountElement.text());

                    $.ajax({
                        url: "{{ route('issue.comment.upvote.destroy', ['commentId' => ':id']) }}"
                            .replace(':id', commentId),
                        type: 'DELETE',
                        data: {
                            _token: csrfToken,
                        },
                        success: function(response) {
                            likeButton.removeClass('active');

                            var voteCountElement = likeButton.closest('.rating').next()
                                .children();
                            var currentVoteCount = parseInt(voteCountElement.text());
                            var newVoteCount = currentVoteCount - 1;

                            if (newVoteCount == 1) {
                                likeButton.addClass('active');
                            }
                            voteCountElement.text(newVoteCount);
                            likeButton.data('user', false);
                        },
                        error: function(xhr, textStatus, errorThrown) {
                            console.error('Error: ' + textStatus);
                            alert('An error occurred while removing the upvote.');
                        }
                    });

                } else {
                    $.ajax({
                        url: "{{ route('issue.comment.upvote.post', ['commentId' => ':id']) }}"
                            .replace(':id', commentId),
                        type: "POST",
                        data: {
                            comment: commentId,
                            _token: csrfToken,
                        },
                        success: function(response) {
                            likeButton.addClass('active');
                            var newVoteCount = currentVoteCount + 1;
                            voteCountElement.text(newVoteCount);
                            likeButton.data('user', true);
                        },
                        error: function(xhr, textStatus, errorThrown) {
                            alert('An error occurred while upvoting.');
                        }
                    });
                }
            });


            $.validator.addMethod("valueNotEquals", function(value, element, arg) {
                return arg !== value;
            }, "{{ __('validation.valueNotEquals', ['attribute' => 'issue status']) }}");

            $("#issueEdit").validate({
                errorElement: "span",
                errorClass: "text-danger fw-normal",
                rules: {
                    status: {
                        required: true,
                        valueNotEquals: "default"
                    },
                    date: {
                        required: true
                    },
                },
                messages: {
                    status: {
                        required: "{{ __('validation.required', ['attribute' => 'status']) }}",
                        valueNotEquals: "{{ __('validation.valueNotEquals', ['attribute' => 'issue status']) }}",
                    },
                    date: {
                        date: "Please enter a valid date"
                    }
                },
                submitHandler: function(form) {
                    $(".loader-container").fadeIn();
                    let selectedStatus = $("select[name='status']").find(":selected").data("status");
                    let formData = $(form).serialize() + "&status=" + selectedStatus;
                    $.ajax({
                        url: $(form).attr("action"),
                        type: $(form).attr("method"),
                        data: formData,
                        success: function(response) {
                            $(".loader-container").fadeOut();

                            toastr.options = {
                                closeButton: true,
                                progressBar: true,
                            }
                            if (response.success) {
                                toastr.success(response.success);
                            } else {
                                toastr.error(response.error);
                            }
                            setTimeout(function() {
                                window.location.href =
                                    "{{ route('manager.issue.edit', ['issue' => $issue->id]) }}";
                            }, 2000);
                        },
                        error: function(xhr, status, error) {
                            $(".loader-container").fadeOut();
                            var response = JSON.parse(xhr.responseText);
                            var message = response.message;
                            toastr.options = {
                                closeButton: true,
                                progressBar: true,
                            }
                            toastr.error(message);
                        },
                    })
                },
            });

        });
    </script>
@endsection
