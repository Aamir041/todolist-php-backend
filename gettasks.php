<?php
include "handlingcors.php";
include "dbconn.php";

// if ($_SERVER["REQUEST_METHOD"] === "GET") {

//     $sql = "SELECT * FROM tasks";

//     $stmt = $conn->prepare($sql);
//     $stmt->execute();

//     $result = $stmt->get_result();


//     $data = $result->fetch_all(MYSQLI_ASSOC);
//     $response = array("status" => "success", "message" => "Retrieved", "data" => $data);
//     header("Content-Type:application/json");
//     echo json_encode($response);


// }

if (isset($_GET['user'])) {
    $user = $_GET['user'];
} else {
    die("User parameter is missing.");
}

// Step 3: Write the SQL SELECT statement
$sql = "SELECT *  FROM tasks WHERE user = ?";

// Step 4: Prepare and execute the SQL statement
$stmt = $conn->prepare($sql);

// if ($stmt === false) {
//     die("Prepare failed: " . $conn->error);
// }

$stmt->bind_param("s", $user);
$stmt->execute();

// Step 5: Fetch the rows and format as JSON
$result = $stmt->get_result();

$tasks = array();

while ($row = $result->fetch_assoc()) {
    $tasks[] = $row;
}

// Step 6: Set headers and echo the JSON response
header("Content-Type: application/json");
echo json_encode($tasks);


?>