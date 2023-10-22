@extends('dashboard.layout.master')
@section('style')
    <link href="{{ asset('asset/css/datatables.min.css') }}" rel="stylesheet">
@endsection
@section('content')
    <section class="content" style="margin: 0 auto; max-width: 100%">
        <h1>Discount Coupon</h1>
        <div class="" style="margin: 0 auto; float: right;">
            <a class="btn btn-primary" href="{{ route('admin.discount-coupon.create') }}">Create Discount Coupon</a>
        </div>

        <div class=""
            style="margin-top: 70px;padding: 10px;border: 0 solid rgba(0,0,0,.125);
    border-radius: .25rem;background-color: #fff;box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);margin-bottom: 1rem;">

            <table class="table" id="companyData" style="width: 100%">
                <thead>
                    <tr>
                        <th>{{ __('messages.table.id') }}</th>
                        <th>{{ __('messages.table.status') }}</th>
                        <th>{{ __('messages.table.code') }}Code</th>
                        <th>{{ __('messages.table.discount') }}</th>
                        <th>{{ __('messages.table.discount-type') }}</th>
                        <th>{{ __('messages.table.active-date') }}</th>
                        <th>{{ __('messages.table.expire-date') }}</th>
                        <th style="width: 150px;">{{ __('messages.table.action') }}</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="deleteCouponModel" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Company Delete</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {{__('messages.conformation.delete', ['attribute' => 'Discount Coupon?'])}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="deleteCoupon" class="btn btn-danger">Delete</button>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection

@section('script')
    <script src="{{ asset('asset/js/jquery-datatables.min.js') }}"></script>
    <script src="{{ asset('asset/js/datatable.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script>
        $(document).ready(function() {

            $('.table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.discount-coupon.index') }}",
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
                                ' data-coupon-id=' + row.id + ' name="status" value="' + data +
                                '" class="status form-check-input m-0" type="checkbox" role="switch" /></div>';
                        },
                        searchable: false,
                        orderable: false,
                    },
                    {
                        "data": "code",
                    },
                    {
                        "data": "discount",
                    },
                    {
                        "data": "discount_type",
                        'name' : "discount_type"
                    },
                    {
                        "data": "active_at",
                        render: function(data, type, row) {
                            var date = data == null ? 'Not select due date' : moment(data).format("{{config('site.date')}}");
                            return '<div class="form-check form-switch p-1">' + date +
                                '</div>';
                        },
                    },
                    {
                        "data": "expire_at",
                        render: function(data, type, row) {
                            var date = data == null ? 'Not select due date' : moment(data).format("{{config('site.date')}}");
                            return '<div class="form-check form-switch p-1">' + date +
                                '</div>';
                        },
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
                lengthMenu: [10, 25, 50, 100],
                pageLength: 10,
            });

            let couponId;
            $(document).on("click", ".delete", function(event) {
                event.preventDefault();
                couponId = $(this).attr("data-user-id");
            });

            $(document).on("click", "#deleteCoupon", function(event) {
                event.preventDefault();
                deleteCompany(couponId)
            });

            function deleteCompany(couponId) {
                $.ajax({
                    url: "{{ route('admin.discount-coupon.destroy', ['discount_coupon' => ':id']) }}".replace(':id', couponId),
                    data: {
                        "id": couponId,
                        "_token": "{{ csrf_token() }}"
                    },
                    type: "DELETE",
                    success: function(response) {
                        $("#deleteCouponModel").modal("toggle");
                        const  message = response.success;
                        toastr.options = {
                            closeButton: true,
                            progressBar: true,
                        }
                        toastr.success(message);
                        $('.table').DataTable().ajax.reload();
                    }
                });
            }

            function changeStatus(status, couponId) {
                $.ajax({
                    url: "{{ route('admin.discount-coupon.status') }}",
                    data: {
                        "status": status,
                        "couponId": couponId,
                        "_token": "{{ csrf_token() }}"
                    },
                    type: "POST",
                    success: function(response) {
                        var message = response.success;
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
                let couponId = $(this).attr('data-coupon-id');
                changeStatus(status, couponId)
            });
        });
    </script>
@endsection
