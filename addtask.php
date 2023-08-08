<?php
include "handlingcors.php";
include "dbconn.php";

$data = json_decode(file_get_contents("php://input"),true);

$task_id = $data['id'];
$username = $data['user'];
$task = $data['task'];
$status = $data['status'];

$sql = "INSERT INTO tasks VALUES (?,?,?,?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("isss",$task_id,$username,$task,$status);
if($stmt->execute()){
    $response = array("status"=>"success", "message"=>"Task Added");
    header("Content-Type:application/json");
    echo json_encode($response);
}
else{
    $response = array("status"=>"failed", "message"=>"Task Cannot Be Added Due Some Error");
    header("Content-Type:application/json");
    echo json_encode($response);
}

?>