<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
    <h1>Issue Assigned</h1>
    <p>Hello, User</p>
     <p>An {{$issue->hr->name}} has assigned {{$issue->user->name}} manager for the following issue:</p>
    <ul>
        <li><strong>Issue Title:</strong> {{ $issue->title }}</li>
        <li><strong>Description:</strong> {{ $issue->description }}</li>
        <li><strong>Priority:</strong> {{ $issue->priority }}</li>
        <li><strong>Company Name:</strong> {{ $issue->company->name }}</li>
    </ul>
    <p>You can access and manage this issue through your account:</p> 
    {{-- <a href="{{ $route }}">View Issue</a> --}}
    <p>If you have any questions or need further assistance, please contact our support team.</p>
    {{-- <p>Thanks, {{ config('app.name') }}</p> --}}
</body>
</html>
