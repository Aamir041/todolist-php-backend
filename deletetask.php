<?php
include "handlingcors.php";
include "dbconn.php";


$id;
if(isset($_GET['id'])){
    $id = $_GET['id'];
}
else{
    die("ID or user parameter is missing.");
}

$sql = "DELETE FROM tasks WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i",$id);
if($stmt->execute()){
    $response = array("status"=>"success","message"=>"Task Deleted Successfully");
    header("Content-Type:application/json");
    echo json_encode($response);
}
else{
    $response = array("status"=>"failed", "message"=>"Task Cannot Be Deleted Due Some Error");
    header("Content-Type:application/json");
    echo json_encode($response);
}

?>
