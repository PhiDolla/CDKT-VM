<!DOCTYPE html>
<html>
<body>

<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');

include ('testRabbitMQClient.php');
include ('functionHolder.php');

session_start();

if(!isset($_SESSION['username'])){
	header("location:../loginPage.php");
	exit(0);
}

?>

<h1><u>Welcome to Song Search</u></h1>
<h3>Below is a limited list of songs within our database. <br> 
Feel free to use the provided search queries to find a song you are looking for.</h3>

<form action="./songSearcher.php">
        <input type="text" placeholder="Song" name="song"><br>
        <input type="text" placeholder="Album" name="album"><br>
        <input type="text" placeholder="Artist" name="artist"><br><br>

	<input type="submit" value="Search" name="searchQuery"><br><br>
</form>

<form action="./songSearcher.php">
	<input type="submit" value="Random Results" name="random"><br><br>
</form>

<?php

if(isset($_GET['Add'])){
	$songAdded = addSongToProfile($_SESSION['username'], $_GET['Add']);
	
	if($songAdded){
		echo "<b>Song has been successfully added to your profile.</b><br><br>";
}
	else{
		echo "<b>Song not added because it is already added to your profile.</b><br><br>";
	}
}

?>

<table border='2'>

<tr>

<th>Song</th>
<th>Album</th>
<th>Artist</th>
<th>Release Date</th>
<th>Song Length</th>
<th>Popularity</th>
<th>Add Song to Profile</th>

</tr>

<?php

if(isset($_GET['searchQuery'])){
	$querySong = strtolower($_GET['song']);
	$queryArtist = strtolower($_GET['artist']);
	$queryAlbum = strtolower($_GET['album']);

	$songTotal = 2;
        for($songId = 0; $songId<$songTotal-1; $songId++){
		$test = songSearchQuery($querySong, $queryAlbum, $queryArtist);
		if($test == 0){
			echo "No results found, please try again.<br><br>";
		}
		elseif(((empty($_GET['song'])) && (empty($_GET['artist'])) && (empty($_GET['album'])))){
			echo "<b>Too many search fields left empty, please try again.</b><br><br>";
		}
		else{
		$songTotal = $test[$songId][8];
                ?>

		<tr>
		<td> <?php echo $test[$songId][2];?> </td>
                <td> <?php echo $test[$songId][3];?> </td>
                <td> <?php echo $test[$songId][4];?> </td>
                <td> <?php echo $test[$songId][5];?> </td>
                <td> <?php echo milliConversion($test[$songId][6]);?> </td>
                <td> <?php echo $test[$songId][7];?> </td>
		<td><form action="./songSearcher.php">
                <input type="submit" name=<?php echo $test[$songId][1]; ?> value="Add">
                <input type="hidden" name="Add" value=<?php echo $test[$songId][1];?>>
                </form></td>	
		</tr>
		<?php
		}
	}	
}

elseif((!isset($_GET['searchQuery']) && isset($_SESSION['username']))){
	$songTotal = 2;
	for($songId = 1; $songId<$songTotal; $songId++){
		$test = songSearch($songId);
		$songTotal = end($test);
		?>

		<tr>
		<!-- <td> <?php echo $test[0]; ?> </td> -->
		<!-- <td> <?php echo $test[1]; ?> </td> -->
		<td> <?php echo $test[2]; ?> </td>
        	<td> <?php echo $test[3]; ?> </td>
		<td> <?php echo $test[4]; ?> </td>
		<td> <?php echo $test[5]; ?> </td>
		<td> <?php echo milliConversion($test[6]); ?> </td>
        	<td> <?php echo $test[7]; ?> </td>
		<td><form action=./songSearcher.php>
		<input type="submit" name=<?php echo $test[1]; ?> value="Add">
		<input type="hidden" name="Add" value=<?php echo $test[1];?>>
		</form></td>
		</tr>
 		
		<?php
		if($songId == 25){
			break;
		}
	}
}
?>

</table>

<?php
echo '<br>';
echo '<a href="homepage.php">Homepage Directory</a><br><br>';
echo '<a href="profile.php">Your Profile</a><br>';
echo '<a href="songDiscovery.php">Song Discovery</a><br>';
echo '<br><a href="logout.php?logout">Logout</a><br>';
?>


</body>
</html>

