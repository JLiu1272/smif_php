<?php
	//Grabbing the current username and password 
	ini_set('display_errors',1);
	ini_set('display_startup_errors',1);
	error_reporting(E_ALL);

	require 'vendor/autoload.php';

	use JWage\APNS\Certificate;
	use JWage\APNS\Client;
	use JWage\APNS\Sender;
	use JWage\APNS\SocketClient;

	session_start();
	//$current_username = "Christine";
	//$current_password = "1234";
	$current_username = "";
	$current_password = "";

	if(isset($current_username) && isset($current_password)){
		$current_username = 'Jennifer';
		$current_password = '1234';
	}
	else{
		$current_username = $_SESSION["username"];
		$current_password = $_SESSION["password"];
	}

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
	//$name = mysqli_real_escape_string($con, $_POST["name"]); 
	//$date_in = $_POST["date_entered"];
	//$expiration_date = $_POST["expiration_date"];
	$entityBody = file_get_contents('php://input');
	// die($entityBody);
	$d_js =  json_decode($entityBody,true);
	//$input_name = $d_js['None'][0][0];
	$input_name = "002Cereal";
	$truncate_name = substr($input_name, 3); 

	//$name = "Oranges";
	//$status = 0;
	$date_in = '2013-08-30';
	$expiration_date = '2015-08-30';


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
			VALUES ('$truncate_name', 0, '$date_in', '$expiration_date' , $user_id)
			ON DUPLICATE KEY UPDATE
			count = count + 1";

	// Check connection
	if (!mysqli_query($con, $sql)) {
	    $response = array("success" => false, "message" => mysqli_error($con), "sqlerrno" => mysqli_errno($con), "sqlstate" => mysqli_sqlstate($con));
	} else {
	    $response = array("success" => true);

		$certificate = new Certificate(file_get_contents('/Users/JenniferLiu/Desktop/smif_final/apple_push_notification_production.pem'));
		$socketClient = new SocketClient($certificate, 'gateway.sandbox.push.apple.com', 2195);
		$client = new Client($socketClient);
		$sender = new Sender($client);

		$sender->send('51ba8b4b36e68cd747890cc39c2d61f80eb8436255acc55a1ca14f474963c2bc', "$truncate_name", "$truncate_name has been added to fridge"  , 'http://deeplink.com');
	}

	echo json_encode($response);
	mysqli_close($con);
?>