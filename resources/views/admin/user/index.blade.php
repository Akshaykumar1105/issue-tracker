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
            @if (request('listing') === 'manager')
                <h1>Managers</h1>
            @else
                <h1>Hr</h1>
            @endif
        </div>


        <div
            class=""style="padding: 10px;border: 0 solid rgba(0,0,0,.125);border-radius: .25rem;background-color: #fff;box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,.2);margin-bottom: 1rem;">

            <div class="mb-3">
                <label class="d-block">Company</label>
                <select id="selectCompany" class="custom-select custom-select-sm form-control form-control-sm w-25">
                    <option value="">Select company</option>
                    @foreach ($companies as $company)
                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                    @endforeach
                </select>
            </div>

            <table class="table" id="companyData">
                <thead>
                    <tr>
                        <th scope="col">{{ __('messages.table.id') }}</th>
                        <th>{{ __('messages.table.name') }}</th>
                        <th scope="col">{{ __('messages.table.email') }}</th>
                        <th>Company</th>
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
        $(document).ready(function() {
            let company = "";
            $(document).on('change', "#selectCompany", function() {
                console.log($(this).val());
                company = $(this).val();
                $('.table').DataTable().ajax.reload();
            });

            $('.table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.user.index') }}",
                    dataType: "JSON",
                    data: function(d) {
                        d.listing = "{{ request('listing') }}";
                        d.filter = company;
                    }
                },
                columns: [{
                        "data": null,
                        "sortable": false,
                        "searchable": false,
                        render: function(data, type, row, meta) {
                            console.log(data);
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        "data": "name",
                    },
                    {
                        "data": "email",
                    },
                    {
                        "data": "company.name",
                    },
                    {
                        "data": "action",
                        orderable: false,
                        searchable: false
                    },
                ],
                order: [
                    [1, 'desc']
                ],
                lengthMenu: [10, 25, 50, 100], // Define your page limit options
                pageLength: 10,
            });

        });
    </script>
@endsection
