<?php
	
	require 'connect.php';

	session_start();
	header('Content-Type: application/json');
	
	if(isset($_SESSION["username"]) && isset($_SESSION["password"]) && !empty($_SESSION["username"]) && !empty($_SESSION["password"])){
		$current_username = $_SESSION["username"];
		$current_password = $_SESSION["password"];
	}
	else{
		$current_username = "Jennifer";
		$current_password = "1234";
		echo "Dummy Variable Used \n Username: Jennifer \n Password: 1234";
	}

	//Getting the user_id 
	//$query_id = "SELECT id FROM user WHERE username='$current_username'";
	//$result_id = $pdo->query($query_id);

	$query_id = $pdo->prepare("SELECT id FROM user WHERE username='$current_username'");
	$query_id->execute();

	/* associative array */
	//Fetches the user id 
	$row_id = $query_id->fetch(PDO::FETCH_ASSOC);
	$user_id = $row_id["id"];


	//Fetches the user id 
	$sql = $pdo->prepare("SELECT * FROM items where user_id='$user_id'");
	$sql->execute();
	
	//Check if there are results
	if($sql->rowCount() > 0){
	    $resultArray = array();
	    $tempArray = array();
            
            //Loop through each row in the result set
            while($row = $sql->fetchObject()){
	    	//Add each row into our results array
  		$tempArray = $row;
                array_push($resultArray, $tempArray);
	    }
	    //Finally, encode the array to JSON and output the results
	    echo json_encode($resultArray);		
	}
	else{
		echo 'nothing';
	}

?>
