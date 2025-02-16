<?php
session_start();
include('db_connect.php'); // Ensure db_connect.php is included

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['username'])) {
        echo json_encode(["error" => "User not logged in"]);
        exit();
    }

    $content = mysqli_real_escape_string($db, $_POST['content']);
    $username = $_SESSION['username'];

    // Fetch user role
    $query = "SELECT role FROM users WHERE username='$username'";
    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($result);
    $role = $row['role'];

    // Insert post into database
    $insertQuery = "INSERT INTO post (content, username, role) VALUES ('$content', '$username', '$role')";
    if (mysqli_query($db, $insertQuery)) {
        echo json_encode(["success" => "Post added successfully"]);
    } else {
        echo json_encode(["error" => "Database error"]);
    }
}
?>
