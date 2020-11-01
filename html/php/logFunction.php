<?php

# error_reporting(E_ALL);
# ini_set('display_errors', 1);
# ini_set('display_startup_errors', 1)

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

//Error logging system.

function logErrors($error_level, $error_message, $filename, $line_number){
  	date_default_timezone_set('America/New_York');
	$time = date("M/d/Y | h:i:sa");
	$file  = "[$time] $error_level: $error_message in $filename at line $line_number. \n";

 	$client = new rabbitMQClient("testRabbitMQ.ini", "logServer");
	
	$request = array();
	$request['type'] = "log-error";
  	$request['message'] = $file;
  
	$response = $client->send_request($request);
	#$response = $client->publish($request);
	
	return $response;
}

set_error_handler("logErrors");

/*
 
# Login function.
function LogLogin($log){
 	date_default_timezone_set('America/New_York');
	$time = date("M/d/Y | h:i:sa");
  	$file  = "[$time]  $log ";

  	$client = new rabbitMQClient("testRabbitMQ.ini","logServer");
	$request = array();
	$request['type'] = "log-login";
  	$request['message'] = $file;
  
	$response = $client->send_request($request);
	#$response = $client->publish($request);
  	return $response;
}

//registration loggin system.
function LogRegister($log){
  	date_default_timezone_set('America/New_York');
	$time = date("M/d/Y | h:i:sa");
  	$file  = "[$time]  $log ";
  
  	$client = new rabbitMQClient("testRabbitMQ.ini","logServer");
	$request = array();
	$request['type'] = "log-register";
  	$request['message'] = $file;
  
	$response = $client->send_request($request);
	#$response = $client->publish($request);
  	return $response; 
}

//SQL logging system.
function logSQL($log){
  date_default_timezone_set('America/New_York');
	$time = date("M/d/Y | h:i:sa");
  $file  = "[$time]  $log ";
  
  $client = new rabbitMQClient("testRabbitMQ.ini","logServer");
	$request = array();
	$request['type'] = "log-SQL";
  	$request['message'] = $file;

	$response = $client->send_request($request);
	#$response = $client->publish($request);
  return $response; 
}

*/

?>
