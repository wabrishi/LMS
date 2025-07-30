<?php
// Check if config file exists
if (!file_exists('../config.php')) {
    header('Location: install/index.php');
    exit;
}

// If config file exists, redirect to login page
header('Location: login.php');
exit;
?>
