#!/user/bin/php
<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors,' 1);

function logErrors($error_level, $error_message, $filename, $line_number){
	$today = date("m/d/Y");
	$time = date("h:i:sa");
	$myfile = "logs";

	$file  = "[$today | $time] Error: $error_level in $filename at line $line_number. \n";

file_put_contents("log/$myfile.log", $file, FILE_APPEND);

}

set_error_handler("logErrors");

?>

