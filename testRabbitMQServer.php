#!/usr/bin/php
<?php

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

global $mydb;


function doLogin($username, $password){
	global $mydb;
	global $today;
	global $time;

	if ($mydb->errno != 0){
                echo "Failed to execute query:".PHP_EOL;
		echo __FILE__.':'.__LINE__.":error: ".$mydb->error.PHP_EOL;

		$logFile = fopen("logs/sql.log", "a");
                $logText = "Exited due to SQL error.\n";

                fwrite($logFile, $logText);
                fclose($logFile);

                exit(0);
        }

	$query = "select password from userCredentials where username='$username';";
	$preResult = $mydb->query($query);
	$result = mysqli_fetch_array($preResult, MYSQLI_ASSOC);
        $finalResult = $result['password'];

	// Check to see if result returned something
	if($preResult->num_rows == 0){
		echo "Null Result\n";

		$logFile = fopen("logs/sql.log", "a");
        	$logText = "SQL select statement for login attempt from User: $username and Password: $password | Unsuccessful because no matching records were retrieved.\n";

        	fwrite($logFile, $logText);
		fclose($logFile);
		
		return false;	
	}

	// Check to see if result is equal to what the user input on webpage
	if($finalResult == $password){
		echo "Successful Result\n";
		
		$logFile = fopen("logs/sql.log", "a");
                $logText = "SQL select statement for login attempt from User: $username and Password $password | Successful because there was a Username/Password match.\n";

                fwrite($logFile, $logText);
		fclose($logFile);

		return true;
	}
	// Return false in all other cases
	else{
		echo "Failed Result\n";
		return false;

		$logFile = fopen("logs/sql.log", "a");
                $logText = "SQL select statement failed for alternate reason.\n";

                fwrite($logFile, $logText);
                fclose($logFile);
	}
}

function doRegistration($username, $password){
	global $mydb;

	$query = "select password from userCredentials where username='$username'";
	$insertQuery = "insert into userCredentials (username, password) values ('$username', '$password')";	
	$preResult = $mydb->query($query);

	if ($mydb->errno != 0){
                echo "Failed to execute query:".PHP_EOL;
                echo __FILE__.':'.__LINE__.":error: ".$mydb->error.PHP_EOL;
		exit(0);

		$logFile = fopen("logs/sql.log", "a");
                $logText = "Exited due to SQL error.\n";

                fwrite($logFile, $logText);
                fclose($logFile);
	}

	if($preResult->num_rows >= 1){
                echo "Account already exists.\n";

		$logFile = fopen("logs/sql.log", "a");
                $logText = "SQL insert for account registration User: $username & Password: $password | Registration failed because account already exists.\n";

                fwrite($logFile, $logText);
                fclose($logFile);
		
		return false;
	}

	else if($preResult->num_rows == 0){
		if(mysqli_query($mydb, $insertQuery)){
			echo "New record created successfully.\n";
		}

		$logFile = fopen("logs/sql.log", "a");
                $logText = "SQL insert for account registration User: $username & Password: $password | Account was successfully registered.\n";

                fwrite($logFile, $logText);
                fclose($logFile);

		return true;
	}
}

function requestProcessor($request){
	echo "Received Request:\n\n";
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
$mydb = new mysqli('localhost','kevin','cdkt','CDKTTechnologies');
#$mydb = new mysqli('192.168.1.59:3306','kevin','cdkt','CDKTTechnologies');
$server = new rabbitMQServer("testRabbitMQ.ini","testServer");
$server->process_requests('requestProcessor');

exit();

?>

