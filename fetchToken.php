<?php
   
   require 'connect.php';
   session_start();
   header('Content-Type: application/json');

   echo "Hello";

   $username = "Christine";
   $password = "1234";
   $token = "2341";

   $query = "SELECT id, username, password FROM user WHERE username='$username'";
   $result = $pdo->prepare($query);
   $result->execute();

   //associative array
   $row = $result->fetch(PDO::FETCH_ASSOC);
   $hash = $row["password"];
   $user_id = $row["id"];
   echo $user_id;

   if(password_verify($password,$hash)){
      $query_id = $pdo->prepare("INSERT INTO user (token, id) 
         VALUES ('$token', '$user_id')"); 
      $query_id->execute();
      echo $token;
   }
   else{
      echo "invalid";
   }
     

   if($_SERVER['REQUEST_METHOD'] === 'POST'){
   	$token = $_POST["token"];
      $username = $_POST["username"];
      $pw = $_POST["pw"];

      $query = "SELECT id, username, password FROM user WHERE username='$username'";
      $result = $pdo->prepare($query);
      $result->execute();

      /* associative array */
      $row = $result->fetch(PDO::FETCH_ASSOC);
      $hash = $row["password"];
      $user_id = $row["id"];

      if(password_verify($password,$hash)){
         $query_id = $pdo->prepare("INSERT INTO user (token, id) 
            VALUES ('$token', '$user_id')"); 
         $query_id->execute();
         echo $token;
      }
      else{
         echo "invalid";
      }
   }

?>
