<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
# include('logFunction.php');

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

function songSearch($songId){
	$client = new rabbitMQClient("testRabbitMQ.ini","testServer");

	$request = array();
	$request['type'] = "songSearch";
	$request['songId'] = $songId;

	$response = $client->send_request($request);

	return $response;	
}

function songSearchQuery($song, $album, $artist){
	$client = new rabbitMQClient("testRabbitMQ.ini","testServer");

        $request = array();
        $request['type'] = "songSearchQuery";
	$request['song'] = $song;
	$request['album'] = $album;
	$request['artist'] = $artist;

        $response = $client->send_request($request);

        return $response;
}

function addSongToProfile($username, $trackId){
	$client = new rabbitMQClient("testRabbitMQ.ini","testServer");

        $request = array();
        $request['type'] = "addSong";
        $request['username'] = $username;
        $request['trackId'] = $trackId;

        $response = $client->send_request($request);

        return $response;	
}

function retrieveProfileSongs($username){
	$client = new rabbitMQClient("testRabbitMQ.ini","testServer");

        $request = array();
        $request['type'] = "getProfileSongs";
        $request['username'] = $username;

        $response = $client->send_request($request);

        return $response;
}

function setComments($userProfile, $userCommenting, $date, $comment){
	$client = new rabbitMQClient("testRabbitMQ.ini","testServer");

        $request = array();
        $request['type'] = "setComments";
	$request['userProfile'] = $userProfile;
	$request['userCommenting'] = $userCommenting;
	$request['date'] = $date;
	$request['comment'] = $comment;

        $response = $client->send_request($request);

        return $response;
}

function getComments($userProfile){
	$client = new rabbitMQClient("testRabbitMQ.ini","testServer");

        $request = array();
        $request['type'] = "getComments";
        $request['userProfile'] = $userProfile;

        $response = $client->send_request($request);

        return $response;
}

function getSongDiscovery(){
	$client = new rabbitMQClient("testRabbitMQ.ini","testServer");

        $request = array();
        $request['type'] = "getSongDiscovery";

        $response = $client->send_request($request);

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
