@extends('dashboard.layout.dashboard_layout')
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('asset/css/dropify.min.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" />
    <link rel="stylesheet" href="{{ asset('asset/css/loader.css') }}">
    {{-- <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet"> --}}
@endsection
@section('content')
    <div class="loader-container">
        <div class="loader"></div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-11 mx-auto mt-3">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            @if (isset($manager))
                                <h3 class="card-title">{{ __('messages.manager.edit') }}</h3>
                            @else
                                <h3 class="card-title">{{ __('messages.manager.register') }}</h3>
                            @endif

                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        @if (isset($manager))
                            <form method='post' id="managerCreate"
                                action="{{ route('hr.manager.update', ['manager' => $manager->id]) }}"
                                enctype="multipart/form-data">
                                @method('patch')
                        @endif
                        <form method='post' id="managerCreate" action="{{ route('hr.manager.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">

                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" name="name" id="name"
                                        placeholder="Enter your manager name."
                                        value="{{ isset($manager) ? $manager->name : '' }}">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email </label>
                                    <input type="email" class="form-control" name="email" id="email"
                                        placeholder="Enter your manager email"
                                        value="{{ isset($manager) ? $manager->email : '' }}">
                                </div>
                                @if (!isset($manager))
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control" name="password" id="password"
                                            placeholder="Password">
                                    </div>

                                    <div class="form-group">
                                        <label for="password_confirmation">Confirm password</label>
                                        <input type="password" class="form-control" name="password_confirmation"
                                            id="password_confirmation" placeholder="Password confirmation">
                                    </div>
                                @endif
                                <div class="form-group mb-4 ">
                                    <label for="mobile_no" class="form-label">Mobile Number</label>
                                    <input type="number" value="{{ isset($manager) ? $manager->mobile : '' }}"
                                        class="form-control shadow-none" name="mobile_no" id="mobile_no" placeholder="7410852000">
                                </div>

                                <div class="form-group " style=";font-size: 20px;">
                                    <label for="profile_img" class="form-label">{{ __('messages.form.img') }}</label>
                                    <div class="custom-file ">
                                        <input name="profile_img" type="file" id="profile_img" class="dropify"
                                            data-height="100"
                                            @if (isset($manager)) data-default-file="{{ asset('storage/user/' . $manager->getMedia('user')->first()->filename . '.' . $manager->getMedia('user')->first()->extension) }}"
                                            @else
                                            data-default-file="" @endif />
                                    </div>
                                </div>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit"
                                    class="btn btn-primary">{{ isset($manager) ? 'Update' : 'Submit' }}</button>
                                <a href="{{ route('hr.manager.index') }}" class="btn btn-outline-secondary">Back</a>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->

                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>


    </section>
@endsection

@section('script')
    <script src="{{ asset('asset/js/dropify.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.dropify').dropify();


            $.validator.addMethod("lettersonly", function(value, element) {
                return this.optional(element) || /^[a-zA-Z\s]+$/i.test(value);
            }, "Letters only, please.");

            $("#managerCreate").validate({
                errorClass: "text-danger fw-normal",
                rules: {
                    name: {
                        required: true,
                        lettersonly: true
                    },
                    email: {
                        required: true,
                        email: true,
                    },
                    password: {
                        required: true,
                        minlength: 8, // Minimum password length
                    },
                    password_confirmation: {
                        required: true,
                        equalTo: "#password" // Confirm password must match password
                    },
                    mobile_no: {
                        required: true,
                        minlength: 10,
                        maxlength: 10,
                        digits: true
                    },

                },
                messages: {
                    name: {
                        required: "Please enter Company name.",
                        lettersonly: "Only letters and whitespaces are allowed."
                    },
                    email: {
                        required: "Please enter your email.",
                        email: "Please enter a valid email address.",
                    },
                    password: {
                        required: "Please enter your password.",
                        minlength: "Password must be at least 8 characters long."
                    },
                    password_confirmation: {
                        required: "Please confirm your password.",
                        equalTo: "Passwords do not match.",
                    },
                    mobile_no: {
                        required: "Please enter your 10-digit mobile number.",
                        minlength: "Mobile number must be exactly 10 digits.",
                        maxlength: "Mobile number must be exactly 10 digits.",
                        digits: "Mobile number can only contain numeric digits.",
                    },
                },
                submitHandler: function(form) {
                    $(".loader-container").fadeIn();
                    let formData = new FormData(form);
                    $.ajax({
                        url: $(form).attr("action"),
                        type: $(form).attr("method"),
                        data: formData,
                        processData: false, // Important: Don't process the data
                        contentType: false,
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
                            // Handle error response
                            // console.log("Form submission error");
                            var response = JSON.parse(xhr.responseText);
                            var message = response.message;
                            console.log(message)
                            toastr.options = {
                                closeButton: true,
                                progressBar: true,
                            }
                            toastr.error(message);

                        },
                    })
                },
            });


        });
    </script>
@endsection
