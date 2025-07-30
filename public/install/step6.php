<?php
session_start();
require_once '../../config.php';

$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$db_name = DB_NAME;
if (!$conn->query("CREATE DATABASE IF NOT EXISTS `$db_name`")) {
    die("Error creating database: " . $conn->error);
}
$conn->select_db($db_name);

$sql = file_get_contents('../../init.sql');
if (!$conn->multi_query($sql)) {
    die("Error setting up database: " . $conn->error);
}

do {
    if ($res = $conn->store_result()) {
        $res->free();
    }
} while ($conn->more_results() && $conn->next_result());

$username = $_SESSION['admin_user'];
$password = password_hash($_SESSION['admin_pass'], PASSWORD_DEFAULT);
$email = $_SESSION['admin_email'];

$sql = "INSERT INTO users (username, password, email) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $username, $password, $email);
$stmt->execute();
$user_id = $stmt->insert_id;

$sql = "INSERT INTO user_roles (user_id, role_id) VALUES (?, (SELECT id FROM roles WHERE name = 'Admin'))";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();

$conn->close();

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
