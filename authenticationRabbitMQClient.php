#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

$client = new rabbitMQClient("testRabbitMQ.ini","testServer");
if (isset($argv[1]))
{
  $msg = $argv[1];
}
else
{
  $msg = "test message";
}

$request = array();
$request['type'] = "registerAccount";
$request['registerUsername'] = $_GET["registerUsername"];
$request['registerPassword'] = $_GET["registerPassword"];
$request['message'] = $msg;
$response = $client->send_request($request);
//$response = $client->publish($request);

if($response == true){
	header("Location: ./accountRegisteredPage.html");
	echo("Success. Account created.<br>");
}
else{
	header("Location: ../index.html");
	echo("Failed. Account not created.<br>");
}

echo "client received response: ".PHP_EOL;
print_r($response);
echo "\n\n";

echo $argv[0]." END".PHP_EOL;

