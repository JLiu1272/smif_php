<?php

	ini_set('display_errors',1);
	ini_set('display_startup_errors',1);
	error_reporting(E_ALL);

	// open database
	$con = mysqli_connect("107.23.213.161","jwt7689","smiffy_admin","SMIF");
	$mysqli = new mysqli("107.23.213.161","jwt7689", "smiffy_admin", "SMIF");

	// Check connection
	if ($mysqli->connect_errno)
	{
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	  exit();
	} 

?>