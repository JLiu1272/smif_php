<?php

require 'connect.php';

// specify that this will return JSON
session_start();
header('Content-type: application/json');

$username = $_POST["username"];
$password = $_POST["password"];

//$username = 'Jennifer';
//$password = '1234';

// get the parameters
//$username = "Christine";
//$password = "1234";


//Session 
//This ensures that this information is accessible throughout
//the application
$_SESSION["username"] = $username;
$_SESSION["password"] = $password;


$query = "SELECT username, password FROM user WHERE username='$username'";
$result = $pdo->prepare($query);
$result->execute();

/* associative array */
$row = $result->fetch(PDO::FETCH_ASSOC);
$hash = $row["password"];

if(password_verify($password,$hash)){
	echo "valid";
}
else{
	echo "invalid";
}

//echo $row["username"] . $row["password"];
?>
