<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['site_name'] = $_POST['site_name'];
    $_SESSION['admin_user'] = $_POST['admin_user'];
    $_SESSION['admin_pass'] = $_POST['admin_pass'];
    $_SESSION['admin_email'] = $_POST['admin_email'];
}

$config_content = "<?php\n";
$config_content .= "define('DB_SERVER', '" . $_SESSION['db_host'] . "');\n";
$config_content .= "define('DB_USERNAME', '" . $_SESSION['db_user'] . "');\n";
$config_content .= "define('DB_PASSWORD', '" . $_SESSION['db_pass'] . "');\n";
$config_content .= "define('DB_NAME', '" . $_SESSION['db_name'] . "');\n";
$config_content .= "define('SITE_NAME', '" . $_SESSION['site_name'] . "');\n";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>LMS Installation - Step 4</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Create Configuration File</h1>
        <p>Please create a file named <code>config.php</code> in the root directory of the application with the following content:</p>
        <pre><?php echo htmlspecialchars($config_content); ?></pre>
        <a href="step5.php" class="btn btn-primary">I have created the file</a>
    </div>
</body>
</html>
