<?php
session_start();

// Write config file
$config_content = "<?php\n";
$config_content .= "define('DB_SERVER', '" . $_SESSION['db_host'] . "');\n";
$config_content .= "define('DB_USERNAME', '" . $_SESSION['db_user'] . "');\n";
$config_content .= "define('DB_PASSWORD', '" . $_SESSION['db_pass'] . "');\n";
$config_content .= "define('DB_NAME', '" . $_SESSION['db_name'] . "');\n";
$config_content .= "define('SITE_NAME', '" . $_SESSION['site_name'] . "');\n";

file_put_contents('../../config.php', $config_content);

// Create database and tables
$conn = new mysqli($_SESSION['db_host'], $_SESSION['db_user'], $_SESSION['db_pass']);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->query("CREATE DATABASE IF NOT EXISTS " . $_SESSION['db_name']);
$conn->select_db($_SESSION['db_name']);

$sql = file_get_contents('../../init.sql');
$conn->multi_query($sql);

// Wait for multi_query to finish
while ($conn->next_result()) {
    if ($res = $conn->store_result()) {
        $res->free();
    }
}

// Create admin user
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

header('Location: step5.php');
exit;
?>
