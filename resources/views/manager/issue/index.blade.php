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
    <section class="content" style="margin: 0 auto; max-width: 1050px">
        <h1>Issues</h1>



        <div
            class=""style="margin-top:70px; padding:10px;border: 0 solid rgba(0,0,0,.125);
    border-radius: .25rem;background-color: #fff;box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);margin-bottom: 1rem;">
            <div class="d-flex mb-3">
                <div class="me-3">
                    <label class="d-block font-weight-bold " style="width: 150px;">Priority</label>
                    <select id="selectPriority" class="custom-select custom-select-sm form-control form-control-sm">
                        <option value="">All</option>
                        <option value="LOW">Low</option>
                        <option value="MEDIUM">Medium</option>
                        <option value="HIGH">High</option>
                    </select>
                </div>

                <div>
                    <label class="d-block font-weight-bold">Due date </label>
                    <input id="dueDate" data-date-format="yyyy-mm-dd" name="date" style="height: 31px;"
                        class="datepicker form-control" data-provide="datepicker">
                </div>
            </div>
            <table class="table" id="issue">
                <thead>
                    <tr>
                        <th scope="col">{{ __('messages.table.id') }}</th>
                        <th>{{ __('messages.table.title') }}</th>
                        <th>Priority</th>
                        <th>Due Date</th>
                        <th>{{ __('messages.table.status') }}</th>
                        <th>{{ __('messages.table.action') }}</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="deleteManager" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Manager Delete</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Do you want to delete this manager!
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="managerDelete" class="btn btn-danger">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script src="{{ asset('asset/js/jquery.min.js') }}"></script>
    <script src="{{ asset('asset/js/jquery-datatables.min.js') }}"></script>
    <script src="{{ asset('asset/js/datatable.min.js') }}"></script>
    <script src="{{ asset('asset/js/datepicker.min.js') }}"></script>

    <script>
        // Your custom JavaScript file
        $(document).ready(function() {

            $('.datepicker').datepicker({
                // Date format to match your database date format
            });

            let priority = '';
            let date = '';

            $('#issue').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('manager.issue.index') }}",
                    dataType: "JSON",
                    data: function(d) {
                        d.filter = priority;
                        d.duedate = date;
                        d.table = 'manager';
                    }
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
                        "data": "priority"
                    },
                    {
                        "data": "due_date"
                    },
                    {
                        "data": "status",
                        render: function(data, type, row) {
                            // console.log(data);
                            console.log(row);

                            // Define an array of status options with their values and labels
                            const statusOptions = [
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

           

            $(document).on('change', "#selectPriority", function() {
                console.log($(this).val());
                priority = $(this).val();
                $('.table').DataTable().ajax.reload();
            });

         
            $(document).on('change', "#dueDate", function() {
                console.log($(this).val());
                date = $(this).val();
                $('.table').DataTable().ajax.reload();
            });

            $(document).on('change', '#status', function() {
                status = $(this).val();
                let issueId = $(this).attr('data-status');
                // console.log(id);
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: "{{ route('manager.issue.update', ['issue' => ':id']) }}".replace(':id', issueId),
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
