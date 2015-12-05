<!DOCTYPE html>

<html>

<head>
	<title>Rancid Tomatoes Enhanced | Error 404</title>
	<meta charset="utf-8" />
	<link href="main.css" rel="stylesheet" type="text/css">
</head>
<?php
session_start();
$error = $_SESSION["error"];
?>
<body>
	<div id="overallContent">
		<div id="banner">
			<a  href="index.php"><img src="images/rancidbanner.png" alt="Rancid Tomatoes"></a>
		</div>
		<h1>Error 404 - Movie Not Found</h1>
    <p>Your search query, "<?= $error ?>",  does not appear to be in our database. Click <a href="index.php">here</a> to search for another movie.</p>
	</div>


</body>

</html>
