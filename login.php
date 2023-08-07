<?php

include 'handlingcors.php';
include 'dbconn.php';


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    /*
        is used to retrieve data sent from the client 
        (usually in JSON format) and convert it into a PHP associative array.
    */
    $data = json_decode(file_get_contents("php://input"), true);

    /* take username and password from associative array*/
    $username = $data['username'];
    $password = $data['password'];


    /* 
        Creating Sql Template 
    */

    //  prepares a SQL statement for execution
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");

    // binds the parameter to the prepared statement.
    // data types of the parameters. In this case, "s" indicates that the parameter is a string.
    $stmt->bind_param("s", $username);

    // execute method is called on the prepared statement object
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 1) {

        // fetches the current row of the result set as an associative array. 
        $row = $result->fetch_assoc();
        if ($password === $row['password']) {

            // array named $response is created, which contains data that will be sent back to the client in JSON format
            $response = array("status" => "success", "messgae" => "Logged in successfully", "username" => $username);
            // set the response's HTTP header to indicate that the response will be in JSON format.
            header("Content-Type:application/json");

            //  of code converts the PHP associative array $response into a JSON-formatted string and sends it back to the client as the response.
            echo json_encode($response);
        } else {
            $response = array("status" => "error", "message" => "Invalid Password");
            header("Content-Type: application/json");
            echo json_encode($response);
        }

    } else {
        $response = array("status" => "error", "message" => "Invalid Username");
        header("Content-Type: application/json");
        echo json_encode($response);
    }

    $stmt->close();

    $conn->close();



}


?>