<?php
session_start();
include('db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $post_id = $_POST['post_id'];
    $vote_type = $_POST['vote_type'];

    if ($vote_type == "up") {
        $query = "UPDATE post SET votes = votes + 1 WHERE id = $post_id";
    } elseif ($vote_type == "down") {
        $query = "UPDATE post SET votes = votes - 1 WHERE id = $post_id";
    }

    if (mysqli_query($db, $query)) {
        echo json_encode(["success" => "Vote updated"]);
    } else {
        echo json_encode(["error" => "Database error"]);
    }
}
?>
