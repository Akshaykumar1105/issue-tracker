@extends('admin.layout.dashboard_layout')
@section('style')
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
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12 mt-3">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Change Password</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('hr.change-password.update') }}" method="post" id="changePassword">
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
    </section>
@endsection


@section('script')

    <script>
        $(document).ready(function() {
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
                        },
                        error: function(xhr, status, error) {
                            var response = JSON.parse(xhr.responseText);
                            toastr.options = {
                                closeButton: true,
                                progressBar: true,
                            }
                            toastr.error( response.error);

                        },
                    });
                },
            });
        });
    </script>
@endsection
