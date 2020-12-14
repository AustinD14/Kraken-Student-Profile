<?php
// Database configuration
$dbHost     = "localhost";
$dbUsername = "pma";
$dbPassword = "123456";
$dbName     = "Student_Profile";

// Create database connection
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
?>