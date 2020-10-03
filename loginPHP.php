<?php

include("config.php");

session_set_cookie_params(0, $path);
session_start();

$sidvalue = session_id();

error_reporting(E_ERROR | E_PARSE | E_NOTICE);
ini_set('display_errors', 1);

include("account.php");
$db = mysqli_connect($hostname, $username, $password, $project);

if(mysqli_connect_errno()){
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}

print "Successfully connected to MySQL.<br><br>";
mysqli_select_db($db, $project);
include("AssignmentTwoFunctions.php");

$dataOK = true;

$ucid = get("ucid", $dataOK);
$pass = get("password", $dataOK);
$guess = get("guess", $dataOK);
$delay = get("delay", $dataOK);

$captcha = $_SESSION["captcha"];

if($guess != $captcha){
    echo "<br><b>Bad captcha guess. Redirecting to Login Page.</b><br>";
    header("Refresh: $delay; url = loginHTML.html");
    exit();
}

$hash = password_hash($pass, PASSWORD_DEFAULT);
echo "<br>Hash is: $hash";

if(!authenticate($ucid, $pass, $hash)){
    echo "<br><br><b>Bad credentials. Redirecting to Login Page.</b><br>";
    header("Refresh: $delay; url = loginHTML.html");
    exit();
}

$_SESSION["logged"] = true;
$_SESSION["ucid"] = $ucid;

echo "<br><br><b>Being redirected to protected services page.</b><br>";
header("Refresh: $delay; url = protectOne.php");
exit();

?>