<?php

require 'vendor/autoload.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use JWage\APNS\Certificate;
use JWage\APNS\Client;
use JWage\APNS\Sender;
use JWage\APNS\SocketClient;

$certificate = new Certificate(file_get_contents('/Users/JenniferLiu/Desktop/smif_final/apple_push_notification_production.pem'));
$socketClient = new SocketClient($certificate, 'gateway.sandbox.push.apple.com', 2195);
$client = new Client($socketClient);
$sender = new Sender($client);

$sender->send('51ba8b4b36e68cd747890cc39c2d61f80eb8436255acc55a1ca14f474963c2bc', 'Title of push', 'Body of push', 'http://deeplink.com');
