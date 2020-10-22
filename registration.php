#!/usr/bin/php
<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');

include('testRabbitMQClient.php');

$regUsername = strtolower($_GET['registerUsername']);
$regPassword = strtolower($_GET['registerPassword']);

$today = date("m/d/Y");
$time = date("h:i:sa");

if($regUsername == '' || $regPassword == '' || $regUsername == null || $regPassword == null){
        echo "Username or Password field left empty, try again.";
        header("location:../index.html?registrationEmpty=blank");

        $logFile = fopen("logs/accountRegistration.log", "a");
        $logText = "[$today | $time] Account registration attempt failed due to null entry.\n";
        
        fwrite($logFile, $logText);
	fclose($logFile);

	exit();
}

$response = registration($regUsername, $regPassword);

if($response == true){
	echo "\nAccount has been created successfully.";
	#  header REFRESH THE LOGIN WITH SUCCESSFUL ACCOUNT CREATION NOTIFICATION.
	
	$logFile = fopen("logs/accountRegistration.log", "a");
        $logText = "[$today | $time] Account registration attempt for User: $regUsername & Password: $regPassword | Registration successful.\n";

        fwrite($logFile, $logText);
        fclose($logFile);
}

elseif($response == false){
	echo "\nAccount already exists.";
        #  header REFRESH THE LOGIN WITH SUCCESSFUL ACCOUNT CREATION NOTIFICATION.

        $logFile = fopen("logs/accountRegistration.log", "a");
        $logText = "[$today | $time] Account registration attempt for User: $regUsername & Password: $regPassword | Failed because username already exists.\n";

        fwrite($logFile, $logText);
        fclose($logFile);

}

?>
