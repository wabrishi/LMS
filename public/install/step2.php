<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['db_host'] = $_POST['db_host'];
    $_SESSION['db_name'] = $_POST['db_name'];
    $_SESSION['db_user'] = $_POST['db_user'];
    $_SESSION['db_pass'] = $_POST['db_pass'];

    header('Location: step3.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>LMS Installation - Step 2</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Database Configuration</h1>
        <form method="post">
            <div class="form-group">
                <label for="db_host">Database Host</label>
                <input type="text" class="form-control" id="db_host" name="db_host" value="localhost" required>
            </div>
            <div class="form-group">
                <label for="db_name">Database Name</label>
                <input type="text" class="form-control" id="db_name" name="db_name" required>
            </div>
            <div class="form-group">
                <label for="db_user">Database User</label>
                <input type="text" class="form-control" id="db_user" name="db_user" required>
            </div>
            <div class="form-group">
                <label for="db_pass">Database Password</label>
                <input type="password" class="form-control" id="db_pass" name="db_pass">
            </div>
            <button type="submit" class="btn btn-primary">Next</button>
        </form>
    </div>
</body>
</html>
