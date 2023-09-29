<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Issue Resolution Notification</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mt-5">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0">Issue Resolution Notification</h4>
                    </div>
                    <div class="card-body">
                        <p>
                            Dear User,
                        </p>
                        <p>
                            We are pleased to inform you that the issue you reported has been successfully resolved. Here are the details:
                        </p>
                        <ul>
                            <li><strong>Issue Title:</strong> {{$issue->title}}</li>
                            <li><strong>Description:</strong> {{$issue->description}}</li>
                        </ul>
                        <p>
                            If you have any further questions or concerns, please don't hesitate to contact our support team.
                        </p>
                        <p>
                            Thank you for using our issue tracking system.
                        </p>
                        <p class="text-muted">
                            Sincerely,
                            <br>
                            Issue Tracker.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
