<?php
$conn = new mysqli("localhost", "root",'', "todolist");

$con_res = true;
if(mysqli_connect_error()){
    $con_res=false;
}
?>