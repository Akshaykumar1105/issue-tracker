@extends('front.layout.layout')
@section('style')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"
        integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('asset/css/dropify.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/loader.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('asset/fonts/material-design-iconic-font/css/material-design-iconic-font.min.css') }}">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">
    <style>
        label,
        input {
            color: #000 !important;
        }

        input {
            height: 40px !important;
        }

        .wizard-content .wizard>.steps>ul>li:after,
        .wizard-content .wizard>.steps>ul>li:before {
            content: '';
            z-index: 9;
            display: block;
            position: absolute
        }

        .wizard-content .wizard {
            width: 100%;
            overflow: hidden
        }

        .wizard-content .wizard .content {
            margin-left: 0 !important
        }

        .wizard-content .wizard>.steps {
            position: relative;
            display: block;
            width: 100%
        }

        .wizard-content .wizard>.steps .current-info {
            position: absolute;
            left: -99999px
        }

        .wizard-content .wizard>.steps>ul {
            display: table;
            width: 100%;
            table-layout: fixed;
            margin: 0;
            padding: 0;
            list-style: none
        }

        .wizard-content .wizard>.steps>ul>li {
            display: table-cell;
            width: auto;
            vertical-align: top;
            text-align: center;
            position: relative
        }

        .wizard-content .wizard>.steps>ul>li a {
            position: relative;
            padding-top: 52px;
            margin-top: 20px;
            margin-bottom: 20px;
            display: block
        }

        .wizard-content .wizard>.steps>ul>li:before {
            left: 0
        }

        .wizard-content .wizard>.steps>ul>li:after {
            right: 0
        }

        .wizard-content .wizard>.steps>ul>li:first-child:before,
        .wizard-content .wizard>.steps>ul>li:last-child:after {
            content: none
        }

        .wizard-content .wizard>.steps>ul>li.current>a {
            cursor: default
        }

        .wizard-content .wizard>.steps>ul>li.current .step {
            border-color: #009efb;
            background-color: #fff;
            color: #009efb
        }

        .wizard-content .wizard>.steps>ul>li.disabled a,
        .wizard-content .wizard>.steps>ul>li.disabled a:focus,
        .wizard-content .wizard>.steps>ul>li.disabled a:hover {

            cursor: default
        }



        .wizard-content .wizard>.steps>ul>li.done .step {
            background-color: #009efb;
            border-color: #009efb;
            color: #fff
        }

        .wizard-content .wizard>.steps>ul>li.error .step {
            border-color: #f62d51;
            color: #f62d51
        }

        .wizard-content .wizard>.steps .step {
            background-color: #fff;
            display: inline-block;
            position: absolute;
            top: 0;
            left: 50%;
            margin-left: -24px;
            z-index: 10;
            text-align: center
        }

        .wizard-content .wizard>.content {
            overflow: hidden;
            position: relative;
            width: auto;
            padding: 0;
            margin: 0
        }

        .wizard-content .wizard>.content>.title {
            position: absolute;
            left: -99999px
        }

        .wizard-content .wizard>.content>.body {
            padding: 0 20px
        }

        .wizard-content .wizard>.content>iframe {
            border: 0;
            width: 100%;
            height: 100%
        }

        .wizard-content .wizard>.actions {
            position: relative;
            display: block;
            text-align: right;
            padding: 0 20px 20px
        }

        .wizard-content .wizard>.actions>ul {
            float: right;
            list-style: none;
            padding: 0;
            margin: 0
        }

        .wizard-content .wizard>.actions>ul:after {
            content: '';
            display: table;
            clear: both
        }

        .wizard-content .wizard>.actions>ul>li {
            float: left
        }

        .wizard-content .wizard>.actions>ul>li+li {
            margin-left: 10px
        }

        .wizard-content .wizard>.actions>ul>li>a {
            background: #009efb;
            color: #fff;
            display: block;
            padding: 7px 12px;
            border-radius: 4px;
            border: 1px solid transparent
        }

        .wizard-content .wizard>.actions>ul>li>a:focus,
        .wizard-content .wizard>.actions>ul>li>a:hover {
            -webkit-box-shadow: 0 0 0 100px rgba(0, 0, 0, .05) inset;
            box-shadow: 0 0 0 100px rgba(0, 0, 0, .05) inset
        }

        .wizard-content .wizard>.actions>ul>li>a:active {
            -webkit-box-shadow: 0 0 0 100px rgba(0, 0, 0, .1) inset;
            box-shadow: 0 0 0 100px rgba(0, 0, 0, .1) inset
        }

        .wizard-content .wizard>.actions>ul>li>a[href="#previous"] {
            background-color: #fff;
            color: #54667a;
            border: 1px solid #d9d9d9
        }

        .wizard-content .wizard>.actions>ul>li>a[href="#previous"]:focus,
        .wizard-content .wizard>.actions>ul>li>a[href="#previous"]:hover {
            -webkit-box-shadow: 0 0 0 100px rgba(0, 0, 0, .02) inset;
            box-shadow: 0 0 0 100px rgba(0, 0, 0, .02) inset
        }

        .wizard-content .wizard>.actions>ul>li>a[href="#previous"]:active {
            -webkit-box-shadow: 0 0 0 100px rgba(0, 0, 0, .04) inset;
            box-shadow: 0 0 0 100px rgba(0, 0, 0, .04) inset
        }



        .wizard-content .wizard>.actions>ul>li.disabled>a[href="#previous"],
        .wizard-content .wizard>.actions>ul>li.disabled>a[href="#previous"]:focus,
        .wizard-content .wizard>.actions>ul>li.disabled>a[href="#previous"]:hover {
            -webkit-box-shadow: none;
            box-shadow: none
        }

        .wizard-content .wizard.wizard-circle>.steps>ul>li:after,
        .wizard-content .wizard.wizard-circle>.steps>ul>li:before {
            top: 45px;
            width: 50%;
            height: 3px;
            background-color: #009efb
        }

        .wizard-content .wizard.wizard-circle>.steps>ul>li.current:after,
        .wizard-content .wizard.wizard-circle>.steps>ul>li.current~li:after,
        .wizard-content .wizard.wizard-circle>.steps>ul>li.current~li:before {
            background-color: #F3F3F3
        }

        .wizard-content .wizard.wizard-circle>.steps .step {
            width: 50px;
            height: 50px;
            line-height: 45px;
            border: 3px solid #F3F3F3;
            font-size: 1.3rem;
            border-radius: 50%
        }

        .wizard-content .wizard.wizard-notification>.steps>ul>li:after,
        .wizard-content .wizard.wizard-notification>.steps>ul>li:before {
            top: 39px;
            width: 50%;
            height: 2px;
            background-color: #009efb
        }

        .wizard-content .wizard.wizard-notification>.steps>ul>li.current .step {
            border: 2px solid #009efb;
            color: #009efb;
            line-height: 36px
        }

        .wizard-content .wizard.wizard-notification>.steps>ul>li.current .step:after,
        .wizard-content .wizard.wizard-notification>.steps>ul>li.done .step:after {
            border-top-color: #009efb
        }

        .wizard-content .wizard.wizard-notification>.steps>ul>li.current:after,
        .wizard-content .wizard.wizard-notification>.steps>ul>li.current~li:after,
        .wizard-content .wizard.wizard-notification>.steps>ul>li.current~li:before {
            background-color: #F3F3F3
        }

        .wizard-content .wizard.wizard-notification>.steps>ul>li.done .step {
            color: #FFF
        }

        .wizard-content .wizard.wizard-notification>.steps .step {
            width: 40px;
            height: 40px;
            line-height: 40px;
            font-size: 1.3rem;
            border-radius: 15%;
            background-color: #F3F3F3
        }

        .wizard-content .wizard.wizard-notification>.steps .step:after {
            content: "";
            width: 0;
            height: 0;
            position: absolute;
            bottom: 0;
            left: 50%;
            margin-left: -8px;
            margin-bottom: -8px;
            border-left: 7px solid transparent;
            border-right: 7px solid transparent;
            border-top: 8px solid #F3F3F3
        }

        .wizard-content .wizard.vertical>.steps {
            display: inline;
            float: left;
            width: 20%
        }

        .wizard-content .wizard.vertical>.steps>ul>li {
            display: block;
            width: 100%
        }

        .wizard-content .wizard.vertical>.steps>ul>li.current:after,
        .wizard-content .wizard.vertical>.steps>ul>li.current:before,
        .wizard-content .wizard.vertical>.steps>ul>li.current~li:after,
        .wizard-content .wizard.vertical>.steps>ul>li.current~li:before,
        .wizard-content .wizard.vertical>.steps>ul>li:after,
        .wizard-content .wizard.vertical>.steps>ul>li:before {
            background-color: transparent
        }

        @media (max-width:768px) {
            .wizard-content .wizard>.steps>ul {
                margin-bottom: 20px
            }

            .wizard-content .wizard>.steps>ul>li {
                display: block;
                float: left;
                width: 50%
            }

            .wizard-content .wizard>.steps>ul>li>a {
                margin-bottom: 0
            }

            .wizard-content .wizard>.steps>ul>li:first-child:before {
                content: ''
            }

            .wizard-content .wizard>.steps>ul>li:last-child:after {
                content: '';
                background-color: #009efb
            }

            .wizard-content .wizard.vertical>.steps {
                width: 15%
            }
        }

        @media (max-width:480px) {
            .wizard-content .wizard>.steps>ul>li {
                width: 100%
            }

            .wizard-content .wizard>.steps>ul>li.current:after {
                background-color: #009efb
            }

            .wizard-content .wizard.vertical>.steps>ul>li {
                display: block;
                float: left;
                width: 50%
            }

            .wizard-content .wizard.vertical>.steps {
                width: 100%;
                float: none;
            }
        }
    </style>
@endsection
@section('content')
    <div class="loader-container">
        <div class="loader"></div>
    </div>
    <div class="container">
        <div class="panel">
            <div class="panel-body wizard-content">
                <form id="example-form" action="#" class="tab-wizard wizard-circle wizard clearfix">
                    @csrf
                    <h6>Account</h6>
                    <section>
                        <div class="row">
                            <div class="form ps-2 mb-3" style="text-align: start ">
                                <h2 class="fs-title">Account Information</h2>
                                <div class="col-md-12 mt-3">

                                    <div class="form-group">
                                        <label class="form-label fw-bold">Name<span
                                                class="text-danger ms-1">*</span></label>
                                        <input style="color: #000;" type="text" id="name" name="companyname"
                                            class="form-control" placeholder="Bolton and Green Trading" />
                                    </div>

                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label fw-bold">E-mail<span
                                                class="text-danger ms-1">*</span></label>
                                        <input type="email" class="form-control " id="email" name="email"
                                            placeholder="xyz@gmail.com" />
                                        <span class="error-message" for="email"></span>

                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label fw-bold">Mobile<span
                                                class="text-danger ms-1">*</span></label>
                                        <input type="number" class="form-control " id="number" name="number"
                                            placeholder="7410852000" />
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label fw-bold">Address<span
                                                class="text-danger ms-1">*</span></label>
                                        <input type="text" class="form-control " id="address" name="address"
                                            placeholder="Enter your company address." />
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label fw-bold">City<span
                                                class="text-danger ms-1">*</span></label>
                                        <select name="city_id" class="form-control" style="appearance: auto">
                                            <option value="">Select City</option>
                                            @foreach ($cities as $city)
                                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <h6>Selected subscription plan</h6>
                    <section>
                        <div class="row mb-3">
                            <div class="" style="display:flex; gap: 10px">
                                @foreach ($subscriptionPlans as $subscriptionPlan)
                                    <div class="card pricing-card pricing-plan-basic">
                                        <div class="card-body">
                                            <i class="mdi mdi-cube-outline pricing-plan-icon"></i>
                                            <div class="d-flex align-items-center">
                                                <input type="radio" value='{{$subscriptionPlan->name}}' id="sub_plan_basic" {{$subscriptionPlan->name == 'Basic' ? 'checked' : ''}} 
                                                    name="subscription_name">
                                                <label class="pricing-plan-title ms-2"
                                                    for="sub_plan_basic">{{ $subscriptionPlan->name }}</label>
                                            </div>
                                            @if ($subscriptionPlan->discount_price)
                                            <h3 class="">
                                                <span class="line" style="color: #a59d9d; text-decoration: line-through;">{{ config('site.currency') }}{{ $subscriptionPlan->price}}</span><span>{{ config('site.currency') }}{{$subscriptionPlan->price - $subscriptionPlan->discount_price}}</span>/<small>{{ $subscriptionPlan->type}}</small> </h3>
                                            @else
                                            <h3 class="">
                                                {{ config('site.currency') }}{{ $subscriptionPlan->price}}/<small>{{ $subscriptionPlan->type}}</small> </h3>
                                            @endif
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        <td>Create hr limit</td>
                                                        <td>{{$subscriptionPlan->hr_create_limit}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Create manager limit</td>
                                                        <td>{{$subscriptionPlan->manager_create_limit}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Create issue limit</td>
                                                        <td>{{$subscriptionPlan->issue_create_limit}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Can manage issues</td>
                                                        <td>{{$subscriptionPlan->can_manage_issues == 1 ? 'Yes' : 'No'}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Features</td>
                                                        <td>
                                                            <ul class="pricing-plan-features" style="list-style-type: none !impo; ">
                                                                @php
                                                                    $features = explode(', ', $subscriptionPlan->features);
                                                                @endphp
                                                                @foreach ($features as $feature)
                                                                    <li>{{ $feature }}</li>
                                                                @endforeach
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                                
                                        </div>
                                    </div>
                                @endforeach

                                {{-- <div class="col-md-6">
                                    <div class="card pricing-card pricing-card-highlighted  pricing-plan-pro">
                                        <div class="card-body">
                                            <i class="mdi mdi-trophy pricing-plan-icon"></i>
                                            <div class="d-flex align-items-center">
                                                <input type="radio" value='premium' id="sub_plan_premium"
                                                    name="subscription_plan">
                                                <label class="pricing-plan-title ms-2"
                                                    for="sub_plan_premium">Premium</label>
                                            </div>
                                            <h3 class="pricing-plan-cost ml-auto">$3000</h3>
                                            <ul class="pricing-plan-features">
                                                <li>Unlimited conferences</li>
                                                <li>200 participants max</li>
                                                <li>Custom Hold Music</li>
                                                <li>20 participants max</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                        </div>

                    </section>

                    <h6>pay</h6>
                    <section style="max-width: 850px; margin: auto;">
                        <div class="row" style="font-size: 20px; color: #000;">
                            <h1 style="margin: 0 0 10px 0;">Payment</h1>
                            <div class="d-flex" class="mt-3">
                                <div class="" style="width: 300px">Selected subscription plan:</div>
                                <div id="subscriptionPlan" class="ms-2"></div>
                            </div>

                            <div class="d-flex my-2">
                                <div class="" style="width: 300px">Subscription amount:</div>
                                <div id="subscriptionAmount" class="ms-2"></div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <h4>Discount Coupon</h4>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="couponCode" name="couponCode"
                                            placeholder="Enter coupon code">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <button id="applyCoupon" class="btn btn-primary">Apply Coupon</button>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <h4>Total Price</h4>
                                </div>
                                <div class="col-sm-7">
                                    <div class="d-flex" class="mt-3">
                                        <div class="" style="width: 300px">Sub total:</div>
                                        <div id="subTotal" class="ms-2"></div>
                                    </div>

                                    <div class="d-flex my-2">
                                        <div class="" style="width: 300px">Discount:</div>
                                        <div id="discount" class="ms-2">$0</div>
                                    </div>


                                    <hr>
                                    <div class="d-flex mt-1">
                                        <div class="" style="width: 300px">Total Price:</div>
                                        <div id="total" class="ms-2"></div>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <hr>

                    </section>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.min.js"></script>
    <script src="{{ asset('asset/js/dropify.min.js') }}"></script>
    <script src="{{ asset('asset/js/jquery.steps.js') }}"></script>

    <script>
        $(document).ready(function() {
            var form = $("#example-form");

            let subscriptionPlan;
            let amount;
            form.steps({
                headerTag: "h6",
                bodyTag: "section",
                transitionEffect: "fade",
                titleTemplate: '<span class="step">#index#</span> #title#',
                onStepChanging: function(event, currentIndex, newIndex) {
                    var form = $(this);
                    form.validate().settings.ignore = ":disabled,:hidden";

                    $.ajax({
                        type: 'POST',
                        url: "{{ route('company.step') }}",
                        data: form.serialize(),
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response.success) {
                                if (response.subscription_name) {
                                    $('#subscriptionPlan').html(response.subscription_name)
                                }
                                if (response.amount) {
                                    $('#subscriptionAmount').html('$' + response.amount)
                                    $('#subTotal').html('$' + response.amount)
                                    $('#total').html('$' + response.amount)
                                    amount = response.amount;
                                }
                                return true;
                            } else {
                                toastr.error(response.error);
                                form.steps("previous");
                                return false;
                            }

                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                            return false;
                        }
                    });


                    return form.valid();

                },
                onFinished: function(event, currentIndex) {
                    // Handle form submission
                    alert("Form submitted!");
                }
            });



            $(document).on('click', '#applyCoupon', function() {
                let discountCode = $("#couponCode").val();

                $.ajax({
                    type: 'POST',
                    url: "{{ route('company.discount') }}",
                    data: {
                        discount_code: discountCode
                    },
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        let message = response.message
                        if (response.status == 'true') {
                            if (response.coupon.discount_type == 'VARIABLE') {
                                let discountAmount = (amount * response.coupon.discount) / 100;
                                let discountedTotal = amount - discountAmount;
                                $('#discount').html('-' + '$' + discountAmount + '(' + response
                                    .coupon
                                    .discount + "%" + ')')
                                $('#total').html('$' + discountedTotal)
                            } else {
                                let discountedTotal = amount - response.coupon.discount;
                                $('#discount').html('-' + '$' + response.coupon.discount)
                                $('#total').html('$' + discountedTotal)
                            }

                            $('#couponCode').prop('readonly', true);
                            $('#applyCoupon').attr('id', 'removeCoupan').html('Remove Coupon');
                            toastr.success(message,
                                'Success', {
                                    progressBar: true,
                                    timeOut: 2000,
                                });
                        } else {
                            toastr.error(message, 'Error', {
                                progressBar: true,
                                timeOut: 2000,
                            });
                        }


                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        return false;
                    }
                });
            })

            $(document).on("click", '#removeCoupan', function() {
                $('#couponCode').prop('readonly', false);
                $("#discount").html('$' + 0)
                $('#removeCoupan').attr('id', 'applyCoupon').html('Apply Coupon');
                $("#total").html('$' + amount);
            })

            $.validator.addMethod("lettersonly", function(value, element) {
                return this.optional(element) || /^[a-zA-Z0-9]+( [a-zA-Z0-9]+)*$/.test(value);
            }, "Letters and numbers only with a single space between words.");

            $.validator.addMethod("validNumber", function(value, element) {
                return !/0{10}/.test(value);
            }, "{{ __('validation.valid', ['attribute' => 'mobile']) }}");


            form.validate({
                errorClass: "text-danger",
                errorElement: "span",
                rules: {
                    name: {
                        required: true,
                        maxlength: 255,
                        lettersonly: true,
                    },
                    email: {
                        required: true,
                        email: true,
                    },
                    number: {
                        required: true,
                        number: true,
                        validNumber: true,
                        digits: true,
                        minlength: 10,
                        maxlength: 10,
                    },
                    address: {
                        required: true,
                    },
                    city_id: {
                        required: true,
                    }
                },
                submitHandler: function(form) {

                },
                highlight: function(element) {
                    $(element).closest("div").addClass("has-error");
                },
                unhighlight: function(element) {
                    $(element).closest("div").removeClass("has-error");
                }
            });
        });
    </script>
@endsection
