<?php
include "handlingcors.php";
include "dbconn.php";

if (isset($_GET['user'])) {
    $user = $_GET['user'];
} else {
    die("User parameter is missing.");
}

$sql = "SELECT *  FROM tasks WHERE user = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user);
$stmt->execute();

$result = $stmt->get_result();

$tasks = array();

while ($row = $result->fetch_assoc()) {
    $tasks[] = $row;
}

header("Content-Type: application/json");
echo json_encode($tasks);

$stmt->close();
$conn->close();


?>