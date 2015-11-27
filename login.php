<!DOCTYPE html>

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
    <form id="loginForm" action="http://localhost/github/337final/controller.php" method="post"> <!--MIGHT NEED TO CHANGE THE ACTION, STILL FIGURING OUT CONTROLLER AND LOGIN-->
    Username &nbsp<input type="text" id="loginUsername" name="loginUsername" placeholder="Enter username here"> <br><br>
    Password &nbsp<input type="text" id="loginPassword" name="loginPassword"placeholder="Enter password here"> <br><br>
    <input type="submit" id="loginButton" name="loginButton" value="Login">

    </form>

	</div>


</body>

</html>
