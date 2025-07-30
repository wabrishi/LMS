<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['site_name'] = $_POST['site_name'];
    $_SESSION['admin_user'] = $_POST['admin_user'];
    $_SESSION['admin_pass'] = $_POST['admin_pass'];
    $_SESSION['admin_email'] = $_POST['admin_email'];

    header('Location: step4.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>LMS Installation - Step 3</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Site Configuration</h1>
        <form method="post">
            <div class="form-group">
                <label for="site_name">Site Name</label>
                <input type="text" class="form-control" id="site_name" name="site_name" required>
            </div>
            <hr>
            <h2>Admin Account</h2>
            <div class="form-group">
                <label for="admin_user">Admin Username</label>
                <input type="text" class="form-control" id="admin_user" name="admin_user" required>
            </div>
            <div class="form-group">
                <label for="admin_pass">Admin Password</label>
                <input type="password" class="form-control" id="admin_pass" name="admin_pass" required>
            </div>
            <div class="form-group">
                <label for="admin_email">Admin Email</label>
                <input type="email" class="form-control" id="admin_email" name="admin_email" required>
            </div>
            <button type="submit" class="btn btn-primary">Install</button>
        </form>
    </div>
</body>
</html>
