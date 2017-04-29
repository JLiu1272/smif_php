<?php

	ini_set('display_errors',1);
	ini_set('display_startup_errors',1);
	error_reporting(E_ALL);
	session_start();

	var_dump($_POST);

	if(isset($_SESSION["username"]) && isset($_SESSION["password"]) && !empty($_SESSION["username"]) && !empty($_SESSION["password"])){
		$current_username = $_SESSION["username"];
		$current_password = $_SESSION["password"];
	}
	else{
		$current_username = "Christine";
		$current_password = "1234";
	}

	// open database
	$con = mysqli_connect("smif.ct8vehnhv9o3.us-east-1.rds.amazonaws.com","jwt7689","smiffy_admin","SMIF");
	$mysqli = new mysqli("smif.ct8vehnhv9o3.us-east-1.rds.amazonaws.com","jwt7689", "smiffy_admin", "SMIF");

	// Check connection
	if ($mysqli->connect_errno)
	{
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	  exit();
	}

	$entityBody = file_get_contents('php://input');
	$d_js =  json_decode($entityBody,true);

	if($_SERVER['REQUEST_METHOD'] === 'POST'){
		
		$input_name = $_POST["name"];
		$truncate_name = substr($input_name, 3); 

		//Testing
		$status = 0;
		$date_in = $_POST["date_in"];
		$expiration_date = $_POST["date_left"];


		//Getting the user_id 
		$query_id = "SELECT id FROM user WHERE username='$current_username'";
		
		$result_id = $mysqli->query($query_id) or trigger_error($mysqli->error."[$query_id]");
		
		//Fetches the user id 
		$row_id = $result_id->fetch_array(MYSQLI_ASSOC);
		$user_id = $row_id["id"];

		//$user_id = 2;

		$sql = "DELETE FROM item WHERE items=input_name";

		// Check connection
		if (!mysqli_query($con, $sql)) {
		    $response = array("success" => false, "message" => mysqli_error($con), "sqlerrno" => mysqli_errno($con), "sqlstate" => mysqli_sqlstate($con));
		} else {
		    $response = array("success" => true);
		}

		echo json_encode($response);
		mysqli_close($con);
	}

?>