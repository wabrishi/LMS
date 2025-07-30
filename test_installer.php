<?php
session_start();
// Simulate session data from previous steps
$_SESSION['db_host'] = 'localhost';
$_SESSION['db_name'] = 'lms_test';
$_SESSION['db_user'] = 'root';
$_SESSION['db_pass'] = '';
$_SESSION['site_name'] = 'Test LMS';
$_SESSION['admin_user'] = 'test_admin';
$_SESSION['admin_pass'] = 'password';
$_SESSION['admin_email'] = 'test_admin@example.com';

// Include the script to be tested
include 'public/install/step4.php';

echo "Test completed. Check for a 'config.php' file and the 'lms_test' database.\n";
?>
