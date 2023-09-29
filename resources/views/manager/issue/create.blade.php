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
                            @php
                                $issueId = $issue->id;
                            @endphp
                            <form method="post" action="{{ route('manager.issue.update', ['issue' => $issueId]) }}"
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

                                <div class="col-md-12 d-flex mt-5">

                                    <div class="col-md-6 p-0">
                                        <label for="email" class="form-label fw-bold">Priority</label>
                                        <p>{{ $issue->priority }}</p>
                                    </div>

                                    <div class="col-md-6 p-0">
                                        <label class="d-block font-weight-bold">Due Date</label>
                                        <p>{{ $issue->due_date }}</p>
                                    </div>

                                </div>

                                <div class="col-md-3 form-group">
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
                                <div>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <a href="{{ route('manager.issue.index') }}" class="btn btn-outline-secondary">Back</a>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- /.card-body -->

        <!-- /.card -->

        {{-- <div class="container mt-4">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Issue Detail</h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label fw-bold" for="title">Title:</label>
                                <p>{{ $issue->title }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold" for="excerpt">Excerpt:</label>
                                <p>{{ $issue->excerpt }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold" for="description">Description:</label>
                                <p>{{ $issue->description }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-4">
                        <div class="card-header">
                            <h3 class="card-title">Assign Manager, Status, and Due Date</h3>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('issue.update', ['issue' => $issue->id]) }}"
                                id="issueEdit">
                                @method('patch')
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label fw-bold" for="priority">Priority:</label>
                                    <p>{{$issue->priority}}</p>
                                </div>
                               
                                <div class="mb-3">
                                    <label class="form-label fw-bold" for="status">Status:</label>
                                    <select name="status" class="form-select">
                                        <option value="default">Select Status</option>
                                        <option vlaue="OPEN" {{ $issue->status == 'OPEN' ? 'selected' : '' }}>Open
                                        </option>
                                        <option vlaue="IN_PROGRESS"
                                            {{ $issue->status == 'IN_PROGRESS' ? 'selected' : '' }}>In Progress</option>
                                        <option value="ON_HOLD">On Hold</option>
                                        <option value="SEND_FOR_REVIEW">Send For Review</option>
                                        <option value="COMPLETED">Completed</option>
                                        <option vlaue="CLOSE">Close</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold" for="dueDate">Due Date:</label>
                                    
                                    <p>{{ $issue->due_date }}</p>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Chat</h3>
                        </div>
                        <div class="card-body">
                            <!-- Add your chat section here -->
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}


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
                    assignManager: {
                        required: true,
                        valueNotEquals: "default"
                    },
                    date: {
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
                    assignManager: {
                        required: "Please select a status",
                        valueNotEquals: "Please select issue status!",
                    },
                    date: {
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
