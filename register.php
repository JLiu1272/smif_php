<?php

// specify that this will return JSON
//Creating Session so that I know who is logged in 
session_start();

header('Content-type: application/json');

// open database

$con = mysqli_connect("localhost","root","root","fridge_items");

// Check connection

if (mysqli_connect_errno()) {
    echo json_encode(array("success" => false, "message" => mysqli_connect_error(), "sqlerrno" => mysqli_connect_errno()));
    exit;
}

// get the parameters
//$username = "Christine";
//$password = "1234";

$username = mysqli_real_escape_string($con, $_POST["username"]);
$password = mysqli_real_escape_string($con, $_POST["password"]);

//Session 
//This ensures that this information is accessible throughout
//the application
$_SESSION["username"] = $username;
$_SESSION["password"] = $password;

// perform the insert
//Hash password 
$hashPwd = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO user (username, password) VALUES ('{$username}', '{$hashPwd}')";

if (!mysqli_query($con, $sql)) {
    $response = array("success" => false, "message" => mysqli_error($con), "sqlerrno" => mysqli_errno($con), "sqlstate" => mysqli_sqlstate($con));
    echo "duplicate";
} else {
    $response = array("success" => true);
}

//echo json_encode($response);

mysqli_close($con);

?>