<!DOCTYPE html>
<html>
<body>

<h1>Welcome to the homepage!</h1>

<?php

session_start();

if(isset($_SESSION['username'])){
	echo "Hello " . $_SESSION['username'] . ", where would you like to go?<br><br>";?>
	<form action="./profile.php">
    	Find Profile Page by Username: <input type="text" placeholder="Username" name="username"> 
	<input type="submit" value="Search" name="profileSearch"<br>
	</form>
	<?php
	echo '<br><a href="profile.php">Your Profile</a><br><br>';
	echo '<a href="songDiscovery.php">Song Discovery</a><br>';
	echo '<a href="songSearcher.php">Song Search</a><br>';
	echo '<br><a href="logout.php?logout">Logout</a><br>';
}
else{
	header("location:../loginPage.php");
}

?>

</body>
</html>
