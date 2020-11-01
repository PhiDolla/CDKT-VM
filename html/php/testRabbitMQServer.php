#!/usr/bin/php
<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

global $mydb;

function doLogin($username, $password){
	global $mydb;
	global $today;
	global $time;
	
	$server = new rabbitMQServer("testRabbitMQ.ini","testServer");

	if ($mydb->errno != 0){
                echo "Failed to execute query:".PHP_EOL;
		echo __FILE__.':'.__LINE__.":error: ".$mydb->error.PHP_EOL;

		//$logFile = fopen("logs/sql.log", "a");
                //$logText = "Exited due to SQL error.\n";

                //fwrite($logFile, $logText);
                //fclose($logFile);

                exit(0);
        }

	$query = "select password from userCredentials where username='$username';";
	$preResult = $mydb->query($query);
	$result = mysqli_fetch_array($preResult, MYSQLI_ASSOC);
        $finalResult = $result['password'];

	// Check to see if result returned something
	if($preResult->num_rows == 0){
		echo "Null Result\n";
		return false;	
	}

	// Check to see if result is equal to what the user input on webpage
	if($finalResult == $password){
		echo "Successful Result\n";
		return true;
	}
	// Return false in all other cases
	else{
		echo "Failed Result\n";
		return false;
	}
}

function doRegistration($username, $password){
	global $mydb;

	$server = new rabbitMQServer("testRabbitMQ.ini","testServer");

	$query = "select password from userCredentials where username='$username'";
	$insertQuery = "insert into userCredentials (username, password) values ('$username', '$password')";	
	
	$preResult = $mydb->query($query);

	if ($mydb->errno != 0){
                echo "Failed to execute query:".PHP_EOL;
                echo __FILE__.':'.__LINE__.":error: ".$mydb->error.PHP_EOL;
		exit(0);
	}

	if($preResult->num_rows >= 1){
                echo "Account already exists.\n";
		return false;
	}

	else if($preResult->num_rows == 0){
		if(mysqli_query($mydb, $insertQuery)){
			echo "New record created successfully.\n";
		}
		return true;
	}
}

function retrieveSongs($songId){
	global $mydb;
        $server = new rabbitMQServer("testRabbitMQ.ini", "testServer");
	
	$songInfoArray = array();
		
	$selectQueryTotal = "select * from trackTable";
	$selectQueryTotalResult = $mydb->query($selectQueryTotal);
	$totalRows = $selectQueryTotalResult->num_rows;
	$randNum = rand(1, $totalRows);

	$selectQuery = "select * from trackTable where trackId=$randNum";
        $selectResult = $mydb->query($selectQuery);	
	
	$totalRows++;

	if($selectResult->num_rows > 0){
		while($row = $selectResult->fetch_assoc()){
			array_push($songInfoArray,
				$row['trackId'],
				$row['trackKey'],
				$row['trackName'],
				$row['trackAlbum'],
				$row['trackArtist'],
				$row['trackReleaseDate'],
				$row['trackLengthMilliseconds'],
				$row['trackPopularity']);
		}
	}
	array_push($songInfoArray, $totalRows);
	return $songInfoArray;
}

function retrieveSongsQuery($song, $album, $artist){
	global $mydb;
        $server = new rabbitMQServer("testRabbitMQ.ini", "testServer");	
	$songQueryArray = array();

	if($song == ''){
		$song = '1=1';
	}
	else{
		$song = "trackName='$song'";
	}
	
	if($album == ''){
		$album = '1=1';
	}
	else{
		$album = "trackAlbum='$album'";
	}

	if($artist == ''){
		$artist = '1=1';
	}
	else{
		$artist = "trackArtist='$artist'";
	}

	$selectQuery = "select * from trackTable where $song and $album and $artist";
	echo $selectQuery;
	$selectResult = $mydb->query($selectQuery);
	$totalRows = $selectResult->num_rows;
	$totalRows ++;

	if($selectResult->num_rows > 0){
		while($row = $selectResult->fetch_assoc()){
			$songInfoArray = array($row['trackId'], 
				$row['trackKey'], 
				$row['trackName'], 
				$row['trackAlbum'], 
				$row['trackArtist'], 
				$row['trackReleaseDate'], 
				$row['trackLengthMilliseconds'], 
				$row['trackPopularity'],
				$totalRows);
			# var_dump($songInfoArray);
			array_push($songQueryArray, $songInfoArray);
		}
		return $songQueryArray;
	}	
	
	elseif($selectResult->num_rows == 0){
		return 0;
	}
}

function addSong($username, $trackId){
	global $mydb;
	$server = new rabbitMQServer("testRabbitMQ.ini", "testServer");

	$insertQuery = "insert into profileSongs(trackId, username) values ('$trackId', '$username')";
	
	$selectQuery = "select * from profileSongs where trackId='$trackId' and username='$username'";
	$selectResult = $mydb->query($selectQuery);

	if($selectResult->num_rows == 0){
		echo "Record added to profile.";
		mysqli_query($mydb, $insertQuery);
		return True;
	}
	else{
		echo "Song not added.";
		return False;
	}	
}

function getProfileSongs($username){
	global $mydb;
	$server = new rabbitMQServer("testRabbitMQ.ini", "testServer");
	$songProfileArray = array();

	$songProfileReturnArray = array();	

	$selectQuery = "select * from profileSongs where username='$username'";
	$selectResult = $mydb->query($selectQuery);

	if($selectResult->num_rows > 0){
		while($row = $selectResult->fetch_assoc()){
			array_push($songProfileArray, $row['trackId']);
		}
	}
	elseif($selectResult->num_rows == 0){
		echo "No songs in user account.";
		return False;
	}

	for($i = 0; $i < count($songProfileArray); $i++){	
		$selectQuery2 = "select * from trackTable where trackKey='$songProfileArray[$i]'";
		$selectResult = $mydb->query($selectQuery2);

		while($row = $selectResult->fetch_assoc()){
			$songProfileInfoArray = array
				($row['trackId'],
				$row['trackKey'],
				$row['trackName'],
				$row['trackAlbum'],
				$row['trackArtist'],
				$row['trackReleaseDate'],
				$row['trackLengthMilliseconds'],
				$row['trackPopularity'],
				$row['trackMusicKey'],
				$row['trackMode']);
				array_push($songProfileReturnArray, $songProfileInfoArray);
		}
	}
	return $songProfileReturnArray;
}

function requestProcessor($request){
	echo "Received Request:\n\n";
	var_dump($request);

	if(!isset($request['type'])){
    		return "ERROR: unsupported message type";
	}

  	switch ($request['type']){
    		case "login":
			return doLogin($request['username'], 
			$request['password']);
		case "registerAccount":
			return doRegistration($request['registerUsername'], 
			$request['registerPassword']);
    		case "validate_session":
      			return doValidate($request['sessionId']);	
		case "songSearch":
			return retrieveSongs($request['songId']);
		case "songSearchQuery":
			return retrieveSongsQuery($request['song'],
				$request['album'], $request['artist']);
		case "addSong":
			return addSong($request['username'], $request['trackId']);
		case "getProfileSongs":
			return getProfileSongs($request['username']);	
	}		
	return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

$mydb = new mysqli('localhost','kevin','cdkt','CDKTTechnologies');
$server = new rabbitMQServer("testRabbitMQ.ini", "testServer");
$server->process_requests('requestProcessor');

exit();

?>
