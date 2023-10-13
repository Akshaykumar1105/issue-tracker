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
    <section class="content" style="margin: 0 auto; max-width: 100%">
        <h1>Issues</h1>

        <div class=""
            style="margin-top:30px; padding:10px;border: 0 solid rgba(0,0,0,.125);
    border-radius: .25rem;background-color: #fff;box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);margin-bottom: 1rem;">
            <div class="d-flex">
                @if (!(request('type') == 'pending'))
                    <div class="me-3">
                        <label class="d-block font-weight-bold" style="width: 150px;">Priority</label>
                        <select id="selectPriority" class="custom-select custom-select-sm form-control form-control-sm">
                            <option value="">All</option>
                            <option value="LOW" {{ request('priority') == 'low' ? 'selected' : '' }}>Low</option>
                            <option value="MEDIUM" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="HIGH" {{ request('priority') == 'high' ? 'selected' : '' }}>High</option>
                        </select>
                    </div>

                    <div>
                        <label class="d-block font-weight-bold">Due date</label>
                        <input id="dueDate" type="date" value="{{ request('duedate') }}"
                            data-date-format="{{ config('date') }}" name="date" style="height: 31px;"
                            class="form-control">
                    </div>
                @endif

            </div>
            <table class="table" id="issue" style="width: 100%;">
                <thead>
                    <tr>
                        <th scope="col">{{ __('messages.table.id') }}</th>
                        <th style="width: 200px">{{ __('messages.table.title') }}</th>
                        @if (!Request::is('hr/issue?*'))
                            <th>{{ __('messages.table.priority') }}</th>
                            <th>{{ __('messages.table.due_date') }}</th>
                            <th>{{ __('messages.table.manager') }}</th>
                            <th>{{ __('messages.table.status') }}</th>
                        @endif

                        <th>{{ __('messages.table.action') }}</th>

                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
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
            let table = '';
            let status = '';
            var currentPath = window.location.pathname;

            table = 'hr';

            $('#issue').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('hr.issue.index') }}",
                    dataType: "JSON",
                    data: function(d) {
                        // Assign the value of the 'priority' variable to the 'filter' parameter
                        d.type = "{{ request('type') }}";
                        d.filter = priority;
                        d.duedate = date;
                        d.table = table;
                        d.status = status;
                    },
                }, // Route to your DataTablesController@index
                columns: [{
                        'data': 'DT_RowIndex',
                        'name': 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        'data': 'title',
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
                            console.log(data);
                            var date = data == null ? 'Not Select' : data;
                            return '<div class="form-check form-switch p-1">' + date +
                                '</div>';
                        },
                    },
                    {
                        "data": "user.name",
                        render: function(data, type, row) {
                            console.log(data);
                            var manager = data == null ? 'Not Assign' : data;
                            return '<div class="form-check form-switch p-1">' + manager +
                                '</div>';
                        },

                    },
                    {
                        "data": "status",
                        render: function(data, type, row) {
                            // console.log(data);
                            console.log(row);

                            // Define an array of status options with their values and labels
                            const statusOptions = [{
                                    value: 'default',
                                    label: 'Select Status'
                                },
                                {
                                    value: 'OPEN',
                                    label: 'Open'
                                },
                                {
                                    value: 'IN_PROGRESS',
                                    label: 'In Progress'
                                },
                                {
                                    value: 'ON_HOLD',
                                    label: 'On Hold'
                                },
                                {
                                    value: 'SEND_FOR_REVIEW',
                                    label: 'Send For Review'
                                },
                                {
                                    value: 'COMPLETED',
                                    label: 'Completed'
                                },
                                {
                                    value: 'CLOSE',
                                    label: 'Close'
                                },
                            ];

                            // Initialize the options HTML
                            let optionsHtml = '';

                            // Loop through the status options and build the HTML
                            for (const option of statusOptions) {
                                const selected = data === option.value ? 'selected' : '';
                                optionsHtml +=
                                    `<option value="${option.value}" data-status="${option.value}" ${selected}>${option.label}</option>`;
                            }

                            // Create the select element with the generated options
                            const selectHtml =
                                `<select name="status" data-status="${row.id}" id="status" class="custom-select custom-select-sm form-control form-control-sm">${optionsHtml}</select>`;

                            return selectHtml;
                        },
                    },
                    {
                        "data": "action",
                        orderable: false
                    },
                ],
                lengthMenu: [10, 25, 50, 100], // Define your page limit options
                pageLength: 10,
                order: [
                    [1, 'desc']
                ],
            });

            function filterUrl() {
                let filter = "{{ route('hr.issue.index') }}";
                let type = "{{ request('type') }}";

                if (type !== 'review-issue') {
                    filter += "?type=all-issue";
                } else {
                    filter += "?type=review-issue";
                }

                if (priority) {
                    filter += "&priority=" + priority.toLowerCase();
                }

                if (date) {
                    filter += "&duedate=" + date;
                }
                // Update the browser's URL without reloading the page
                history.pushState({}, '', filter);
            }


            $(document).on('change', "#selectPriority, #dueDate", function() {
                priority = $("#selectPriority").val();
                date = $("#dueDate").val();

                filterUrl();
                $('.table').DataTable().ajax.reload();
            });

            $(document).on('change', '#status', function() {
                status = $(this).val();
                let issueId = $(this).attr('data-status');
                // console.log(id);
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: "{{ route('hr.issue.update', ['issue' => ':id']) }}".replace(':id',
                        issueId),
                    type: 'patch',
                    data: {
                        status: status,
                        _token: csrfToken,
                    },
                    success: function(response) {
                        toastr.options = {
                            closeButton: true,
                            progressBar: true,
                        }
                        toastr.success(response.success);
                        $('.table').DataTable().ajax.reload();

                    },
                    error: function(xhr, status, error) {
                        var response = JSON.parse(xhr.responseText);
                        var message = response.message;
                        console.log(message)
                        toastr.options = {
                            closeButton: true,
                            progressBar: true,
                        }
                        toastr.error(message);
                        $('.table').DataTable().ajax.reload();
                    },
                })
            })
        });
    </script>
@endsection
