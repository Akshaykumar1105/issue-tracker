@extends('dashboard.layout.master')
@section('style')
    <link href="{{ asset('asset/css/datatables.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                            <form method="post" action="{{ route('hr.issue.update', ['issue' => $issue->id]) }}"
                                id="issueEdit">
                                @method('patch')
                                @csrf

                                <div class="col-md-12 mt-3 ">
                                    <label class="form-label fw-bold" for="name">Title</label>
                                    <p>{{ $issue->title }}</p>
                                </div>

                                <div class="col-md-12 mt-4">
                                    <label class="form-label fw-bold" for="name">Description</label>
                                    <p class="">{{ $issue->description }}</p>
                                </div>

                                @if ($issue->status !== 'COMPLETED')
                                    <div class="col-md-4 form-group">
                                        <label for="email" class="form-label fw-bold">Priority<span
                                                class="text-danger ms-1">*</span></label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="priority" id="priority-low"
                                                value="LOW" {{ $issue->priority == 'LOW' ? 'checked' : 'checked' }}>
                                            <label class="form-check-label" for="priority-low">Low</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="priority"
                                                id="priority-medium" value="MEDIUM"
                                                {{ $issue->priority == 'MEDIUM' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="priority-medium">Medium</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="priority"
                                                id="priority-high" value="HIGH"
                                                {{ $issue->priority == 'HIGH' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="priority-high">High</label>
                                        </div>
                                        <span id="priority-error" class="text-danger"></span>
                                    </div>

                                    <div class="col-md-4 form-group">
                                        <label for="manager_id" class="form-label fw-bold">Assign To<span
                                                class="text-danger ms-1">*</span></label>
                                        <select name="manager_id" class="d-block form-control" style="appearance: revert;">
                                            <option value="default">Select Manager</option>
                                            @foreach ($managers as $manager)
                                                <option value='{{ $manager->id }}'
                                                    {{ $issue->manager_id == $manager->id ? 'selected' : '' }}>
                                                    {{ $manager->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-4 form-group">
                                        <label class="d-block font-weight-bold ">Due Date<span
                                                class="text-danger ms-1">*</span></label>
                                        <input id="due_date" type="date" data-date-format="yyyy-mm-dd" name="due_date"
                                            class="datepicker d-block form-control" data-provide="datepicker"
                                            value="{{ $issue->due_date }}" placeholder="Select due date">
                                    </div>

                                    <div class="col-md-4 form-group">
                                        <label for="email" class="form-label fw-bold">Status<span
                                                class="text-danger ms-1">*</span></label>
                                        <select name="status" class="d-block form-control form-control"
                                            style="appearance: auto;">
                                            <option value="default">Select Status</option>
                                            <option vlaue=OPEN data-status="OPEN"
                                                {{ $issue->status == 'OPEN' ? 'selected' : '' }}>Open</option>
                                            <option vlaue=IN_PROGRESS data-status="IN_PROGRESS"
                                                {{ $issue->status == 'IN_PROGRESS' ? 'selected' : '' }}>In Progress
                                            </option>
                                            <option value=ON_HOLD data-status="ON_HOLD"
                                                {{ $issue->status == 'ON_HOLD' ? 'selected' : '' }}>On Hold</option>
                                            <option value="SEND_FOR_REVIEW" data-status="SEND_FOR_REVIEW"
                                                {{ $issue->status == 'SEND_FOR_REVIEW' ? 'selected' : '' }}>Send For Review
                                            </option>
                                            <option value=COMPLETED data-status="COMPLETED"
                                                {{ $issue->status == 'COMPLETED' ? 'selected' : '' }}>Completed</option>
                                            <option vlaue=CLOSE data-status="CLOSE"
                                                {{ $issue->status == 'CLOSE' ? 'selected' : '' }}>Close</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4 form-group">
                                        <label class="d-block font-weight-bold ">Comment</label>
                                        <input id="body" data-date-format="yyyy-mm-dd" name="body"
                                            class="d-block form-control" placeholder="Enter your comment">
                                    </div>
                                @else
                                    <div class="col-md-12 mt-4">
                                        <label class="form-label fw-bold" for="name">Priority</label>
                                        <p class="">{{ ucwords(strtolower($issue->priority)) }}</p>
                                    </div>
                                    <div class="col-md-12 mt-4">
                                        <label class="form-label fw-bold" for="name">Assign to</label>
                                        <p class="">{{ $issue->manager->name }}</p>
                                    </div>
                                    <div class="col-md-12 mt-4">
                                        <label class="form-label fw-bold" for="name">Status</label>
                                        <p class="">{{ str_replace('_', ' ', ucwords(strtolower($issue->status))) }}
                                        </p>
                                    </div>
                                    <div class="col-md-12 mt-4">
                                        <label class="form-label fw-bold" for="name">Due date</label>
                                        <p class="">{{ date(config('site.date'), strtotime($issue->due_date)) }}</p>
                                    </div>
                                @endif


                                <div class="col-md-4 d-flex " style="gap:10px;">
                                    @if ($issue->status == 'COMPLETED')
                                    @else
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    @endif
                                    <a href="{{ route('hr.issue.index', ['type' => 'all-issue']) }}"
                                        class="btn btn-outline-secondary">Back</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div id="commentBox" style="margin-bottom: 30px"></div>

    <div class="modal fade" id="deleteComment" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Comment Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">{{ __('messages.conformation.delete', ['attribute' => 'comment?']) }}</div>
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
    <script>
        $(document).ready(function() {
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
                            $(this).next(".options").show();
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
                            $(this).parents('.right-msg').find('.comment-edit, .save-comment').show();
                            $(this).parents('.right-msg').find('.options').hide();
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
                                url: "{{ route('issue.comment.update', ['commentId' => ':id']) }}"
                                    .replace(':id', commentId),
                                type: "PATCH",
                                data: {
                                    _token: csrfToken,
                                    body: commentBody
                                },
                                success: function(response) {
                                    $("#comment-text-" + commentId).text(commentBody);
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
                            var message = response.success;
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

            $(document).on("click", ".like", function() {
                event.preventDefault();
                var likeButton = $(this);
                $(this).addClass('active');
                let upvote = $(this).data('upvote');
                let userId = $(this).data('user');
                let commentId = $(this).data('comment-id');

                var voteCount = likeButton.closest('.rating').next().children();
                var currentVoteCount = parseInt(voteCount.text());
                if (userId == true) {
                    $.ajax({
                        url: "{{ route('issue.comment.upvote.destroy', ['commentId' => ':id']) }}"
                            .replace(':id', commentId),
                        type: 'DELETE',
                        data: {
                            _token: csrfToken,
                        },
                        success: function(response) {
                            likeButton.removeClass('active');
                            var newVoteCount = currentVoteCount - 1;
                            if (newVoteCount == 1) {
                                likeButton.addClass('active');
                            }
                            voteCount.text(newVoteCount);
                            likeButton.data('user', false);
                        },
                        error: function(xhr, textStatus, errorThrown) {
                            console.error('An error occurred while removing the upvote.');
                        }
                    });

                } else {
                    $.ajax({
                        url: "{{ route('issue.comment.upvote.post', ['commentId' => ':id']) }}".replace(':id', commentId),
                        type: "POST",
                        data: {
                            comment: commentId,
                            _token: csrfToken,
                        },
                        success: function(response) {
                            likeButton.addClass('active');
                            var newVoteCount = currentVoteCount + 1;
                            voteCount.text(newVoteCount);
                            likeButton.data('user', true);
                        },
                        error: function(xhr, textStatus, errorThrown) {
                            console.error('An error occurred while upvoting.');
                        }
                    });
                }
            });

            $.validator.addMethod("valueNotEquals", function(value, element, arg) {
                return arg !== value;
            }, "Please select a company from the list.");

            $("#issueEdit").validate({
                errorElement: "span",
                errorClass: "text-danger fw-normal",
                rules: {
                    priority: {
                        required: true
                    },
                    status: {
                        required: true,
                        valueNotEquals: "default"
                    },
                    manager_id: {
                        required: true,
                        valueNotEquals: "default"
                    },
                    due_date: {
                        required: true
                    },
                },
                messages: {
                    priority: {
                        required: "{{ __('validation.required', ['attribute' => 'priority']) }}",
                    },
                    status: {
                        required: "{{ __('validation.required', ['attribute' => 'status']) }}",
                        valueNotEquals: "{{ __('validation.valueNotEquals', ['attribute' => 'issue status']) }}",
                    },
                    assignManager: {
                        required: "{{ __('validation.required', ['attribute' => 'manager']) }}",
                        valueNotEquals: "{{ __('validation.valueNotEquals', ['attribute' => 'manager']) }}",
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
                            toastr.success(response.success);
                            setTimeout(function() {
                                window.location.href =
                                    "{{ route('hr.issue.edit', ['issue' => $issue->id]) }}";
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
