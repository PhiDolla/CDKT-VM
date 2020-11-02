<!DOCTYPE html>
<html lang="en">

<body>

<center>

<head>
	<title>Login Page</title>
	<meta charset="UTF-8">
</head>

<?php
if($_GET['registration'] == "successful"){
?>

<div> <?php echo "Your account has been created successfuly, feel free to login." ?> </div>

<?php
}
?>

<?php
if($_GET['login'] == "blank"){	
?>

<div> <?php echo "Login field(s) left blank, please try again." ?> </div>

<?php
}
?>

<?php
if($_GET['login'] == "failed"){
?>

<div> <?php echo "Incorrect login credentials were used. Please try again" ?> </div>

<?php
}
?>

<form action="./php/login.php">
    <h3><u>Login</u></h3>

    <input type="text" placeholder="Username" name="username"><br>
    <input type="password" placeholder="Password" name="password"><br><br>

    <input type="submit" value="Login" name="login"><br>
</form>

    <h2>- OR -</h2>

<?php
if($_GET['registration'] == "blank"){
?>

<div> <?php echo "Registration field(s) left blank, please try again." ?> </div>

<?php
}
?>

<?php
if($_GET['registration'] == "failed"){
?>

<div> <?php echo "Account could not be created because username already exists. Please try again with a different username." ?> </div>

<?php
}
?>

<form action="./php/registration.php">

    <h3><u>Register Non-Existing User Account</u></h3>

    <input type="text" placeholder="New Username" name="registerUsername"><br>
    <input type="password" placeholder="New Password" name="registerPassword"><br><br>

    <input type="submit" value="Register Account" name="registerAccount"><br>

</form>

</center>

</body>
</html>


