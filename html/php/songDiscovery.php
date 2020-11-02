<?php
include 'testRabbitMQClient.php';
?>

<!DOCTYPE html>
<html>
<body>

<center>

<h1><u>Welcome to Song Discovery</u></h1>

<?php

$songDiscoveryInfo = getSongDiscovery();
$len = count($songDiscoveryInfo);

for($i=0; $i<$len; $i++){ ?>
	
	<iframe src="<?php echo $songDiscoveryInfo[$i][3]?>" frameborder="0" height="85" width="175" title="Test Page"></iframe><br>

<?php
	
	echo "Song - ";
	echo $songDiscoveryInfo[$i][0];
	echo "<br>";
	echo "Album - ";
	echo $songDiscoveryInfo[$i][1];
	echo "<br>";
	echo "Artist - ";
	echo $songDiscoveryInfo[$i][2];
	echo "<br><br>";
}

?>

<form action="./songDiscovery.php">
<input type="submit" value="Get New Songs" name="profileSearch"</input>
</form>

<?php

echo '<br><a href="homepage.php">Homepage Directory</a><br><br>';
echo '<a href="profile.php">Your Profile</a><br>';
echo '<a href="songSearcher.php">Song Search</a><br>';
echo '<br><a href="logout.php?logout">Logout</a><br>';

?>

</center>
</body>
</html>

