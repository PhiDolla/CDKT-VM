<?php
include 'testRabbitMQClient.php';
session_start();

$userCommenting = $_SESSION['username'];
$userProfile = $_GET['userProfile'];
$date = $_GET['date'];
$message = $_GET['message'];

if(empty($message)){
	header('location:./profile.php');
	exit(0);
}

setComments($userProfile, $userCommenting, $date, $message);

header('location:./profile.php');
?>
