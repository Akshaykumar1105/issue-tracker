@extends('dashboard.layout.master')
@section('style')
    <link rel="stylesheet" href="{{ asset('asset/css/dropify.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/loader.css') }}">
    <style>
        .password-container {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            top: 7px;
            right: 10px;
            cursor: pointer;
        }
    </style>
@endsection
@section('content')
    <x-loader />
    <section class="content pt-3 px-3">
        <div class="container-fluid">
            <div class="row">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
                            type="button" role="tab" aria-controls="profile" aria-selected="true">My Profile</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="changepassword-tab" data-bs-toggle="tab"
                            data-bs-target="#changepassword" type="button" role="tab" aria-controls="changepassword"
                            aria-selected="false">Change
                            Password</button>
                    </li>
                </ul>
                <div class="tab-content" style="padding: 0;" id="myTabContent">
                    <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="card card-primary">
                            @php
                                $user = auth()->user();
                                if ($user->hasRole('hr')) {
                                    $route = route('hr.profile.update', ['profile' => $user->id]);
                                } elseif ($user->hasRole('manager')) {
                                    $route = route('manager.profile.update', ['profile' => $user->id]);
                                } else {
                                    $route = route('admin.profile.update', ['profile' => $user->id]);
                                }
                            @endphp
                            <form action="{{ $route }}" enctype="multipart/form-data" method="post" id="userView">
                                @method('patch')
                                @csrf
                                <div class="card-body">

                                    <div class="form-group">
                                        <label for="name">{{ __('messages.form.name') }}</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            placeholder="Enter name" value="{{ $user->name }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">{{ __('messages.form.email') }}</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            placeholder="Enter email" value="{{ $user->email }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="mobile">{{ __('messages.form.number') }}</label>
                                        <input type="number" class="form-control" id="mobile" name="mobile"
                                            placeholder="Enter number" value="{{ $user->mobile }}">
                                    </div>
                                    <div class="form-group" style="width: 50%;">
                                        <label for="exampleInputFile">{{ __('messages.form.img') }}</label>
                                        <div class="custom-file ">
                                            <input name="avatar" style="width: 50%;font-size: 20px;"
                                                @if (isset($user->getMedia('user')->first()->filename)) data-default-file="{{ asset('storage/user/' . $user->getMedia('user')->first()->filename . '.' . $user->getMedia('user')->first()->extension) }}"
                                        @else
                                        data-default-file="" @endif
                                                type="file" id="profile" class="dropify" data-height="100" />
                                        </div>
                                    </div>
                                </div>

                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                    @php
                                        $user = auth()->user();
                                        if ($user->hasRole('hr')) {
                                            $link = route('hr.dashboard');
                                        } elseif ($user->hasRole('manager')) {
                                            $link = route('manager.dashboard');
                                        } else {
                                            $link = route('admin.dashboard');
                                        }
                                    @endphp
                                    <a href="{{ $link }}" type="submit"
                                        class="btn btn btn-outline-secondary">Back</a>

                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="changepassword" role="tabpanel" aria-labelledby="changepassword-tab">
                        <div class="card card-primary">
                            @php
                                $user = auth()->user();
                                if ($user->hasRole('hr')) {
                                    $route = route('hr.change-password.update', ['change_password' => $user->id]);
                                } elseif ($user->hasRole('manager')) {
                                    $route = route('manager.change-password.update', ['change_password' => $user->id]);
                                } else {
                                    $route = route('admin.change-password.update', ['change_password' => $user->id]);
                                }
                            @endphp


                            <form action="{{ $route }}" method="post" id="changePassword">
                                @method('patch')
                                @csrf
                                <div class="card-body">

                                    <div class="form-group">
                                        <label for="old_password">Current Password</label>
                                        <input type="text" class="form-control" id="old_password" name="old_password"
                                            placeholder="Enter your current password">
                                    </div>
                                    <div class="form-group ">
                                        <label for="password">New Password</label>
                                        <div class="password-container">
                                            <input type="password" class="form-control" id="password" name="password"
                                                placeholder="Enter new password">
                                            <span class="password-toggle" id="togglePassword">
                                                <i class="fa fa-eye-slash"></i> <!-- Default icon -->
                                            </span>
                                        </div>
                                    </div>

                                    <div class="form-group ">
                                        <label for="password_confirmation">Confirm Password</label>
                                        <input type="password" class="form-control" id="password_confirmation"
                                            name="password_confirmation" placeholder="Enter confirm password">
                                    </div>

                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                    @php
                                        $user = auth()->user();
                                        if ($user->hasRole('hr')) {
                                            $link = route('hr.dashboard');
                                        } elseif ($user->hasRole('manager')) {
                                            $link = route('manager.dashboard');
                                        } else {
                                            $link = route('admin.dashboard');
                                        }
                                    @endphp
                                    <a href="{{ $link }}" type="submit"
                                        class="btn  btn-outline-secondary">Back</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script src="{{ asset('asset/js/dropify.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            $(document).on('click', '#profiletab', function(e) {
                $(this).addClass('active');
            })

            $('.dropify').dropify();
            $(document).on('click', '#logout', function() {
                $('#logoutModel').modal('hide');
            });

            $.validator.addMethod("lettersonly", function(value, element) {
                return this.optional(element) || /^[a-zA-Z\s]+$/i.test(value);
            }, "Please enter letters only (no special characters or numbers).")

            $.validator.addMethod("validNumber", function(value, element) {
                return !/0{10}/.test(value);
            }, "{{ __('validation.valid', ['attribute' => 'mobile']) }}");

            $("#userView").validate({
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
                    mobile: {
                        required: true,
                        number: true,
                        validNumber: true,
                        minlength: 10,
                        maxlength: 10,
                        digits: true,
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
                    mobile: {
                        required: "{{ __('validation.required', ['attribute' => 'number']) }}",
                        number: "{{ __('validation.valid', ['attribute' => 'number']) }}",
                        digits: "The number must be a 10 digits",
                        minlength: "{{ __('validation.min_digits', ['attribute' => 'number', 'min' => '10']) }}",
                        maxlength: "{{ __('validation.max_digits', ['attribute' => 'number', 'max' => '10']) }}",
                    },
                },
                submitHandler: function(form) {
                    var formData = new FormData(form);
                    $(".loader-container").fadeIn();
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
                                window.location.reload();
                            }, 2000);
                        },
                        error: function(xhr, status, error) {
                            $(".loader-container").fadeOut();
                            var response = JSON.parse(xhr.responseText);
                            toastr.options = {
                                closeButton: true,
                                progressBar: true,
                            }
                            toastr.error(response.message);
                        },
                    })
                }
            })

            $('#togglePassword').click(function() {
                var passwordInput = $('#password');
                var togglePassword = $('#togglePassword');

                if (passwordInput.attr('type') === 'password') {
                    passwordInput.attr('type', 'text');
                    togglePassword.html('<i class="fa fa-eye"></i>');
                } else {
                    passwordInput.attr('type', 'password');
                    togglePassword.html('<i class="fa fa-eye-slash"></i>');
                }
            });

            $.validator.addMethod("pattern", function(value, element) {
                    return /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/.test(value);
                },
                "Password must include at least one uppercase letter, one lowercase letter, one digit, and one special character."
            );

            $("#changePassword").validate({
                errorElement: "span",
                errorClass: "text-danger fw-normal",
                rules: {
                    old_password: {
                        required: true,
                        minlength: 8,
                    },
                    password: {
                        required: true,
                        minlength: 8,
                        pattern: true,
                    },
                    password_confirmation: {
                        required: true,
                        equalTo: "#password"
                    }
                },
                messages: {
                    old_password: {
                        required: "Please enter your current password.",
                        minlength: "Password must be at least 8 characters long.",
                    },
                    password: {
                        required: "Please enter your password",
                        minlength: "Password must be at least 8 characters long"
                    },
                    password_confirmation: {
                        required: "Please confirm your password",
                        equalTo: "Passwords does not match"
                    }
                },
                submitHandler: function(form) {
                    $.ajax({
                        url: $(form).attr("action"),
                        type: $(form).attr("method"),
                        data: $(form).serialize(),
                        success: function(response) {
                            toastr.options = {
                                closeButton: true,
                                progressBar: true,
                            }
                            console.log(response);
                            toastr.success(response.success);
                            $(form).validate().resetForm();
                            form.reset();
                        },
                        error: function(xhr, status, error) {
                            var response = JSON.parse(xhr.responseText);
                            toastr.options = {
                                closeButton: true,
                                progressBar: true,
                            }
                            toastr.error(response.error);
                            $(form).validate().resetForm();
                            form.reset();
                        },
                    });
                },
            });

        });
    </script>
@endsection
