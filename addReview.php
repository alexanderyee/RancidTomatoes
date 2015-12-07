<!DOCTYPE html>
<!--
	Name: Alex Yee, Bijan Anjavi
  Course: CSC 337
  TA(s): Hasanain Jamal
  Description: Add New Review page for Rancid Tomatoes Enhanced, only accessible for logged in users
-->
<html>
<head>
	<title>Rancid Tomatoes Enhanced | Add Review</title>
	<meta charset="utf-8" />
	<link href="main.css" rel="stylesheet" type="text/css">
</head>
<body>
	<div id="overallContent">
		<div id="banner">
			<a  href="index.php"><img src="images/rancidbanner.png" alt="Rancid Tomatoes"></a>
		</div>
		<h1>Add Review</h1>
    <form id="reviewForm" action="controller.php" method="post">
    	Title <br><input type="text" id="reviewTitle" name="reviewTitle"  required > <br><br>
			Review <br><textarea rows="10" cols="50" id="reviewReview" name="reviewReview" maxlength=500 required></textarea>
			<br><br>
			<fieldset>
				<legend>Rating</legend>
					<input type="radio" id="reviewFresh" name="rating" value="FRESH" required> FRESH
					<br>
					<input type="radio" id="reviewRotten" name="rating" value="ROTTEN" required> ROTTEN
				</fieldset>
				<br><br>
    <input type="submit" id="reviewButton" name="reviewButton" value="Add Review">
    </form>
	</div>
</body>
</html>
