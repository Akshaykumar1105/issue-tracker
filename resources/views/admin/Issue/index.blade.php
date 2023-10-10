@extends('dashboard.layout.dashboard_layout')
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('style')
    {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" /> --}}
    <link href="{{ asset('asset/css/datatables.min.css') }}" rel="stylesheet">

    <style>
        .slow .toggle-group {
            transition: left 0.7s;
            -webkit-transition: left 0.7s;
        }
    </style>
@endsection
@section('content')
    <section class="content" style="margin: 0 auto; max-width: 100%">
        <h1>Issue</h1>

        <div
            class=""style="margin-top:40px;padding: 10px;border: 0 solid rgba(0,0,0,.125); border-radius: .25rem;background-color: #fff;box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);margin-bottom: 1rem;">

            <div class="d-flex mb-2">
                <div class="me-3" style="width: 200px;">
                    <label class="d-block">Company</label>
                    <select id="selectCompany" class="custom-select custom-select-sm form-control form-control-sm ">
                        <option value="">Select company</option>
                        @foreach ($companies as $company)
                            <option value="{{ $company->id }}"
                                {{ request('company_id') == $company->id ? 'selected' : '' }}>{{ $company->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="me-3">
                    <label class="d-block font-weight-bold " style="width: 150px;">Priority</label>
                    <select id="selectPriority" class="custom-select custom-select-sm form-control form-control-sm">
                        <option value="">All</option>
                        <option value="LOW" {{ request('priority') == 'low' ? 'selected' : '' }}>Low</option>
                        <option value="MEDIUM" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="HIGH" {{ request('priority') == 'high' ? 'selected' : '' }}>High</option>
                    </select>
                </div>

                <div>
                    <label class="d-block font-weight-bold">Due date </label>
                    <input id="dueDate" type="date" value="{{ request('duedate') }}"
                        data-date-format="{{ config('date') }}" name="date" style="height: 31px;" class="form-control">
                </div>
            </div>

            <table class="table" id="companyData" style="width: 100%;">
                <thead>
                    <tr>
                        <th>{{ __('messages.table.id') }}</th>
                        <th style="width: 200px">{{ __('messages.table.title') }}</th>
                        <th>{{ __('messages.table.company') }}</th>
                        <th>{{ __('messages.table.priority') }}</th>
                        <th>{{ __('messages.table.due_date') }}</th>
                        <th>{{ __('messages.table.action') }}</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>

        <!-- Modal -->

        <div class="modal fade" id="deleteIssue" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Company Delete</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Do you want to delete this issue!
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="issuedelete" class="btn btn-danger">Delete</button>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection

@section('script')
    <script src="{{ asset('asset/js/jquery-datatables.min.js') }}"></script>
    <script src="{{ asset('asset/js/datatable.min.js') }}"></script>
    <script>
        // Your custom JavaScript file
        $(document).ready(function() {

            let priority = '';
            let date = '';
            let company = '';
            $('.table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.issue.index') }}",
                    dataType: "JSON",
                    data: function(d) {
                        // Assign the value of the 'priority' variable to the 'filter' parameter
                        d.filter = priority;
                        d.duedate = date;
                        d.table = 'admin';
                        d.company = company;
                    }
                },
                columns: [{
                        "data": null,
                        "sortable": false,
                        "searchable": false,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        "data": "title",
                    },
                    {
                        "data": "company.name",
                    },
                    {
                        "data": "priority",
                        render: function(data, type, row) {
                            var colorClass = '';
                            switch (data) {
                                case 'LOW':
                                    colorClass =
                                        'badge bg-success'; // CSS class for low priority (green color)
                                    break;
                                case 'MEDIUM':
                                    colorClass =
                                        'badge bg-yellow'; // CSS class for medium priority (yellow color)
                                    break;
                                case 'HIGH':
                                    colorClass =
                                        'badge bg-red'; // CSS class for high priority (red color)
                                    break;
                                default:
                                    colorClass = ''; // Default class
                            }
                            return '<div style="width:70px" class="' + colorClass +
                                ' bg-opacity-75">' + data + '</div>';
                        }
                    },
                    {
                        "data": "due_date",
                        render: function(data, type, row) {
                            var date = data == null ? 'Not select due date' : data;
                            return '<div class="form-check form-switch p-1">' + date + '</div>';
                        },
                    },
                    {
                        "data": "action"
                    }
                ],
                lengthMenu: [10, 25, 50, 100], // Define your page limit options
                pageLength: 10,
                order: [
                    [1, 'desc']
                ],
            });

            function filterUrl() {
                let filter = "{{ route('admin.issue.index') }}";

                // Define an array to store query parameters
                const queryParams = [];

                if (company) {
                    queryParams.push("company_id=" + company.toLowerCase());
                }

                if (priority) {
                    queryParams.push("priority=" + priority.toLowerCase());
                }

                if (date) {
                    queryParams.push("duedate=" + date);
                }

                // Append the query parameters to the URL
                if (queryParams.length > 0) {
                    filter += "?" + queryParams.join("&");
                }

                history.pushState({}, '', filter);
            }

            $(document).on('change', "#selectPriority, #dueDate, #selectCompany", function() {
                priority = $("#selectPriority").val();
                date = $("#dueDate").val();
                company = $("#selectCompany").val();

                filterUrl();
                $('.table').DataTable().ajax.reload();
            });

            let issue;
            $(document).on("click", ".delete", function(event) {
                event.preventDefault();
                issue = $(this).attr("data-issueid");
            });

            $(document).on("click", "#issuedelete", function(event) {
                event.preventDefault();
                Companydelete(issue)
            });

            function Companydelete(issue) {
                $.ajax({
                    url: "{{ route('admin.issue.destroy', ['issue' => 'issue']) }}",
                    data: {
                        "id": issue,
                        "_token": "{{ csrf_token() }}"
                    },
                    type: "DELETE",
                    success: function(response) {
                        $("#deleteIssue").modal("toggle");
                        var message = response.success;
                        toastr.options = {
                            closeButton: true,
                            progressBar: true,
                        }
                        toastr.error(message);
                        $('.table').DataTable().ajax.reload();
                    }
                });
            }

        });
    </script>
@endsection
