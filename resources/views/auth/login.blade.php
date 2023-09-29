<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('asset/css/loader.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
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
</head>

<body>

    <x-loader />
    <section class="vh-100">
        <div class="container-fluid h-custom d-flex justify-content-center align-items-center h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-9 col-lg-6 col-xl-5">
                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp"
                        class="img-fluid" alt="Sample image">
                </div>
                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                    <h1 class="lead fw-normal mb-0 me-3 display-6 fw-bold">Sign In</h1>
                    <form class="mt-3" role="form" method="POST" id="userlogin" action="{{ route('login') }}">

                        @csrf

                        <!-- Email input -->
                        <div class="form-outline mb-3">
                            <label class="form-label mb-3" for="email">Email<span class="text-danger">
                                    *</span></label>
                            <input type="email" name="email" value="{{ old('email') }}" id="email"
                                class="form-control" />
                        </div>

                        <!-- Password input -->
                        <div class="form-outline ">
                            <label class="form-label" for="password">Password<span class="text-danger"> *</span></label>
                            <div class="password-container">
                                <input type="password" name="password" id="password" class="form-control" />
                                <span class="password-toggle" id="togglePassword">
                                    <i class="fa fa-eye-slash"></i> <!-- Default icon -->
                                </span>

                            </div>

                            <div class="mt-4 d-flex justify-content-between align-items-center">
                                <button type="submit" class="btn btn-primary btn-block mb-2">Sign in</button>

                                <a href="{{ route('forgot-password') }}"style="text-decoration: none;">Forgot
                                    Password?</a>
                            </div>

                            <!-- Submit button -->
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script src="{{ asset('asset/js/jquery.min.js') }}"></script>
    <script src="{{ asset('asset/js/validation.min.js') }}"></script>


    <!--toastr js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"
        integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


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

            $("#userlogin").validate({
                errorClass: "text-danger",
                rules: {
                    email: {
                        required: true,
                        email: true,
                    },
                    password: {
                        required: true,
                        minlength: 6,
                    },
                },
                messages: {
                    email: {
                        required: "Please enter your email.",
                        email: "Please enter a valid email address.",
                    },
                    password: {
                        required: "Please enter your password.",
                        minlength: "Password must be at least 6 characters long.",
                    },
                },
                submitHandler: function(form) {
                    $(".loader-container").fadeIn();
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
                            toastr.options = {
                                closeButton: true,
                                progressBar: true,
                            }
                            toastr.error(response.message);

                        },
                    })
                },
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
