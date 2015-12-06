<!DOCTYPE html>

<html>

<head>
	<title>Rancid Tomatoes Enhanced | Logout</title>
	<meta charset="utf-8" />
	<link href="main.css" rel="stylesheet" type="text/css">
</head>
<?php
session_start (); // to ensure you are using same session
session_destroy (); // destroy the session so $SESSION['anything'] is not set
?>
<body>
	<div id="overallContent">
		<div id="banner">
			<a  href="index.php"><img src="images/rancidbanner.png" alt="Rancid Tomatoes"></a>
		</div>
		<h1>Logout</h1>
    <p>You have successfully logged out. Click <a href="index.php">here</a> to search our database for another movie.</p>
	</div>
</body>
</html>
