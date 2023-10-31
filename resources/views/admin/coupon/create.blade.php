@extends('dashboard.layout.master')

@section('style')
    <link rel="stylesheet" href="{{ asset('asset/css/loader.css') }}">
    <style type="text/css">
        label.error {
            float: none; 
            color: red;
            font-size: 15px;
            font-weight: 400 !important;
            padding-left: .3em; 
            vertical-align: top;  
        }
    </style>
@endsection

@section('content')
    <x-loader />
    <section class="content">
        <div class="col-md-12 mx-auto pt-3">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        @if (isset($company))
                            Edit
                        @else
                            Create
                        @endif
                        Coupon
                    </h3>
                </div>
                @if (isset($coupon))
                    <form method="post"
                        action="{{ route('admin.discount-coupon.update', ['discount_coupon' => $coupon->id]) }}"
                        id="createDiscountCoupon">
                        @method('patch')
                    @else
                        <form method="post" action="{{ route('admin.discount-coupon.store') }}" id="createDiscountCoupon">
                            @method('post')
                @endif
                @csrf

                <div class="col-md-12 mt-3 ps-3">
                    <div class="form-group">
                        <label class="form-label fw-bold" for="code">Code<span class="text-danger ms-1">*</span></label>
                        <input type="text" id="name" name="code" class="form-control"
                            value="{{ isset($coupon) ? $coupon->code : '' }}" placeholder="SDFGHJK25" />
                    </div>
                </div>

                <div class="col-md-12 ps-3">
                    <div class="form-group">
                        <label for="discount" class="form-label fw-bold">Discount<span
                                class="text-danger ms-1">*</span></label>
                        <input type="number" class="form-control " id="discount" name="discount"
                            value="{{ isset($coupon) ? $coupon->discount : '' }}" placeholder="Enter discount amount" />
                    </div>
                </div>

                <div class="col-md-12 ps-3">
                    <div class="form-group">
                        <label for="discount_type" class="form-label fw-bold d-block">Discount Type<span
                                class="text-danger ms-1">*</span></label>
                        <div class="d-flex">
                            <div class="form-check form-check-inline d-flex">
                                <input class="form-check-input discount-type-radio" type="radio"
                                    id="discount_type_variable" name="discount_type" value="VARIABLE"
                                    {{ isset($coupon) && $coupon->discount_type == 'VARIABLE' ? 'checked' : '' }}
                                    {{ Route::currentRouteName() == 'admin.discount-coupon.edit' ? '' : 'checked' }}>
                                <label class="form-check-label" for="discount_type_variable">Variable</label>
                            </div>
                            <div class="form-check form-check-inline d-flex">
                                <input class="form-check-input discount-type-radio" type="radio" id="discount_type_flat"
                                    name="discount_type" value="FLAT"
                                    {{ isset($coupon) && $coupon->discount_type == 'FLAT' ? 'checked' : '' }}>
                                <label class="form-check-label" for="discount_type_flat">Flat amount</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 ps-3">
                    <div class="form-group">
                        <label for="is_active" class="form-label fw-bold">Status<span
                                class="text-danger ms-1">*</span></label>
                        <select class="form-control" style="appearance: auto;" name="is_active">
                            <option value="1">Active</option>
                            <option value="0">In Active</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-12 ps-3">
                    <div class="form-group">
                        <label for="active_at" class="form-label fw-bold">Active At<span
                                class="text-danger ms-1">*</span></label>
                        <input type="date" class="form-control " id="active_at" name="active_at"
                            value={{ isset($coupon) ? $coupon->active_at : '' }} />
                        <span class="text-danger" id="startDate"></span>
                    </div>
                </div>

                <div class="col-md-12 ps-3">
                    <div class="form-group">
                        <label for="expire_at" class="form-label fw-bold">Expire At<span
                                class="text-danger ms-1">*</span></label>
                        <input type="date" class="form-control " id="expire_at" name="expire_at"
                            value={{ isset($coupon) ? $coupon->expire_at : '' }} />
                        <span class="text-danger" id="endDate"></span>
                    </div>
                </div>

                <div class="mb-3 ps-2">
                    <button type="submit"
                        class="btn btn-primary ms-2 ">{{ isset($company) ? 'Update' : 'Submit' }}</button>

                    <a href="{{ route('admin.discount-coupon.index') }}" class="btn btn-outline-secondary my-0">Back</a>
                </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        $(document).ready(function() {

            function store(form) {
                $.ajax({
                    url: $(form).attr("action"),
                    type: $(form).attr("method"),
                    data: $(form).serialize(),
                    success: function(response) {
                        $(".loader-container").fadeOut();
                        toastr.options = {
                            closeButton: true,
                            progressBar: true,
                        }
                        toastr.success(response.success);
                        setTimeout(function() {
                            window.location.href = response.route;
                        }, 2000);
                    },
                    error: function(xhr, status, error) {
                        $(".loader-container").fadeOut();
                        var response = JSON.parse(xhr.responseText);
                        var message = response.message;
                        toastr.options = {
                            closeButton: true,
                            progressBar: true,
                        }
                        toastr.error(message);
                    },
                });
            }

            $.validator.addMethod("greaterThan", function(value, element, params) {
                return new Date(value) > new Date($(params).val());
            }, "Expiry date must be greater than the active date.");

            $.validator.addMethod("couponCode", function(value, element) {
                var pattern = /^[A-Z]{2,}[0-9]{2,10}$/;
                return this.optional(element) || pattern.test(value);
            }, "Coupon code must contain at least 2 capital letters and 2 to 10 numbers.");

            $.validator.addMethod("numericOnly", function(value, element) {
                return /^\d+(\.\d{2})?$/.test(value);
            }, "Discount amount should be a valid number (with up to two decimal places).");


            $("#createDiscountCoupon").validate({
                rules: {
                    code: {
                        required: true,
                        couponCode: true,
                        maxlength: 30,
                    },
                    discount: {
                        required: true,
                        number: true,
                        numericOnly: true,
                        min: 0,
                        max: function() {
                            const discountType = $("input[name='discount_type']:checked").val();
                            return discountType === "FLAT" ? 50000 : 100;
                        },
                    },
                    discount_type: {
                        required: true,
                    },
                    is_active: {
                        required: true
                    },
                    active_at: {
                        required: true,
                        date: true,
                        min: new Date().toISOString().split("T")[0],
                    },
                    expire_at: {
                        required: true,
                        date: true,
                        greaterThan: '#active_at',
                    },
                },
                messages: {
                    code: {
                        required: "{{ __('validation.required', ['attribute' => 'code']) }}",
                        maxlength: "{{ __('validation.max_digits', ['attribute' => 'code', 'max' => '30']) }}",
                    },
                    active_at: {
                        min: "Active at date must be today or a future date.",
                    },
                },
                submitHandler: function(form) {
                    $(".loader-container").fadeIn();
                    store(form);
                },
            });
        });
    </script>
@endsection
