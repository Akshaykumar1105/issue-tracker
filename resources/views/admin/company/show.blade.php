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
        @if (request('listing') === 'manager')
            <h1>Managers</h1>
        @else
            <h1>Hr</h1>
        @endif
        <div>
            <a href="{{ route('admin.company.index') }}" style="float: right;" class="btn btn-outline-secondary">Back</a>
        </div>
        <div class=""
            style="margin-top: 70px;padding: 10px;border: 0 solid rgba(0,0,0,.125);
    border-radius: .25rem;background-color: #fff;box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);margin-bottom: 1rem;">

            <table class="table" id="companyData" style="width: 100%;">
                <thead>
                    <tr>
                        <th scope="col">{{ __('messages.table.id') }}</th>
                        <th>{{ __('messages.table.profile') }}</th>
                        <th>{{ __('messages.table.name') }}</th>
                        <th scope="col">{{ __('messages.table.email') }}</th>
                        <th scope="col">Mobile</th>

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
                    url: "{{ route('admin.company.show', ['company' => $company]) }}",
                    dataType: "JSON",
                    data: function(d) {
                        d.listing = "{{ request('listing') }}";
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        "data": "profile",
                    },
                    {
                        "data": "name",
                    },
                    {
                        "data": "email",
                    },
                    {
                        "data": "mobile",
                    },
                ],
                order: [
                    [2, 'desc']
                ],
                lengthMenu: [10, 25, 50, 100], // Define your page limit options
                pageLength: 10,
            });
        });
    </script>
@endsection
