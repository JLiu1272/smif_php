<?php

// specify that this will return JSON

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



$query = "SELECT username, password FROM user WHERE username='$username'";
$result = $mysqli->query($query);

/* associative array */
$row = $result->fetch_array(MYSQLI_ASSOC);
$hash = $row["password"];

if(password_verify($password,$hash)){
	echo 'Password is valid!';
}
else{
	echo 'Invalid Password';
}

//echo $row["username"] . $row["password"];




/*$username = mysqli_real_escape_string($con, $_POST["username"]);
$password = mysqli_real_escape_string($con, $_POST["password"]);

$hashPwd = password_verify($password, )
 
// This SQL statement selects ALL from the table 'Locations'
$sql = "SELECT username, password FROM deep_freeze WHERE username='$username'";
$result =  



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
		$tempArray = $row; array_push($resultArray, $tempArray);
	}
 
	// Finally, encode the array to JSON and output the results
	echo json_encode($resultArray);
}*/
 
// Close connections
mysqli_close($con);
?>