<!DOCTYPE html>
<html>
<body>

<center>

<h1><u>Welcome to the Homepage</u></h1>

<?php

session_start();

if(isset($_SESSION['username'])){
	echo "Hello " . $_SESSION['username'] . ", where would you like to go?<br><br>";

	?>

	<form action="./checkUserExist.php">
    	Find Profile Page by Username: <input type="text" placeholder="Username" name="username"> 
	<input type="submit" value="Search" name="profileSearch"<br>
	</form>
<?php

	if(isset($_GET['check'])){
		echo "<br><b>Username does not exist. Please try again.</b><br>";
	}

	echo '<br><a href="profile.php">Your Profile</a> | ';
	echo '<a href="songDiscovery.php">Song Discovery</a> | ';
	echo '<a href="songSearcher.php">Song Search</a>';
	echo '<br><br><a href="logout.php?logout">Logout</a><br>';
}
else{
	header("location:../loginPage.php");
}

?>

</center>

</body>
</html>
