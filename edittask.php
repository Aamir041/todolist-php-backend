<?php
include "handlingcors.php";
include "dbconn.php";

$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'];
$newTask = $data['newTask'];

$sql = "UPDATE tasks SET task=? WHERE id=?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $newTask, $id);


if ($stmt->execute()) {
    $response = array("status" => "success", "messsage" => "Edited message successfully");
    header("Content-Type:application/json");
    echo json_encode($response);
} 
else {
    $response = array("status" => "failed", "messsage" => "Failed to edit");
    header("Content-Type:application/json");
    echo json_encode($response);
}

$stmt->close();
$conn->close();


?>