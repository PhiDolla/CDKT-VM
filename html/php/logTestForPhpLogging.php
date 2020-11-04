#!/usr/bin/php
<?php

include('testRabbitMQClient.php');

echo $a;

logErrors(error_get_last()["type"], error_get_last()["message"], error_get_last()["file"], error_get_last()["line"]);

?>
