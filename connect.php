<?php
	ini_set('display_errors',1);
        ini_set('display_startup_errors',1);
        error_reporting(E_ALL);

        $dbhost = "smif.ct8vehnhv9o3.us-east-1.rds.amazonaws.com";
        $dbport = "3306";
        $dbname = "SMIF";
        $charset = 'utf8' ;

        $dsn = "mysql:host={$dbhost};port={$dbport};dbname={$dbname};charset={$charset}";
        $username = 'jwt7689';
        $password = 'smiffy_admin';

        $pdo = new PDO($dsn, $username, $password);

?>
