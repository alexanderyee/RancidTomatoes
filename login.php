<!DOCTYPE html>
<!--
	Name: Alex Yee, Bijan Anjavi
  Course: CSC 337
  TA(s): Hasanain Jamal
  Description: Log in page for existing users for Rancid Tomatoes Enhanced
-->
<html>
<head>
	<title>Rancid Tomatoes Enhanced | Login</title>
	<meta charset="utf-8" />
	<link href="main.css" rel="stylesheet" type="text/css">
</head>
<body>
	<div id="overallContent">
		<div id="banner">
			<a  href="index.php"><img src="images/rancidbanner.png" alt="Rancid Tomatoes"></a>
		</div>
		<h1>Login</h1>
    <form id="loginForm" action="controller.php" method="post"> <!--MIGHT NEED TO CHANGE THE ACTION, STILL FIGURING OUT CONTROLLER AND LOGIN-->
    Username &nbsp;<input type="text" id="loginUsername" name="loginUsername" placeholder="Enter username here" required> <br><br>
    Password &nbsp;<input type="password" id="loginPassword" name="loginPassword" placeholder="Enter password here" required> <br><br>
    <input type="submit" id="loginButton" name="loginButton" value="Login">
		<?php
					session_start ();
		      echo $_SESSION ['loginError']; // session needs a login error message
		?>
    </form>
	</div>
</body>
</html>
