<!DOCTYPE html>
<!--
	Name: Alex Yee, Bijan Anjavi
  Course: CSC 337
  TA(s): Hasanain Jamal
  Description: Add New Movie page for Rancid Tomatoes Enhanced, only accessible for logged in users
-->
<html>
<head>
	<title>Rancid Tomatoes Enhanced | Add New Movie</title>
	<meta charset="utf-8" />
	<link href="main.css" rel="stylesheet" type="text/css">
</head>
<body>
	<div id="overallContent">
		<div id="banner">
			<a  href="index.php"><img src="images/rancidbanner.png" alt="Rancid Tomatoes"></a>
		</div>
		<h1>Add New Movie</h1>
    <form id="newForm" action="controller.php" method="post" enctype="multipart/form-data">
    	<div class="newInputField"><span class="newText">Title</span><input class="newField" type="text" id="newTitle" name="newTitle"  required></div><br><br>
			<div class="newInputField"><span class="newText">Director</span><input class="newField" type="text" id="newDirector" name="newDirector"  required></div><br><br>
			<div class="newInputField"><span class="newText">MPAA Rating</span>
				<input class="newRadioField" type="radio" id="G" name="newRating" value="G" required>G
				<input class="newRadioField" type="radio" id="PG" name="newRating" value="PG" required>PG
				<input class="newRadioField" type="radio" id="PG-13" name="newRating" value="PG-13" required>PG-13
				<input class="newRadioField" type="radio" id="R" name="newRating" value="R" required>R
			</div><br>
			<div class="newInputField"><span class="newText">Year</span><input class="newField" type="number" id="newYear" name="newYear"  min="1900" max="2017" required></div><br><br>
			<div class="newInputField"><span class="newText">Runtime (Minutes)</span><input class="newField" type="number" id="newRuntime" name="newRuntime"  required></div><br><br>
			<div class="newInputField"><span class="newText">Box Office</span><input class="newField" type="number" id="newBoxOffice" name="newBoxOffice" min="0" required></div><br><br>
			<div class="newInputField"><span class="newText">Select file to upload:</span><input class="newText" type="file" id="file" name="file" required></div><br><br>
			<br><br>
    	<input type="submit" id="newMovieButton" name="newMovieButton" value="Add Movie">
			<?php
			      session_start ();
						echo $_SESSION ['notLoggedInError'];
			      echo $_SESSION ['addNewMovieError'];
						$_SESSION ['notLoggedInError'] = "";
						$_SESSION ['addNewMovieError'] = "";
			?>
    </form>
	</div>
</body>
</html>
