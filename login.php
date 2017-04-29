<?php

require 'connect.php';

// specify that this will return JSON
session_start();
header('Content-type: application/json');

if($_SERVER['REQUEST_METHOD'] === 'POST'){
	$username = $_POST["username"];
	$password = $_POST["password"];
	$token = $_POST["token"];

	//Session 
	//This ensures that this information is accessible throughout
	//the application
	$_SESSION["username"] = $username;
	$_SESSION["password"] = $password;


	$query = "SELECT id, username, password FROM user WHERE username='$username'";
  	$result = $pdo->prepare($query);
  	$result->execute();

  	//associative array
  	$row = $result->fetch(PDO::FETCH_ASSOC);
  	$hash = $row["password"];
  	$user_id = $row["id"];

	if(password_verify($password,$hash)){
		$query_id = $pdo->prepare("UPDATE user
                                    SET token = $token
                                    WHERE id = $user_id;"); 
        $query_id->execute();
        //echo $token;
		echo "valid";
	}
	else{
		echo "invalid";
	}
}

//echo $row["username"] . $row["password"];
?>
