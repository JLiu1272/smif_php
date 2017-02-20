<?php
	ini_set('display_errors',1);
	ini_set('display_startup_errors',1);
	error_reporting(E_ALL);

	$dbhost = $_SERVER["smif.ct8vehnhv9o3.us-east-1.rds.amazonaws.com"];
	$dbport = $_SERVER["3306"];
	$dbname = $_SERVER["SMIF"];
	$charset = 'utf8' ;

	$dsn = "mysql:host={$dbhost};port={$dbport};dbname={$dbname};charset={$charset}";
	$username = $_SERVER['jwt7689'];
	$password = $_SERVER['smiffy_admin'];

	$pdo = new PDO($dsn, $username, $password);


	// Check connection
	if ($mysqli->connect_errno)
	{
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	  exit();
	} 

	session_start();
	header('Content-Type: application/json');
	$current_username = "";
	$current_password = "";
	if(isset($current_username) && isset($current_password)){
		$current_username = "Jennifer";
		$current_password = "1234";
	}
	else{
		$current_username = $_SESSION["username"];
		$current_password = $_SESSION["password"];
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
