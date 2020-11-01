#!/usr/bin/php
<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');

session_start();
include('testRabbitMQClient.php');

$username = strtolower($_GET['username']);
$password = strtolower($_GET['password']);

if($username == '' || $password == '' || $username == null || $password == null){
	header("location:../loginPage.php?login=blank");
	exit();
}

$loginResponse = login($username, $password);

if($loginResponse == true){
	$_SESSION['username'] = $username;
	header("location:./homepage.php");
}

elseif($loginResponse == false){
	header("location:../loginPage.php?login=failed");
}

?>
