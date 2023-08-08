<?php
include "handlingcors.php";
include "dbconn.php";

if($_SERVER["REQUEST_METHOD"] === "POST"){

    $data = json_decode(file_get_contents("php://input"),true);

    $username = $data['username'];
    $password = $data['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $res = $stmt->get_result();

    if($res->num_rows == 0){
        $stmt = $conn->prepare("INSERT INTO users VALUES (?,?)");
        $stmt->bind_param("ss",$username,$password);
        if($stmt->execute()){
            $response = array("status"=>"success","message"=>"Registered Successfully","username" =>$username);
            header("Content-Type:application/json");
            echo json_encode($response);
        }
        else{
            $response = array("status"=>"failed","message"=>"Error Has Occurred");
            header("Content-Type:application/json");
            echo json_encode($response);
        }
    }
    else{
        $response = array("status"=>"invalid","message"=>"User already exists!");
        header("Content-Type:application/json");
        echo json_encode($response);
    }

    
    $stmt->close();

    $conn->close();

}

?>
