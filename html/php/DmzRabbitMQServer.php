#!/usr/bin/php
<?php
 
error_reporting(E_ALL);
ini_set('display_errors', 'On');

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
  
global $mydb;

function collectSpotifyTracks($songKey, $name, $album, $artist, $releaseDate, $length, $popularity, $danceability, $energy, $key, $mode, $demoLink){ 
         $server = new rabbitMQServer("testRabbitMQ.ini","dmzServer");
 
         global $mydb;
	 
	 $selectQuery = "select * from trackTable where trackKey='$songKey'";
	 $selectQueryResult = $mydb->query($selectQuery);

         $insertQuery = "insert into trackTable(trackKey, trackName, trackAlbum, trackArtist, trackReleaseDate, trackLengthMilliseconds, trackPopularity, trackDanceability, trackEnergy, trackMusicKey, trackMode, trackDemoLink) values ('$songKey', '$name', '$album', '$artist', '$releaseDate', '$length', '$popularity', '$danceability', '$energy', '$key', '$mode', '$demoLink')";
 
         if($selectQueryResult->num_rows == 0 && (mysqli_query($mydb, $insertQuery))){
                echo "Spotify track $name by $artist has been added to database.";
                return "Song added.";
	} 
        else{
		echo("Error description: " . mysqli_error($mydb));	
		echo "Song was not added because of error (if specified) or because song is already in database.";
		return "Song not added.";
        }
}

function requestProcessor($request){
        echo "Received Request:\n\n";
        var_dump($request);

        if(!isset($request['type'])){
                return "ERROR: unsupported message type";
        }

        switch ($request['type']){
		case "spotifyTracks":
                        return collectSpotifyTracks($request['songKey'],
                        $request['name'], $request['album'],
                        $request['artist'], $request['releaseDate'],
                        $request['length'], $request['popularity'],
                        $request['danceability'], $request['energy'],
                        $request['key'], $request['mode'],
			$request['demoLink']);
	}
	return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

$mydb = new mysqli('localhost','kevin','cdkt','CDKTTechnologies');
$server = new rabbitMQServer("testRabbitMQ.ini","dmzServer");
$server->process_requests('requestProcessor');

exit();

