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
            margin: 0px auto;
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

                <p>Create Your Issues</p>
            </div>
            <p class="emailDody">Hello, {{$user->name}}</p>

            <p>Here's how you can submit issues:</p>

             <ol>
                <li><a href="{{ route('issue.index', ['company' => $user->uuid]) }}">Click </a>on the following link to access our issue submission form:</li>
            </ol>
            <ol start="2">
                <li>Fill out the form with details about the issue you're experiencing. Please be as specific as possible, including any error messages.</li>
            </ol>
            
            <p>If you have any questions or need further assistance, don't hesitate to contact our dedicated support team at <a href="mailto:support@issuetracker.com">support@issuetracker.com</a>.</p>
            
            <p>Regards, {{ config('app.name') }}</p>
        </div>
    </div>
</body>

</html>
