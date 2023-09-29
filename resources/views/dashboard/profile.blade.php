@extends('dashboard.layout.dashboard_layout')
@section('style')
    <link rel="stylesheet" href="{{ asset('asset/css/dropify.min.css') }}">
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
                                            <input name="profile_img" style="width: 50%;font-size: 20px;"
                                                @if (isset($user->getMedia('user')->first()->filename)) data-default-file="{{ asset('storage/user/' . $user->getMedia('user')->first()->filename . '.' . $user->getMedia('user')->first()->extension) }}"
                                        @else
                                        data-default-file="" @endif
                                                type="file" id="profile" class="dropify" data-height="100" />
                                        </div>
                                    </div>
                                </div>

                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
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
                                    <button type="submit" class="btn btn-primary">Submit</button>
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
            // Show the first tab by default
            // $('.tabs-stage div').hide();
            // $('.tabs-stage div:first').show();
            // $('.tabs-nav li:first').addClass('tab-active');

            // // Change tab class and display content
            // $('.tabs-nav a').on('click', function(event) {
            //     event.preventDefault();
            //     $('.tabs-nav li').removeClass('tab-active');
            //     $(this).parent().addClass('tab-active');
            //     $('.tabs-stage div').hide();
            //     $($(this).attr('href')).show();
            // });


            $('.dropify').dropify();
            $(document).on('click', '#logout', function() {
                $('#logoutModel').modal('hide');
            });
            $("#userView").validate({
                errorClass: "text-danger",
                rules: {
                    name: {
                        required: true,
                    },
                    email: {
                        required: true,
                        email: true,
                    },
                    mobile: {
                        required: true,
                        minlength: 10,
                        maxlength: 10,
                        digits: true
                    },
                },
                messages: {
                    email: {
                        required: "Please enter your email.",
                        email: "Please enter a valid email address.",
                    },
                    mobile: {
                        required: "Please enter your 10-digit mobile number.",
                        minlength: "Mobile number must be exactly 10 digits.",
                        maxlength: "Mobile number must be exactly 10 digits.",
                        digits: "Mobile number can only contain numeric digits."
                    },
                },
                submitHandler: function(form) {
                    var formData = new FormData(form);
                    $.ajax({
                        url: $(form).attr("action"),
                        type: $(form).attr("method"),
                        data: formData,
                        processData: false, // Important: Don't process the data
                        contentType: false,
                        success: function(response) {

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

            // password hide show
            $('#togglePassword').click(function() {
                var passwordInput = $('#password');
                var togglePassword = $('#togglePassword');

                if (passwordInput.attr('type') === 'password') {
                    passwordInput.attr('type', 'text');
                    togglePassword.html('<i class="fa fa-eye"></i>'); // Icon for hide
                } else {
                    passwordInput.attr('type', 'password');
                    togglePassword.html('<i class="fa fa-eye-slash"></i>'); // Icon for show
                }
            });

            // change password

            $("#changePassword").validate({
                errorElement: "span",
                errorClass: "text-danger",
                rules: {
                    old_password: {
                        required: true,
                        minlength: 8,
                    },
                    password: {
                        required: true,
                        minlength: 8, // Minimum password length
                    },
                    password_confirmation: {
                        required: true,
                        equalTo: "#password" // Confirm password must match password
                    }
                },
                messages: {
                    // ... (previous messages)
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
                        equalTo: "Passwords do not match"
                    }
                },
                submitHandler: function(form) {
                    $.ajax({
                        url: $(form).attr("action"),
                        type: $(form).attr("method"),
                        data: $(form).serialize(),
                        success: function(response) {
                            console.log(response.success);
                            toastr.options = {
                                closeButton: true,
                                progressBar: true,
                            }
                            toastr.success(response.success);
                            // setTimeout(function() {
                            //     window.location.href = response.route;
                            // }, 2000);
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