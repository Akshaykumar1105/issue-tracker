<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <style>
        body {
            font-family: Helvetica, Arial, sans-serif;
            max-width: 1000px;
            margin: 0 auto;
            line-height: 1.6;
            padding: 20px;
            background-color: #f7f7f7;
        }

        .container {
            background-color: #ffffff;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .box {
            margin: 50px auto;
            width: 90%;
            padding: 20px 0;
            border-bottom: 5px solid #9aa6ad;
        }

        .title {
            border-bottom: 1px solid #eee;
            text-align: center;
        }

        .title h1 {
            font-size: 2em;
            color: #00466a;
            text-decoration: none;
            font-weight: 600
        }

        .title p {
            font-size: 1em;
            color: #00466a;
            text-decoration: none;
            font-weight: 600;
        }

        .box .emailDody {
            font-size: 1.1em;
            margin-top: 20px;
        }

        .btn {
            display: inline-block;
            margin: 20px auto;
            padding: 10px 20px;
            background: #00466a;
            color: #fff;
            border: none;
            border-radius: 4px;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="box">
            <div class="title">
                <h1 href="{{ config('app.url') }}">{{ config('app.name') }}</h1>

                <p>Resent Password</p>
            </div>
            <p class="emailDody">Hello {{ $user->name }},</p>

            <p>You are receiving this email because a password reset request was made for your account.</p>

            <p>Please click the button below to reset your password:</p>
            <a href="{{ route('reset-password.index', $token) }}" class="btn">Reset Password</a>
            <p>Or copy and paste the url into your browser</p>
            <p style="font-size:0.9em;">Regards,<br />{{ config('app.name') }}</p>
        </div>
    </div>
</body>

</html>
