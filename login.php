#!/usr/bin/php
<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');

session_start();
include('testRabbitMQClient.php');

$username = strtolower($_GET['username']);
$password = strtolower($_GET['password']);

$today = date("m/d/Y");
$time = date("h:i:sa");


if($username == '' || $password == '' || $username == null || $password == null){
	echo "\nUsername or Password field left empty, refresh page and notify.";
	header("location:../index.html?loginEmpty=blank");

	$logFile = fopen("logs/login.log", "a");
	$logText = "Login attempt failed due to null entry.\n";
	
	fwrite($logFile, $logText);
	fclose($logFile);

	exit();
}

$response = login($username, $password);

if($response == true){
	$_SESSION['username'] = $username;
	# header REDIRECT TO HOMEPAGE

	$logFile = fopen("logs/login.log", "a");
	$logText = "[$today | $time] Login attempt from User: $username | Login Successful.\n";

	fwrite($logFile, $logText);
	fclose($logFile);
}

elseif($response == false){
	echo "\nLogin Failed. Username & Password Combination Does Not Exist.";
	# header REDIRECT TO FAILED LOGIN PAGE

	$logFile = fopen("logs/login.log", "a");
	$logText = "[$today | $time] Login attempt from User: $username | Failed due to incorrect credentials.\n";

	fwrite($logFile, $logText);
	fclose($logFile);
}

?>
