<?php
// Initialize the session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function isLoggedIn() {
    return isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true;
}

function requireLogin() {
    if (!isLoggedIn()) {
        header("location: /login.php");
        exit;
    }
}

function hasRole($role) {
    return isset($_SESSION["role"]) && $_SESSION["role"] === $role;
}

function requireRole($role) {
    requireLogin();
    if (!hasRole($role)) {
        // You can redirect to an unauthorized page or show an error
        http_response_code(403);
        echo "Forbidden: You don't have permission to access this page.";
        exit;
    }
}
?>
