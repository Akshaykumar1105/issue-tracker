<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Forget Password</title>
    <style>
        .loader-container {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9999;
        }

        .loader {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border: 5px solid #f3f3f3;
            border-top: 5px solid #007bff;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: translate(-50%, -50%) rotate(0deg);
            }

            100% {
                transform: translate(-50%, -50%) rotate(360deg);
            }
        }
    </style>
</head>

<body class="vh-100">
    <div class="loader-container">
        <div class="loader"></div>
    </div>
    <div class="max-w-xs mx-auto d-flex  align-items-center h-100">
        <div class="max-w-xs xl:w-75 my-10 mx-auto">
            <div class="bg-white p-5 rounded-xl shadow">
                <h1 class="text-center text-4xl font-weight-bold">Reset Password</h1>
                <p class="text-center text-muted">Fill out the form to reset your password</p>

                <form method="post" action="{{ route('forgot-Password.store') }}" id="forgotpassword" class="my-4">

                    @csrf
                    <div class="form-group">
                        <label for="email" class="fw-bold text-dark mb-2">Email address<span
                                class="text-danger ms-2">*</span></label>
                        <input type="email" class="form-control " id="email" name="email"
                            placeholder="Enter email address">
                        <label id="email-error" class="error text-danger" for="email"></label>
                        @error('email')
                            <p class="text-danger text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <button class="btn btn-primary w-100 my-3 d-flex align-items-center" type="submit">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            width="30" height="30" class="me-3">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z" />
                        </svg>
                        Reset Password Link
                    </button>

                    <p class="text-center">Not registered yet? <a href="{{ route('hr.register.create') }}"
                            class="text-primary font-weight-bold">Register now</a></p>
                </form>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>


    <!--toastr js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"
        integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script>
        $(document).ready(function() {

            function sendLink(form) {
                $.ajax({
                    url: $(form).attr("action"),
                    type: $(form).attr("method"),
                    data: $(form).serialize(),
                    complete: function() {
                        $(".loader-container").fadeOut();
                    },
                    success: function(response) {
                        var message = response.message;
                        toastr.options = {
                            closeButton: true,
                            progressBar: true,
                        }
                        toastr.success(message);
                    },
                    error: function(xhr, status, error) {
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
            $("#forgotpassword").validate({
                rules: {
                    email: {
                        required: true,
                        email: true,
                    }
                },
                messages: {
                    email: {
                        required: "{{__('validation.required', ['attribute' => 'email'])}}",
                        email: "{{__('validation.valid' , ['attribute' => 'email'])}}",
                    },
                },
                submitHandler: function(form) {
                    $(".loader-container").fadeIn();
                    sendLink(form)
                },
            });
        });
    </script>
</body>

</html>
<!-- Pills navs -->
