<?php

// specify that this will return JSON
session_start();
header('Content-type: application/json');
 
// Create connection
$con=mysqli_connect("localhost","root","root","fridge_items");

$mysqli = new mysqli("localhost","root", "root", "fridge_items");
 
// Check connection
if ($mysqli->connect_errno)
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}

$username = mysqli_real_escape_string($con, $_POST["username"]);
$password = mysqli_real_escape_string($con, $_POST["password"]);

//$username = 'jennifer';
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
$result = $mysqli->query($query);

/* associative array */
$row = $result->fetch_array(MYSQLI_ASSOC);
$hash = $row["password"];

if(password_verify($password,$hash)){
	echo 'valid';
}
else{
	echo 'invalid';
}

//echo $row["username"] . $row["password"];

// Close connections
mysqli_close($con);
?>