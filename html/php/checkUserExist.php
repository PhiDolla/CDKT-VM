<?php

include 'testRabbitMQClient.php';

$check = accountExistsCheck($_GET['username']);

if(!$check){
        header("location:./homepage.php?check=failed");
        exit(0);
}

elseif($check){
	header("location:./profile.php?username=".$_GET['username']."&profileSearch=Search");
	exit(0);
}

?>
