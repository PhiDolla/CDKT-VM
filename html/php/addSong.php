<!DOCTYPE html>
<html>
<body>

<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');

include('testRabbitMQClient.php');

session_start();

if((isset($_GET['Add']) and isset($_SESSION['username']))){
	echo "Redirect worked.";	
	addSongToProfile($_SESSION['username'], $_GET['Add']);
}

?>

</body>
</html>
