@extends('dashboard.layout.dashboard_layout')
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('style')
    <link href="{{ asset('asset/css/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('asset/css/datepicker.min.css') }}" rel="stylesheet">
    <style>
        .slow .toggle-group {
            transition: left 0.7s;
            -webkit-transition: left 0.7s;
        }

        .img {
            padding: 50px;
        }

        .image--cover {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            object-position: center right;
        }
    </style>
    {{-- <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet"> --}}
@endsection
@section('content')
    <section class="content pt-3">

        <!-- Default box -->
        <div class="card">
            <div class="card-header ">
                <h3 class="card-title">Issue Detail</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-12 ">

                        <div class="row">
                            {{-- @php
                              $issueId = $issue->id;   
                            @endphp --}}
                            <form method="post" action="{{ route('hr.issue.update', ['issue' => $issue->id]) }}"
                                id="issueEdit">
                                @method('patch')
                                @csrf

                                <div class="col-md-12 mt-3 d-flex">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold" for="name">Title</label>
                                        <p>{{ $issue->title }}</p>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-3">

                                </div>

                                <div class="col-md-12 mt-4">
                                    <label class="form-label fw-bold" for="name">Description</label>
                                    <p class="">{{ $issue->description }}</p>
                                </div>



                                <div class="col-md-4 form-group">
                                    <label for="email" class="form-label fw-bold">Priority<span
                                            class="text-danger ms-1">*</span></label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="priority" id="priority-low"
                                            value="LOW" {{ $issue->priority == 'LOW' ? 'checked' : '' }} checked>
                                        <label class="form-check-label" for="priority-low">
                                            Low
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="priority" id="priority-medium"
                                            value="MEDIUM" {{ $issue->priority == 'MEDIUM' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="priority-medium">
                                            Medium
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="priority" id="priority-high"
                                            value="HIGH" {{ $issue->priority == 'high' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="priority-high">
                                            High
                                        </label>
                                    </div>
                                    <span id="priority-error" class="text-danger"></span>
                                </div>

                                <div class="col-md-4 form-group">
                                    <label for="manager_id" class="form-label fw-bold">Assign To<span
                                            class="text-danger ms-1">*</span></label>
                                    <select name="manager_id" class="d-block form-control-sm">
                                        <option value="default">Select Manager</option>
                                        @foreach ($managers as $manager)
                                            <option value='{{ $manager->id }}'
                                                {{ $issue->manager_id == $manager->id ? 'selected' : '' }}>
                                                {{ $manager->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4 form-group">
                                    <label for="email" class="form-label fw-bold">Status<span
                                            class="text-danger ms-1">*</span></label>
                                    <select name="status" class="d-block form-control-sm">
                                        <option value="default">Select Status</option>
                                        <option vlaue="OPEN" data-status="OPEN"
                                            {{ $issue->status == 'OPEN' ? 'selected' : '' }}>Open</option>
                                        <option vlaue="IN_PROGRESS" data-status="IN_PROGRESS"
                                            {{ $issue->status == 'IN_PROGRESS' ? 'selected' : '' }}>In Progress</option>
                                        <option value="ON_HOLD" data-status="ON_HOLD"
                                            {{ $issue->status == 'ON_HOLD' ? 'selected' : '' }}>On Hold</option>
                                        <option value="SEND_FOR_REVIEW" data-status="SEND_FOR_REVIEW"
                                            {{ $issue->status == 'SEND_FOR_REVIEW' ? 'selected' : '' }}>Send For Review
                                        </option>
                                        <option value="COMPLETED" data-status="COMPLETED"
                                            {{ $issue->status == 'COMPLETED' ? 'selected' : '' }}>Completed</option>
                                        <option vlaue="CLOSE" data-status="CLOSE"
                                            {{ $issue->status == 'CLOSE' ? 'selected' : '' }}>Close</option>
                                    </select>
                                </div>

                                <div class="col-md-4 form-group">
                                    <label class="d-block font-weight-bold ">Due Date<span
                                            class="text-danger ms-1">*</span></label>
                                    <input id="due_date" data-date-format="yyyy-mm-dd" name="due_date"
                                        class="datepicker d-block" data-provide="datepicker" value="{{ $issue->due_date }}"
                                        placeholder="Select due date">
                                </div>

                                {{-- <button type="submit" class="btn btn-primary ms-2 mb-2">Submit</button> --}}
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary me-3">Submit</button>
                                    <a href="{{ route('hr.issue.index') }}" class="btn btn-outline-secondary">Back</a>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- /.card-body -->

        <!-- /.card -->




    </section>
@endsection

@section('script')
    <script src="{{ asset('asset/js/jquery-datatables.min.js') }}"></script>
    <script src="{{ asset('asset/js/datatable.min.js') }}"></script>
    <script src="{{ asset('asset/js/datepicker.min.js') }}"></script>
    <script>
        // Your custom JavaScript file
        $(document).ready(function() {
            $('.datepicker').datepicker({
                // Date format to match your database date format

            });

            $.validator.addMethod("valueNotEquals", function(value, element, arg) {
                return arg !== value;
            }, "Please select a company from the list.");

            $("#issueEdit").validate({
                errorElement: "span",
                errorClass: "text-danger",
                rules: {
                    priority: {
                        required: true // Priority radio button is required
                    },
                    status: {
                        required: true,
                        valueNotEquals: "default" // Status dropdown is required
                    },
                    manager_id: {
                        required: true,
                        valueNotEquals: "default"
                    },
                    due_date: {
                        required: true // Validate that the date is in a valid format
                    },
                },
                messages: {
                    priority: {
                        required: "Please select a priority"
                    },
                    status: {
                        required: "Please select a status",
                        valueNotEquals: "Please select issue status!",
                    },
                    manager_id: {
                        required: "Please select a status",
                        valueNotEquals: "Please select issue status!",
                    },
                    due_date: {
                        date: "Please enter a valid date"
                    }
                },
                submitHandler: function(form) {
                    let selectedStatus = $("select[name='status']").find(":selected").data("status");
                    let formData = $(form).serialize() + "&status=" + selectedStatus;
                    $.ajax({
                        url: $(form).attr("action"),
                        type: $(form).attr("method"),
                        data: formData,
                        success: function(response) {
                            toastr.options = {
                                closeButton: true,
                                progressBar: true,
                            }
                            toastr.success(response.success);
                            setTimeout(function() {
                                window.location.href = response.route;
                            }, 2000);
                        },
                        error: function(xhr, status, error) {
                            // Handle error response
                            // console.log("Form submission error");
                            var response = JSON.parse(xhr.responseText);
                            var message = response.message;
                            console.log(message)
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
