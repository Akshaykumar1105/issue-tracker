<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Issue Status Changed</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    @if ($issue->status == 'SEND_FOR_REVIEW')
        <div class="container">
            <header class="jumbotron bg-primary text-white text-center">
                <h1>{{ $issue->status == 'SEND_FOR_REVIEW' ? 'Issue Report Submission' : 'Issue Status Changed' }}</h1>
            </header>
            <section>
                <div class="card-body">
                    <p class="card-text">A {{ $issue->user->name }} has changed the status of an issue to "Send
                        for Review." Please review the issue details below:</p>

                    <p><strong>Issue Title:</strong> {{ $issue->title }}</p>
                    <p><strong>Issue Description:</strong> {{ $issue->description }}</p>

                    <p>Thank you for your attention to this matter.</p>
                </div>

                <div class="card-footer">
                    <a href="{{ route('hr.issue.index', ['listing' => 'review-issue']) }}" class="btn btn-primary">Review
                        Issue</a>
                </div>
            </section>
        </div>
    @else
        <div class="container">
            <header class="jumbotron bg-primary text-white text-center">
                <h1>{{ $issue->status == 'SEND_FOR_REVIEW' ? 'Issue Report Submission' : 'Issue Status Changed' }}</h1>
            </header>
            <section>
                <p>Hello,{{ $user->name }}</p>
                <p>The status of the following issue has been changed:</p>
                <ul>
                    <li><strong>Issue Title:</strong> {{ $issue->title }}</li>
                    <li><strong>New Status:</strong> {{ str_replace('_', ' ', ucwords(strtolower($issue->status))) }}
                    </li>
                </ul>
                <p>You can access and manage this issue through your account:</p>
                <a href="{{ route('login') }}">Login</a>
                <p>If you have any questions or need further assistance, please contact our support team.</p>
                <p>Thanks, {{ config('app.name') }}</p>
            </section>
        </div>
    @endif

</body>

</html>
