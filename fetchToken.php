<?php
   
   require 'connect.php';
   session_start();
   header('Content-Type: application/json');

   $query_id = $pdo->prepare("INSERT INTO TOKEN (token_id) VALUES ('3321')");
   $query_id->execute();
   echo "Hello";

   if($_SERVER['REQUEST_METHOD'] === 'POST'){
   	$token = $_POST["token"];
   	$query_id = $pdo->prepare("INSERT INTO TOKEN (token_id) VALUES ('$token')");
   	$query_id->execute();
   	echo $token;
   }

?>
