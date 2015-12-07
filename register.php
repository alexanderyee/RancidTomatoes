<!DOCTYPE html>
<!--
	Name: Alex Yee, Bijan Anjavi
  Course: CSC 337
  TA(s): Hasanain Jamal
  Description: Allows new user to register for Rancid Tomatoes Enhance
-->
<html>
<head>
	<title>Rancid Tomatoes Enhanced | Register</title>
	<meta charset="utf-8" />
	<link href="main.css" rel="stylesheet" type="text/css">
</head>
<body>
	<div id="overallContent">
		<div id="banner">
			<a  href="index.php"><img src="images/rancidbanner.png" alt="Rancid Tomatoes"></a>
		</div>
		<h1>Register</h1>
    <form id="registerForm" action="controller.php" method="post"> <!--MIGHT NEED TO CHANGE THE ACTION, STILL FIGURING OUT CONTROLLER AND LOGIN-->
    Username &nbsp<input type="text" id="registerUsername" name="registerUsername" pattern="[a-zA-Z0-9-]+" required > <br><br>
    Password &nbsp<input type="password" id="registerPassword" name="registerPassword" pattern="[a-zA-Z0-9-]+"  minlength=8 required > <br><br>
    First Name &nbsp<input type="text" id="registerFirstName" name="registerFirstName" required > <br><br>
    Last Name &nbsp<input type="text" id="registerLastName" name="registerLastName"  required > <br><br>
    Publication &nbsp<input type="text" id="registerPublication" name="registerPublication"  required > <br><br>
    <input type="submit" id="registerButton" name="registerButton" value="Register">
    <?php
		      session_start ();
		      echo $_SESSION ['registrationError'];
		?>
    </form>
	</div>
</body>
</html>
