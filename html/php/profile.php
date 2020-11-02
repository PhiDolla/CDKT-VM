<!DOCTYPE html>
<html>
<body>

<?php

date_default_timezone_set('America/New_York');
error_reporting(E_ALL);
ini_set('display_errors', 'On');

include('testRabbitMQClient.php');
include('functionHolder.php');

session_start();

if(!isset($_SESSION['username'])){
	header("location:../loginPage.php");
}

if((isset($_SESSION['username']) and (!isset($_GET['profileSearch']))) or ($_SESSION['username'] == $_GET['username'])){
	?><h1><u>Welcome to Your Profile Page</u></h1><?php
	echo "<h3><u>Your playlist</u></h3>";
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
	?></table>

	<h3><u>Recommended Songs</u></h3>




	<h3><u>Comment Section</u></h3>
		
	<?php
	$comments = getComments($_SESSION['username']);
		
	for($i = 0; $i < count($comments); $i++){
		echo $comments[$i][0];
		echo "<br>";
		echo $comments[$i][1];
		echo "<br>";
		?><b><?php echo $comments[$i][2]; ?></b><?php
		echo "<br><br>";
	}	

	?>

	<form action='./personalComments.php'>
		<input type='hidden' name='userProfile' value='<?php echo $_SESSION['username']?>'>
		<input type='hidden' name='date' value='<?php echo date('Y-m-d  H:i:s')?>'>
		<textarea name='message' rows='5' cols='50'></textarea>
		<br><button type='submit' name='commentSubmit'>Comment</button>
	</form>

	<?php
}

elseif(isset($_GET['profileSearch'])){
	$userProfile = $_GET['username'];
	?><h1><u>Welcome to <?php echo $_GET['username'];?>'s Profile Page</u></h1>
	<?php
	echo "<h3>Below is a table of $userProfile's playlist.</h3>";
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
	
	?></table>

	<h3><u>Comment Section</u></h3>

	<?php
        $comments = getComments($_GET['username']);
	
        for($i = 0; $i < count($comments); $i++){
		echo $comments[$i][0];
		echo "<br>";
                echo $comments[$i][1];
		echo "<br>";
		?><b><?php echo $comments[$i][2]; ?></b><?php
		echo "<br><br>";
        }

        ?>

	<form action='./publicComments.php'>
                <input type='hidden' name='userProfile' value='<?php echo $_GET['username']?>'>
		<input type='hidden' name='date' value='<?php echo date('Y-m-d H:i:s')?>'>
		<input type='hidden' name='username' value='username'>
                <textarea name='message' rows='5' cols='50'></textarea>
                <br><button type='submit' name='commentSubmit'>Comment</button>
        </form>
<?php
}
	
echo '<br><br><a href="homepage.php">Homepage Directory</a><br><br>';
echo '<a href="songDiscovery.php">Song Discovery</a><br>';
echo '<a href="songSearcher.php">Song Search</a><br>';
echo '<br><a href="logout.php?logout">Logout</a><br>';

?>
</body>
</html>
