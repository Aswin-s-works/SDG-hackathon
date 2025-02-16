<?php
$server = "localhost"; // Server where MySQL is running
$username = "root"; // Default XAMPP MySQL username
$password = ""; // Default password for XAMPP MySQL is empty
$database = "project"; // Your database name (make sure it matches exactly)

// Create connection
$db = mysqli_connect($server, $username, $password, $database);

// Check connection
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
