<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mt-5">
                    <div class="card-header">
                        Password Reset
                    </div>
                    <div class="card-body">
                        <p>You are receiving this email because a password reset request was made for your account.</p>
                        <p>
                            Please click the button below to reset your password:
                        </p>
                        <a href="{{route('reset-password.index' , $token)}}" class="btn btn-primary">Reset Password</a>
                        <p>If you did not request a password reset, no further action is required.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Include Bootstrap JS (optional) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
