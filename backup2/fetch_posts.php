<?php
include('db_connect.php');

$query = "SELECT * FROM post ORDER BY timestamp DESC";
$result = mysqli_query($db, $query);

$posts = [];
while ($row = mysqli_fetch_assoc($result)) {
    $posts[] = $row;
}

echo json_encode($posts);
?>
