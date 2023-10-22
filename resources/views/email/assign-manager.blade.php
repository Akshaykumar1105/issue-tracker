<!DOCTYPE html>
<html>
<head>
    <title>Issue Assigned</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <header class="jumbotron bg-primary text-white text-center">
                    <h1>Issue Assigned</h1>
                </header>
                <hr>
                <p>Hello,</p>
                <p>{{$issue->hr->name}} HR has assigned you as the manager for the following issue:</p>
                <ul>
                    <li><strong>Issue Title:</strong> {{ $issue->title }}</li>
                    <li><strong>Description:</strong> {{ $issue->description }}</li>
                    <li><strong>Priority:</strong> {{ $issue->priority }}</li>
                    <li><strong>Due Date:</strong> {{ $issue->due_date }}</li>
                    <li><strong>Company Name:</strong> {{ $issue->company->name }}</li>
                </ul>
                <p>You can access and manage this issue through your account.</p>
                <p>
                    {{-- <a class="btn btn-primary" href="{{ route('issue.show', $issue) }}">View Issue</a> --}}
                </p>
                <p>If you have any questions or need further assistance, please contact our support team.</p>
                <p>Thanks, {{ config('app.name') }}</p>
            </div>
        </div>
    </div>
</body>
</html>