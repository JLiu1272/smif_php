<?php
	ini_set('display_errors',1);
        ini_set('display_startup_errors',1);
        error_reporting(E_ALL);
 
        $dbhost = "smif.ct8vehnhv9o3.us-east-1.rds.amazonaws.com";
        $dbport = "3306";
        $dbname = "SMIF";
        $charset = 'utf8' ;
 
        $dsn = "mysql:host={$dbhost};port={$dbport};dbname={$dbname};charset={$charset}";
        $usernamep = 'jwt7689';
        $passwordp = 'smiffy_admin';

// specify that this will return JSON
//Creating Session so that I know who is logged in 
session_start();

header('Content-type: application/json');

// get the parameters
//$username = "Christine";
//$password = "1234";

$username = $_POST["username"];
$password = $_POST["password"];

//Session 
//This ensures that this information is accessible throughout
//the application
$_SESSION["username"] = $username;
$_SESSION["password"] = $password;

// perform the insert
//Hash password 
$hashPwd = password_hash($password, PASSWORD_DEFAULT);

try{
   $pdo = new PDO($dsn, $usernamep, $passwordp);
   $sql = "INSERT INTO user (username, password) VALUES ('{$username}', '{$hashPwd}')";
   $result = $pdo -> prepare($sql);
   $result->execute();
  
   //Check whether user being registered
   //has already been registered
   if($error == 0000){
	echo "Success";
   }	
   else{
	echo "duplicate";
   }
} catch (Exception $e){
   echo $e;
}
?>
