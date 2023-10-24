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
                        url: "{{ route('issue.comment.update', ['commentId' => ':id']) }}"
                            .replace(':id', commentId),
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
        let authId = $(this).data('authid');

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

                    var currentVoteCount = parseInt(voteCount.text());
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