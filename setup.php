<?php
// Database configuration
require_once 'config/database.php';

// Create connection
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS " . DB_NAME;
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully or already exists\n";
} else {
    echo "Error creating database: " . $conn->error . "\n";
}

// Select database
$conn->select_db(DB_NAME);

// Read SQL file
$sql = file_get_contents('init.sql');

// Execute multi query
if ($conn->multi_query($sql)) {
    echo "Database setup completed successfully\n";
} else {
    echo "Error setting up database: " . $conn->error . "\n";
}

$conn->close();
?>
