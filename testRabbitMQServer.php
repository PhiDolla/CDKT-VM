#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

global $mydb;

function doLogin($username, $password){
	
	global $mydb;

	$query = "select password from userCredentials where username = '$username';";

	// Lookup username is database.
	$preResult = $mydb->query($query);
	# $result = mysqli_fetch_array($preResult);	

	// If there is an SQL io error, exit
	if ($mydb->errno != 0){	
        	echo "failed to execute query:".PHP_EOL;
        	echo __FILE__.':'.__LINE__.":error: ".$mydb->error.PHP_EOL;
        	exit(0);
	}

	// Check to see if result returned something
	if($preResult->num_rows == 0){
		echo "Null Result";
		return false;	
	}

	$result = mysqli_fetch_array($preResult, MYSQLI_ASSOC);
	$finalResult = $result['password'];

	// Check to see if result is equal to what the user input on webpage
	if($finalResult == $password){
		echo "Successful Result";
		return true;
	}
	// Return false in all other cases
	else{
		echo "Failed Result";
		return false;
	}
}

function doRegistration($username, $password){
	
	global $mydb;

	$query = "select password from userCredentials where username='$username'";
	$insertQuery = "insert into userCredentials (username, password) values ('$username', '$password')";	
	$preResult = $mydb->query($query);

	if ($mydb->errno != 0){
                echo "failed to execute query:".PHP_EOL;
                echo __FILE__.':'.__LINE__.":error: ".$mydb->error.PHP_EOL;
                exit(0);
	}

	if($preResult->num_rows >= 1){
                echo "Account already exists.";
                return false;
	}
	else if($preResult->num_rows == 0){
		if(mysqli_query($mydb, $insertQuery)){
			echo "New record created successfully.";
		}
		return true;
	}
}

function requestProcessor($request){
	echo "received request".PHP_EOL;
	var_dump($request);

	if(!isset($request['type'])){
    		return "ERROR: unsupported message type";
	}

  	switch ($request['type']){
    		case "login":
			return doLogin($request['username'],$request['password']);
		case "registerAccount":
			return doRegistration($request['registerUsername'],$request['registerPassword']);
    		case "validate_session":
      			return doValidate($request['sessionId']);
  	}
  return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

#$mydb = new mysqli('25.3.221.199:3306','kevin','cdkt','CDKTTechnologies');
$mydb = new mysqli('127.0.0.1:3306','kevin','cdkt','CDKTTechnologies');
#$mydb = new mysqli('192.168.1.59:3306','kevin','cdkt','CDKTTechnologies');
$server = new rabbitMQServer("testRabbitMQ.ini","testServer");
$server->process_requests('requestProcessor');

exit();

?>

