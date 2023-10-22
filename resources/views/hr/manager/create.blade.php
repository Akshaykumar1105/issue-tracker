@extends('dashboard.layout.master')
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
                                    <label for="mobile" class="form-label">Mobile Number</label>
                                    <input type="number" value="{{ isset($manager) ? $manager->mobile : '' }}"
                                        class="form-control shadow-none" name="mobile" id="mobile"
                                        placeholder="7410852000">
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
            }, "{{ __('validation.lettersonly') }}");

            $.validator.addMethod("pattern", function(value, element) {
                    return /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/.test(value);
                },
                "Password must include at least one uppercase letter, one lowercase letter, one digit, and one special character."
            );

            $.validator.addMethod("validNumber", function(value, element) {
                return !/0{10}/.test(value);
            }, "{{ __('validation.valid', ['attribute' => 'mobile']) }}");

            $("#managerCreate").validate({
                errorClass: "text-danger fw-normal",
                rules: {
                    name: {
                        required: true,
                        lettersonly: true,
                        maxlength: 255,
                    },
                    email: {
                        required: true,
                        email: true,
                    },
                    password: {
                        required: true,
                        minlength: 8,
                        pattern: true,
                    },
                    password_confirmation: {
                        required: true,
                        equalTo: "#password"
                    },
                    mobile: {
                        required: true,
                        number: true,
                        validNumber:true,
                        digits: true,
                        minlength: 10,
                        maxlength: 10,
                    },

                },
                messages: {
                    name: {
                        required: "{{ __('validation.required', ['attribute' => 'name']) }}",
                        maxlength: "{{ __('validation.max_digits', ['attribute' => 'name', 'max' => '255']) }}",
                    },
                    email: {
                        required: "{{ __('validation.required', ['attribute' => 'email']) }}",
                        email: "{{ __('validation.valid', ['attribute' => 'email']) }}",
                    },
                    password: {
                        required: "Please enter your password.",
                        minlength: "Password must be at least 8 characters long.",
                        pattern: "Password must include at least one uppercase letter, one lowercase letter, one digit, and one special character.",
                    },
                    password_confirmation: {
                        required: "Please confirm your password.",
                        equalTo: "Passwords do not match.",
                    },
                    number: {
                        required: "{{ __('validation.required', ['attribute' => 'number']) }}",
                        number: "{{ __('validation.valid', ['attribute' => 'number']) }}",
                        digits: "The number must be a 10 digits",
                        minlength: "{{ __('validation.min_digits', ['attribute' => 'number', 'min' => '10']) }}",
                        maxlength: "{{ __('validation.max_digits', ['attribute' => 'number', 'max' => '10']) }}",
                    },
                },
                submitHandler: function(form) {
                    $(".loader-container").fadeIn();
                    let formData = new FormData(form);
                    $.ajax({
                        url: $(form).attr("action"),
                        type: $(form).attr("method"),
                        data: formData,
                        processData: false,
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
                            var response = JSON.parse(xhr.responseText);
                            var message = response.message;
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
