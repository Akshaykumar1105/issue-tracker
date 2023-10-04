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
                    <div class="card-header">Issue Review Request</div>

                    <div class="card-body">
                        <p class="card-text">A manager has changed the status of an issue to "Send for Review." Please review the issue details below:</p>
                        
                        <p><strong>Issue Title:</strong> {{ $issue->title }}</p>
                        <p><strong>Issue Description:</strong> {{ $issue->description }}</p>
                        
                        <p>Thank you for your attention to this matter.</p>
                    </div>

                    <div class="card-footer">
                        <a href="{{ route('hr.issue.index', ['listing' => 'review-issue']) }}" class="btn btn-primary">Review Issue</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap JS (optional) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
