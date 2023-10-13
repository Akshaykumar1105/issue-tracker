<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Issues</title>
    <!-- Include Bootstrap CSS (adjust the path as needed) -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <!-- Header Section -->
        <header class="jumbotron bg-primary text-white text-center">
            <h1>Submit Issues</h1>
        </header>

        <!-- Content Section -->
        <section>
            <p>Hello {{$user->name}},</p>
            <p>We hope this message finds you well. We greatly value your feedback and want to make it easy for you to report any issues or problems you may encounter while using our services.</p>
            <p>Here's how you can submit issues:</p>
            <ol>
                <li>Click on the following link to access our issue submission form:</li>
            </ol>
            <p><a href="{{ route('issue.index', ['company' => $user->uuid]) }}" class="btn btn-success  ms-3">Submit Issues</a></p>
            <ol start="2">
                <li>Fill out the form with details about the issue you're experiencing. Please be as specific as possible, including any error messages or screenshots if applicable.</li>
                <li>Submit the form, and our support team will review your report promptly.</li>
            </ol>
            <p>If you have any questions or need further assistance, don't hesitate to contact our dedicated support team at support@example.com.</p>
            <p>We appreciate your help in improving our services and ensuring a smooth experience for all our users.</p>
        </section>

        <!-- Footer Section -->
        <footer class="mt-4 text-center">
            <p>Thank you for choosing us as your service provider.</p>
        </footer>
    </div>
</body>
</html>
