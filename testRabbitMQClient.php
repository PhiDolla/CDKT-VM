#!/usr/bin/php
<?php

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

function login($username, $password){
	$client = new rabbitMQClient("testRabbitMQ.ini","testServer");

	$request = array();

	$request['type'] = "login";
	$request['username'] = strToLower($username);
	$request['password'] = strToLower($password);
	
	$response = $client->send_request($request);
	#$response = $client->publish($request);

	return $response;
}

function registration($username, $password){
	$client = new rabbitMQClient("testRabbitMQ.ini","testServer");
	
	$request = array();
	$request['type'] = "registerAccount";
	$request['registerUsername'] = strtolower($username);
	$request['registerPassword'] = strtolower($password);

	$response = $client->send_request($request);
        #$response = $client->publish($request);

        return $response;
}

/*
if (isset($argv[1])){
	$msg = $argv[1];
}
else{
        $msg = "test message";
}
*/

/*
echo "client received response: ".PHP_EOL;
print_r($response);
echo "\n\n";

echo $argv[0]." END".PHP_EOL;
*/

?>
