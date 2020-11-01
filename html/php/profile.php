<!DOCTYPE html>
<html>
<body>

<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');

include('testRabbitMQClient.php');
include ('functionHolder.php');

session_start();

if(!isset($_SESSION['username'])){
	header("location:../loginPage.php");
}

if((isset($_SESSION['username']) and (!isset($_GET['profileSearch']))) or ($_SESSION['username'] == $_GET['username'])){
	?><h1>Welcome to your profile page!</h1><?php
	echo "<h3>Below is a table of your liked songs, if you have any.</h3>";
	$outputArray = retrieveProfileSongs($_SESSION['username']);
	?>

	<table border=2>
	
	<tr>
        <th>Song</th>
        <th>Album</th>
        <th>Artist</th>
        <th>Release Date</th>
        <th>Song Length</th>
        <th>Popularity</th>
        <th>Mode/Scale</th>
        <th>Key</th>
        </tr> 
	
	<?php
	for($i = 0; $i < count($outputArray); $i++){
		?>

		<tr>
		<td> <?php echo $outputArray[$i][2];?> </td>
                <td> <?php echo $outputArray[$i][3];?> </td>
                <td> <?php echo $outputArray[$i][4];?> </td>
		<td> <?php echo $outputArray[$i][5];?> </td>
		<td> <?php echo milliConversion($outputArray[$i][6]);?> </td>
		<td> <?php echo $outputArray[$i][7];?> </td>
		<td> <?php echo convertMode($outputArray[$i][8]);?> </td>
		<td> <?php echo convertKey($outputArray[$i][9]);?> </td>
		</tr>
		<?php
	}
	?></table><?php

	

}

elseif(isset($_GET['profileSearch'])){
	$userProfile = $_GET['username'];
	?><h1>Welcome to <?php echo $_GET['username'];?>'s profile page!</h1>
	<?php
	echo "<h3>Below is a table of $userProfile's liked songs, if they have any.</h3>";
	$outputArray = retrieveProfileSongs($_GET['username']);
        ?>

        <table border=2>
        <tr>
        <th>Song</th>
        <th>Album</th>
        <th>Artist</th>
        <th>Release Date</th>
	<th>Song Length</th>
        <th>Popularity</th>
        <th>Mode/Scale</th>
        <th>Key</th>
        </tr>

        <?php
        for($i = 0; $i < count($outputArray); $i++){
                ?>

                <tr>
                <td> <?php echo $outputArray[$i][2];?> </td>
                <td> <?php echo $outputArray[$i][3];?> </td>
                <td> <?php echo $outputArray[$i][4];?> </td>
                <td> <?php echo $outputArray[$i][5];?> </td>
                <td> <?php echo milliConversion($outputArray[$i][6]);?> </td>
                <td> <?php echo $outputArray[$i][7];?> </td>
                <td> <?php echo convertMode($outputArray[$i][8]);?> </td>
                <td> <?php echo convertKey($outputArray[$i][9]);?> </td>
                </tr>
                <?php
        }
        ?></table><?php
}
?>
	
	<?php	
	echo '<br><br><a href="homepage.php">Homepage Directory</a><br><br>';
        echo '<a href="songDiscovery.php">Song Discovery</a><br>';
        echo '<a href="songSearcher.php">Song Search</a><br>';
        echo '<br><a href="logout.php?logout">Logout</a><br>';
	?>

</body>
</html>
