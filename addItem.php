<?php
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

	var_dump($_POST);

	if(isset($current_username) && isset($current_password)){
		$current_username = 'Christine';
		$current_password = '1234';
	}
	else{
		$current_username = $_SESSION["username"];
		$current_password = $_SESSION["password"];
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

	//Grabbing Values from app 
	$entityBody = file_get_contents('php://input');
	$d_js =  json_decode($entityBody,true);
	//$input_name = $d_js['None'][0][0];

	//Getting the user_id 
	$query_token = "SELECT token_id FROM TOKEN WHERE id=1";
	
	$result_token = $mysqli->query($query_token) or trigger_error($mysqli->error."[$query_token]");
	echo $result_token;
	
	if($_SERVER['REQUEST_METHOD'] === 'POST'){
		
		$input_name = $_POST["name"];
		$truncate_name = substr($input_name, 3); 

		//Testing
		//$truncate_name = "Oranges";
		$status = 0;
		//$date_in = "2017-03-21";
		//$expiration_date = "2017-03-22";
		$date_in = $_POST["date_in"];
		$expiration_date = $_POST["date_left"];


		//Getting the user_id 
		$query_id = "SELECT id FROM user WHERE username='$current_username'";
		
		$result_id = $mysqli->query($query_id) or trigger_error($mysqli->error."[$query_id]");
		
		//Fetches the user id 
		$row_id = $result_id->fetch_array(MYSQLI_ASSOC);
		$user_id = $row_id["id"];

		//Getting the user_id 
		$query_token = "SELECT token_id FROM TOKEN WHERE id=1";
		
		$result_token = $mysqli->query($query_token) or trigger_error($mysqli->error."[$query_token]");

		//Fetches the user id 
		$row_token = $result_token->fetch_array(MYSQLI_ASSOC);
		$user_token = $row_token["token_id"];
		echo $user_token;

		$sql = "INSERT INTO `items`
				(name, status, date_in, expiration_date, user_id)
				VALUES ('$truncate_name', $status, '$date_in', '$expiration_date' , $user_id) 
				ON DUPLICATE KEY 
				UPDATE count = count + 1";

		// Check connection
		if (!mysqli_query($con, $sql)) {
		    $response = array("success" => false, "message" => mysqli_error($con), "sqlerrno" => mysqli_errno($con), "sqlstate" => mysqli_sqlstate($con));
		} else {
		    $response = array("success" => true);

			$certificate = new Certificate(file_get_contents('smif_push_notification.pem'));
			$socketClient = new SocketClient($certificate, 'gateway.sandbox.push.apple.com', 2195);
			$client = new Client($socketClient);
			$sender = new Sender($client);


	
			$sender->send('$result_token', "$truncate_name", "$truncate_name has been added to fridge"  , 'http://deeplink.com');
		}

		echo json_encode($response);
		mysqli_close($con);
	}
?>
