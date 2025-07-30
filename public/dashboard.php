<?php
require_once "../src/auth.php";
requireLogin();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <h1 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h1>
    <p>Your role is: <b><?php echo htmlspecialchars($_SESSION["role"]); ?></b></p>

    <?php if (hasRole('Admin')): ?>
        <p><a href="admin/courses.php" class="btn btn-info">Manage Courses</a></p>
    <?php elseif (hasRole('Teacher')): ?>
        <p><a href="teacher/courses.php" class="btn btn-info">Manage Your Courses</a></p>
    <?php else: ?>
        <p><a href="student/courses.php" class="btn btn-info">Browse Courses</a></p>
    <?php endif; ?>

    <p>
        <a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
    </p>
</body>
</html>
