<?php
	
	//Grabbing the current username and password 
	session_start();
	//$current_username = "Christine";
	//$current_password = "1234";
	$current_username = $_SESSION["username"];
	$current_password = $_SESSION["password"];

	// open database
	$con = mysqli_connect("localhost","root","root","fridge_items");
	$mysqli = new mysqli("localhost","root", "root", "fridge_items");

	// Check connection
	if ($mysqli->connect_errno)
	{
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	  exit();
	}

	//Grabbing Values from app 
	$name = mysqli_real_escape_string($con, $_POST["name"]); 
	$date_in = $_POST["date_entered"];
	$expiration_date = $_POST["expiration_date"];

	/*$name = "Veggies";
	$status = 0;
	$date_in = '2013-08-30';
	$expiration_date = '2015-08-30';*/


	//Getting the user_id 
	$query_id = "SELECT id FROM user WHERE username='$current_username'";
	$result_id = $mysqli->query($query_id);
	
	/* associative array */
	//Fetches the user id 
	$row_id = $result_id->fetch_array(MYSQLI_ASSOC);
	$user_id = $row_id["id"];
	//$user_id = 1;

	$sql = "INSERT INTO `items`
			(name, status, date_in, expiration_date, user_id)
			VALUES ('$name', 0, '$date_in', '$expiration_date' , $user_id)
			ON DUPLICATE KEY UPDATE
			count = count + 1"

	// Check connection
	if (!mysqli_query($con, $sql)) {
	    $response = array("success" => false, "message" => mysqli_error($con), "sqlerrno" => mysqli_errno($con), "sqlstate" => mysqli_sqlstate($con));
	} else {
	    $response = array("success" => true);
	}

	echo json_encode($response);

	mysqli_close($con);

	//$sql = "INSERT INTO item "

?>