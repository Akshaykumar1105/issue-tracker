<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Issue Review Request</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"></div>

                    <div class="card-body">
                        <p class="card-text">A manager has changed the status of an issue to "Send for Review." Please review the issue details below:</p>
                        
                        <p><strong>Issue Title:</strong> {{ $issue->title }}</p>
                        <p><strong>Issue Description:</strong> {{ $issue->description }}</p>
                        
                        <p>Thank you for your attention to this matter.</p>
                    </div>

                    <div class="card-footer">
                        <a href="{{ route('hr.issue.edit', ['issue' => $issue->id]) }}" class="btn btn-primary">Review Issue</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
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

                <p>Issue Review Request</p>
            </div>
            <p class="emailDody">Hello {{ $issue->hr->name }},</p>

            <p class="card-text">A manager has changed the status of an issue to "Send for Review." Please review the issue details below:</p>

            <ul>
                <li><strong>Issue Title:</strong> {{ $issue->title }}</li>
                <li><strong>Description:</strong> {{ $issue->description }}</li>
                <li><strong>Assign manager:</strong> {{ $issue->manager->name }}</li>
                <li><strong>Priority:</strong> {{ ucwords(strtolower($issue->priority)) }}</li>
                <li><strong>Status:</strong> {{ str_replace('_', ' ', ucwords(strtolower($issue->status))) }}</li>
                <li><strong>Due Date:</strong> {{ date(config('site.date'), strtotime($issue->due_date)) }}</li>
                <li><strong>Company Name:</strong> {{ $issue->company->name }}</li>
            </ul>
            
            <p style="font-size:0.9em;">Regards,<br />{{ config('app.name') }}</p>
        </div>
    </div>
</body>

</html>
