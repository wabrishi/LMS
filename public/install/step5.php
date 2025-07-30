<?php
session_start();
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>LMS Installation - Complete</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Installation Complete</h1>
        <p>The LMS has been successfully installed. You can now log in with the admin account you created.</p>
        <a href="../login.php" class="btn btn-primary">Go to Login Page</a>
    </div>
</body>
</html>
