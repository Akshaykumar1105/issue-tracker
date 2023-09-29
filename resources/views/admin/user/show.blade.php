@extends('dashboard.layout.dashboard_layout')
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('style')
    <link href="{{ asset('asset/css/datatables.min.css') }}" rel="stylesheet">
@endsection
@section('content')
    <section class="content" style="margin: 0 auto; max-width: 1050px">
        <div class="" style="margin-bottom: 20px;">
            <h1>{{ $manager->name }} Managers</h1>
        </div>
        

        <div>
            <a href="{{route('admin.company.index')}}" style="float: right;" class="btn btn-outline-secondary">Back</a>
        </div>

        <div class=""
            style="padding: 10px;border: 0 solid rgba(0,0,0,.125);
    border-radius: .25rem;background-color: #fff;box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);margin-bottom: 1rem;margin-top: 5rem;">

            <table class="table" id="companyData">
                <thead>
                    <tr>
                        <th scope="col">{{ __('messages.table.id') }}</th>
                        <th>{{ __('messages.table.name') }}</th>
                        <th scope="col">{{ __('messages.table.email') }}</th>
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

            $('.table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.user.show', ['manager' => $manager]) }}",
                    dataType: "JSON",
                    data:{
                        listing: 'manager',
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
                        "data": "name",
                    },
                    {
                        "data": "email",
                    },
                ],
                lengthMenu: [10, 25, 50, 100], // Define your page limit options
                pageLength: 10,
            });
        });
    </script>
@endsection
