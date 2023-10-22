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
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: fill;
            object-position: center center;
        }
    </style>
    {{-- <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet"> --}}
@endsection
@section('content')
    <section class="content" style="margin: 0 auto; max-width: 100%">
        <h1>{{ __('messages.manager.title') }}</h1>
        <div class="" style="margin: 0 auto; float: right;">
            <a class="btn btn-primary" href="{{ route('hr.manager.create') }}">{{ __('messages.manager.register') }}</a>
        </div>


        <div class=""
            style="margin-top:70px; padding:10px;border: 0 solid rgba(0,0,0,.125);
    border-radius: .25rem;background-color: #fff;box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);margin-bottom: 1rem;">

            <table class="table" id="managerData" style="width: 100%;">
                <thead>
                    <tr>
                        <th scope="col">{{ __('messages.table.id') }}</th>
                        <th>{{ __('messages.table.profile') }}</th>
                        <th scope="col">{{ __('messages.table.name') }}</th>
                        <th scope="col">{{ __('messages.table.email') }}</th>
                        <th scope="col">{{ __('messages.table.number') }}</th>
                        <th style="width: 150px">{{ __('messages.table.action') }}</th>
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
                        {{__('messages.conformation.delete', ['attribute' => 'manager?'])}}
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
    <script src="{{ asset('asset/js/jquery-datatables.min.js') }}"></script>
    <script src="{{ asset('asset/js/datatable.min.js') }}"></script>

    <script>
        // Your custom JavaScript file
        $(document).ready(function() {

            $('#managerData').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('hr.manager.index') }}",
                    dataType: "JSON",

                },
                columns: [{
                        'data': 'DT_RowIndex',
                        'name': 'DT_RowIndex',
                        orderable: false,
                    },
                    {
                        'data': 'profile',
                        orderable: false,
                    },
                    {
                        "data": "name"
                    },
                    {
                        "data": "email"
                    },
                    {
                        "data": "mobile"
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


            let userid; 
            $(document).on("click", ".delete", function(event) {
                event.preventDefault();
                userid = $(this).attr("data-user-id");
            });

            $(document).on("click", "#deleteManager", function(event) {
                event.preventDefault();
                deleteManager(userid)
            });

            function deleteManager(userid) {
                $.ajax({
                    url: "{{ route('hr.manager.destroy', ['manager' => ':id']) }}".replace(':id', userid),
                    data: {
                        "id": userid,
                        "_token": "{{ csrf_token() }}"
                    },
                    type: "DELETE",
                    success: function(response) {
                        $("#deleteManager").modal("toggle");
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
