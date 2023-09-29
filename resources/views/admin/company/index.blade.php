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
    <section class="content" style="margin: 0 auto; max-width: 1050px">
        <h1>@lang('messages.company.title')</h1>
        <div class="" style="margin: 0 auto; float: right;">
            <a class="btn btn-primary" href="{{ route('admin.company.create') }}">@lang('messages.company.register')</a>
        </div>

        <div class=""
            style="margin-top: 70px;padding: 10px;border: 0 solid rgba(0,0,0,.125);
    border-radius: .25rem;background-color: #fff;box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);margin-bottom: 1rem;">

            <table class="table" id="companyData">
                <thead>
                    <tr>
                        <th >{{ __('messages.table.id') }}</th>
                        <th >{{ __('messages.table.status') }}</th>
                        <th >{{ __('messages.table.name') }}</th>
                        <th >{{ __('messages.table.email') }}</th>
                        <th style="width: 150px;box-sizing: border-box;" >{{ __('messages.table.number') }}</th>
                        <th style="width: 250px;box-sizing: border-box;" >{{ __('messages.table.address') }}</th>
                        <th style="width: 210px;box-sizing: border-box;">{{ __('messages.table.action') }}</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="deleteCompany" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Company Delete</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Do you want to delete this company!
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="companydelete" class="btn btn-danger">Delete</button>
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

            $('.table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.company.index') }}",
                    dataType: "JSON",
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        "data": "is_active",
                        render: function(data, type, row) {

                            var checked = data == 1 ? 'checked' : '';
                            return '<div class="form-check form-switch p-1"><input ' + checked +
                                ' data-userId=' + row.id + ' name="status" value="' + data +
                                '" class="status form-check-input m-0" type="checkbox" role="switch" /></div>';
                        },
                        searchable: false,
                        orderable: false,
                    },
                    {
                        "data": "name",
                    },
                    {
                        "data": "email",
                    },
                    {
                        "data": "number",
                    },
                    {
                        "data": "address",
                    },
                    {
                        "data": "action",
                        orderable: false,
                        searchable: false
                    },
                ],
                order: [
                    [2, 'desc']
                ],
                lengthMenu: [10, 25, 50, 100], // Define your page limit options
                pageLength: 10,
            });



            let company;
            $(document).on("click", ".delete", function(event) {
                event.preventDefault();
                company = $(this).attr("data-userId");
                // console.log(company);
            });

            $(document).on("click", "#companydelete", function(event) {
                event.preventDefault();
                Companydelete(company)
            });

            function Companydelete(company) {
                $.ajax({
                    url: "{{ route('admin.company.destroy', ['company' => "company"]) }}",
                    data: {
                        "id": company,
                        "_token": "{{ csrf_token() }}"
                    },
                    type: "DELETE",
                    success: function(response) {
                        $("#deleteCompany").modal("toggle");
                        var message = response.success;
                        console.log(message)
                        toastr.options = {
                            closeButton: true,
                            progressBar: true,
                        }
                        toastr.error(message);
                        $('.table').DataTable().ajax.reload();
                    }
                });
            }

            function statusChange(status, userId) {
                $.ajax({
                    url: "{{ route('admin.company.status') }}",
                    data: {
                        "status": status,
                        "userId": userId,
                        "_token": "{{ csrf_token() }}"
                    },
                    type: "POST",
                    success: function(response) {
                        var message = response.success;
                        console.log(message)
                        toastr.options = {
                            closeButton: true,
                            progressBar: true,
                        }
                        toastr.success(message);
                        $('.table').DataTable().ajax.reload();
                    }
                });
            }

            $(document).on("change", ".status", function(event) {
                event.preventDefault();
                let status = $(this).val();
                let userId = $(this).attr('data-userId');
                console.log(userId);
                console.log(status);
                statusChange(status, userId)
            });
        });
    </script>
@endsection