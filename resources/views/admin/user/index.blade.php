@extends('dashboard.layout.master')
@section('style')
    <link href="{{ asset('asset/css/datatables.min.css') }}" rel="stylesheet">
    <style>
        .slow .toggle-group {
            transition: left 0.7s;
            -webkit-transition: left 0.7s;
        }

        .img {
            padding: 50px;
        }

        .image--cover {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: fill;
            object-position: center center;
        }
    </style>
@endsection
@section('content')
    <section class="content" style="margin: 0 auto; max-width: 100%">
        <div class="" style="margin-bottom: 20px;">
            @if (Route::currentRouteName() == 'admin.manager.index')
                <h1>Managers</h1>
            @else
                <h1>Hr</h1>
            @endif
        </div>

        <div class="" style="margin: 0 auto; float: right;">
            <a class="btn btn-primary"
                href="{{ Route::currentRouteName() === 'admin.hr.index' ? route('admin.hr.create') : route('admin.manager.create') }}">
                {{ Route::currentRouteName() === 'admin.hr.index' ? __('messages.create', ['attribute' => 'Hr']) : __('messages.create', ['attribute' => 'Manager']) }}
            </a>
        </div>


        <div
            class=""style="margin-top:70px;padding: 10px;border: 0 solid rgba(0,0,0,.125);border-radius: .25rem;background-color: #fff;box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,.2);margin-bottom: 1rem;">

            <div class="d-flex" style="gap:20px;">
                <div class="mb-3" style="flex-grow: .11;">
                    <label class="d-block">Company</label>
                    <select id="selectCompany" class="custom-select custom-select-sm form-control form-control-sm ">
                        <option value="">Select company</option>
                        @foreach ($companies as $company)
                            <option value="{{ $company->id }}"
                                {{ request('company_id') == $company->id ? 'selected' : '' }}>
                                {{ $company->name }}</option>
                        @endforeach
                    </select>
                </div>

                @if (Route::currentRouteName() == 'admin.manager.index')
                    <div style="flex-grow: .1;">
                        <label class="d-block">Hr</label>
                        <select id="selectHr" class="custom-select custom-select-sm form-control form-control-sm">
                            <option value="">Select Hr</option>
                            @foreach ($hrs as $hr)
                                <option value="{{ $hr->id }}" {{ request('hr_id') == $hr->id ? 'selected' : '' }}>
                                    {{ $hr->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @else
                @endif
            </div>

            <table class="table" id="companyData" style="width: 100%">
                <thead>
                    <tr>
                        <th scope="col">{{ __('messages.table.id') }}</th>
                        <th>{{ __('messages.table.profile') }}</th>
                        <th>{{ __('messages.table.name') }}</th>
                        <th scope="col">{{ __('messages.table.email') }}</th>
                        <th>{{ __('messages.table.company') }}</th>
                        @if (Route::currentRouteName() == 'admin.hr.index')
                        @else
                            <th>{{ __('messages.table.hr') }}</th>
                        @endif
                        <th>{{ __('messages.table.action') }}</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>

        <div class="modal fade" id="deleteUser" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Company Delete</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @if (Route::currentRouteName() == 'admin.hr.index')
                            {{ __('messages.conformation.delete', ['attribute' => 'Hr?']) }}
                        @else
                            {{ __('messages.conformation.delete', ['attribute' => 'Manager?']) }}
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="deleteUser" class="btn btn-danger">Delete</button>
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
        $(document).ready(function() {
            let company = "";
            let hr = '';
            let newUrl = '';
            let currentRoute = '{{ Route::currentRouteName() }}';

            let filter;

            if (currentRoute == 'admin.manager.index') {
                filter = "{{ route('admin.manager.index') }}";
            } else if (currentRoute == 'admin.hr.index') {
                filter = "{{ route('admin.hr.index') }}";
            }

            function filterUrl() {
                let queryParams = [];

                if (company) queryParams.push("company_id=" + company.toLowerCase());
                if (hr) queryParams.push("hr_id=" + hr);
                const queryString = queryParams.join("&");
                const filterWithQuery = queryString ? filter + "?" + queryString : filter;
                history.pushState({}, '', filterWithQuery);
            }

            $(document).on('change', "#selectCompany", function() {
                company = $(this).val();
                filterUrl();
                $('.table').DataTable().ajax.url(newUrl).load();
            });

            $(document).on('change', "#selectHr", function() {
                hr = $(this).val();
                filterUrl();
                $('.table').DataTable().ajax.url(newUrl).load();
            });

            let ajaxUrl = currentRoute === 'admin.manager.index' ? "{{ route('admin.manager.index') }}" :
                "{{ route('admin.hr.index') }}";

            $('.table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: ajaxUrl,
                    dataType: "JSON",
                    data: function(d) {
                        let urlParams = new URLSearchParams(window.location.search);
                        d.filter = urlParams.get('company_id') || "";
                        d.hr = urlParams.get('hr_id') || "";
                        d.role = "{{ config('site.role.admin') }}";
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
                        "data": "profile",
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
                    @if (Route::currentRouteName() !== 'admin.hr.index')
                        {
                            "data": "hr_user.name",
                        },
                    @endif {
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

            let userId;
            $(document).on("click", ".delete", function(event) {
                event.preventDefault();
                userId = $(this).attr("data-user-id");
            });


            $(document).on("click", "#deleteUser", function(event) {
                event.preventDefault();
                deleteUser(userId)
            });

            function deleteUser(userId) {
                let deleteUser;
                if (currentRoute == 'admin.manager.index') {
                    deleteUser = "{{ route('admin.manager.destroy', ['manager' => ':id']) }}".replace(':id',
                        userId);
                } else {
                    deleteUser = "{{ route('admin.hr.destroy', ['hr' => ':id']) }}".replace(':id', userId);
                }
                $.ajax({
                    url: deleteUser,
                    data: {
                        "id": userId,
                        "_token": "{{ csrf_token() }}"
                    },
                    type: "DELETE",
                    success: function(response) {
                        $("#deleteUser").modal("toggle");
                        const message = response.success;
                        toastr.options = {
                            closeButton: true,
                            progressBar: true,
                        }
                        toastr.success(message);
                        $('.table').DataTable().ajax.reload();
                    }
                });
            }
        });
    </script>
@endsection
