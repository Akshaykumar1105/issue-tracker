<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Successful</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }
        .header {
            background-color: #007bff;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }
        .content {
            padding: 20px;
        }
        .message {
            font-size: 18px;
            line-height: 1.5;
        }
        .button-container {
            text-align: center;
            margin-top: 20px;
        }
        .btn {
            display: inline-block;
            background-color: #007bff;
            color: #ffffff;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .footer {
            background-color: #f4f4f4;
            padding: 10px 0;
            text-align: center;
        }
        .footer p {
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Password Reset Successful</h2>
        </div>
        <div class="content">
            <p class="message">Hello,</p>
            <p class="message">We are writing to inform you that your password has been successfully reset.</p>
            <p class="message">If you did not request this change, please contact our support team immediately.</p>
            <div class="button-container">
                <a href="{{route('login')}}" class="btn">Login</a>
            </div>
        </div>
        <div class="footer">
            <p>&copy; 2023 Issue Tracker. All rights reserved.</p>
        </div>
    </div>
</body>
</html>