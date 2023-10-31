@extends('dashboard.layout.master')
@section('style')
    {{-- <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet"> --}}
@endsection
@section('content')
    <section class="content pt-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="fw-bold">Issue Details</h4>
                        <hr>
                        @php
                            $issueId = $issue->id;
                        @endphp
                        <form id="issueEdit" method="post"
                            action="{{ route('admin.issue.update', ['issue' => $issue->id]) }}">
                            @csrf
                            @method('patch')
                            <div class="col-md-12 form-group">
                                <label class="fw-bold" for="title">Title</label>
                                <input id="title" name="title" class="form-control" type="text"
                                    value="{{ $issue->title }}">
                            </div>
                            <div class="col-md-12 form-group">
                                <label class="fw-bold" for="description">Description</label>
                                <input id="description" name="description" class="form-control" type="text"
                                    value="{{ $issue->description }}">
                            </div>

                            <div class="col-md-12 form-group">
                                <label for="email" class="form-label fw-bold">Priority<span
                                        class="text-danger ms-1">*</span></label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="priority" id="priority-low"
                                        value="LOW" {{ $issue->priority == 'LOW' ? 'checked' : 'checked' }}>
                                    <label class="form-check-label" for="priority-low">Low</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="priority" id="priority-medium"
                                        value="MEDIUM" {{ $issue->priority == 'MEDIUM' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="priority-medium">Medium</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="priority" id="priority-high"
                                        value="HIGH" {{ $issue->priority == 'HIGH' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="priority-high">High</label>
                                </div>
                                <span id="priority-error" class="text-danger"></span>
                            </div>

                            <div class="col-md-12 form-group">
                                <label for="hr_id" class="form-label fw-bold">Hr<span
                                        class="text-danger ms-1">*</span></label>
                                <select name="hr_id" id="selectHr" class="d-block form-control"
                                    style="appearance: revert;">
                                    <option value="">Select hr</option>
                                    @foreach ($hrs as $hr)
                                        <option value='{{ $hr->id }}'
                                            {{ $issue->hr_id == $hr->id ? 'selected' : '' }}>
                                            {{ $hr->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-12 form-group">
                                <label for="manager_id" class="form-label fw-bold">Assign To<span
                                        class="text-danger ms-1">*</span></label>
                                <select name="manager_id" id="manager" class="d-block form-control"
                                    style="appearance: revert;">
                                    <option value="">Select Manager</option>

                                </select>
                            </div>

                            <div class="col-md-12 form-group">
                                <label class="d-block font-weight-bold ">Due Date<span
                                        class="text-danger ms-1">*</span></label>
                                <input id="due_date" type="date" data-date-format="yyyy-mm-dd" name="due_date"
                                    class="datepicker d-block form-control" data-provide="datepicker"
                                    value="{{ $issue->due_date }}" placeholder="Select due date">
                            </div>

                            <div class="col-md-12 form-group">
                                <label for="email" class="form-label fw-bold">Status<span
                                        class="text-danger ms-1">*</span></label>
                                <select name="status" class="d-block form-control form-control"
                                    style="appearance: auto; font-size: 17px;">
                                    <option value="">Select Status</option>
                                    <option vlaue=OPEN data-status="OPEN" {{ $issue->status == 'OPEN' ? 'selected' : '' }}>
                                        Open</option>
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
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary ms-2 ">Update</button>

                                <a href="{{ $route }}" class="btn btn-outline-secondary my-0">Back</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#back').click(function() {
                window.history.back();
            });
            let currentRoute = "{{ Route::currentRouteName() }}";


            if (currentRoute == 'admin.issue.edit') {
                console.log("fghnjmk,");

                $(document).on('change', '#selectHr', function() {
                    hrId = $(this).val();
                    console.log(hrId);
                    let hr = $(this).attr('data-hr');
                    var condition = true;
                    var url = "{{ route('admin.issue.edit', ['issue' => ':id']) }}".replace(':id', hrId)
                    $.ajax({
                        url: url,
                        type: 'get',
                        data: {
                            hr_id: hrId
                        },
                        success: function(response) {
                            let option;
                            var managerSelect = $('#manager');
                            if (response !== null) {
                                $.each(response, function(index, user) {
                                    option += '<option value="' + user.id +
                                        '" ' + (user.id == hr ?
                                            'selected' : '') + '>' + user
                                        .name + '</option>';
                                });

                                managerSelect.html(option);
                            } else {
                                option +=
                                    '<option value=>No users found for this company.</option>';
                                managerSelect.html(option);
                            }
                        }
                    });
                })
            }

            $("#selectHr").trigger("change");

            $("#issueEdit").validate({
                rules: {
                    title: {
                        required: true,
                    },
                    description: {
                        required: true,
                    },
                    priority: {
                        required: true
                    },
                    status: {
                        required: true,
                    },
                    manager_id: {
                        required: true,
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
                                    "{{ route('admin.issue.edit', ['issue' => $issue->id]) }}";
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
