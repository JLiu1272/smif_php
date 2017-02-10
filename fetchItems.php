<?php
	session_start();
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

	//Getting the user_id 
	$query_id = "SELECT id FROM user WHERE username='$current_username'";
	$result_id = $mysqli->query($query_id);

	/* associative array */
	//Fetches the user id 
	$row_id = $result_id->fetch_array(MYSQLI_ASSOC);
	$user_id = $row_id["id"];


	//Fetches the user id 
	$sql = "SELECT * FROM items where user_id='$user_id'";

	// Check if there are results
	if ($result = mysqli_query($con, $sql))
	{
		// If so, then create a results array and a temporary one
		// to hold the data
		$resultArray = array();
		$tempArray = array();
	 
		// Loop through each row in the result set
		while($row = $result->fetch_object())
		{
			// Add each row into our results array
			$tempArray = $row;
		    array_push($resultArray, $tempArray);
		}
	 
		// Finally, encode the array to JSON and output the results
		echo json_encode($resultArray);
	}

	//Close connections 
	mysqli_close($con);
?>
