<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Credentials</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }
        .header {
            background-color: #007bff;
            color: #fff;
            padding: 20px;
            text-align: center;
        }
        .content {
            padding: 20px;
        }
        .credentials {
            font-size: 18px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Manager Credentials</h2>
        </div>
        <div class="content">
            <p>Hello,</p>
            <p>Here are the login credentials for the manager:</p>
            <div class="credentials">
                <p><strong>Email:</strong>{{$email}}</p>
                <p><strong>Password:</strong> {{$password}}</p>
            </div>
            <p>Please use these credentials to access the manager's account.</p>
            <p>If you have any questions or need assistance, please feel free to contact us.</p>
            <p>Thank you!</p>
        </div>
    </div>
</body>
</html>