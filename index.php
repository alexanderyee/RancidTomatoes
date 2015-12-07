<!DOCTYPE html>
<!--
	Name: Alex Yee, Bijan Anjavi
  Course: CSC 337
  TA(s): Hasanain Jamal
  Description: Home page for Rancid Tomatoes Enhanced
-->
<html>
<head>
	<title>Rancid Tomatoes Enhanced | Home</title>
	<meta charset="utf-8" />
	<link href="main.css" rel="stylesheet" type="text/css">
</head>
<body>
	<div id="overallContent">
		<div id="banner">
			<a  href="index.php"><img src="images/rancidbanner.png" alt="Rancid Tomatoes"></a>
		</div>
		<h1>Rancid Tomatoes Enhanced</h1>
		<div id="nav">
			<?php
			session_start (); // Need this in each file before $_SESSION
			$_SESSION ['loginError'] = "";
			$_SESSION ['registrationError'] = "";
			$_SESSION ['addNewMovieError'] = "";
			$_SESSION ['notLoggedInError'] = "";

			if (isset ( $_SESSION ["user"] )) {
				$loggedInUsername = $_SESSION ["user"];
			?>
			Hello, <?= $loggedInUsername ?> &nbsp|&nbsp
			<a href="logout.php">Logout</a>&nbsp|&nbsp
			<a href="addReview.php">Add Review</a>&nbsp|&nbsp
			<a href="addNewMovie.php">Add New Movie</a>
			<?php
			}
			else {
			?>
			<a href="login.php">Login</a> &nbsp|&nbsp
			<a href="register.php">Register</a>
			<?php
			}
			?>
		</div>
		<br>
			<div id="container">
				<form id="searchForm" action="review.php" method="post">
						<input type="submit" id="searchButton" name="searchButton" value="Search">
					<input type="search" id="searchKey" name="searchKey" oninput="displayMovies()">
				</form>
			<br>
			  <div class="displayBox" id="leftDisplayBox">
					 ?
			  </div>
			  <div class="displayBox" id="rightDisplayBox">
					 ?
				</div>
				<div id="ad">
					<div id="adText"><i>Critics are hailing it as the must-see film of the century...</i></div>
					<a href="review.php?adTitle=Garfield: A Tail of Two Kitties"><img id="adImage" src="images/ad.png" alt="Garfield Ad"></a> <!--STILL NEED TO TEST !-->
				</div>
	  	</div>
			<p id="footer">By Alex Yee &amp Bijan Anjavi</p>
	</div>
	<script>
		function displayMovies() {
			var searchKey = document.getElementById("searchKey").value;
			var xhttp = new XMLHttpRequest();
			// anonymous callback will execute upon server response
			xhttp.onreadystatechange = function() {
				// States 0 1 2 3 4 (4 means success)
				// 404 is bad xhttp.status, 200 is good
				if (xhttp.readyState == 4 && xhttp.status == 200) {
					// parse JSONArray (from movieSearch.php)
					var array = JSON.parse(xhttp.responseText);
					for(i = 0; i < array.length; i++){
						if(i > 9) //greater than 10 titles, so break
							break;
						else if (i > 4) //greater than 5 titles, so put in right box
							document.getElementById("rightDisplayBox").innerHTML = document.getElementById("rightDisplayBox").innerHTML + array[i] + "<br><br>";
						else //between 0 and 9 index, meaning up to and including 10 titles -> put in left box
							document.getElementById("leftDisplayBox").innerHTML = document.getElementById("leftDisplayBox").innerHTML + array[i] + "<br><br>";
					}
				}
			}
			// use GET
			document.getElementById("rightDisplayBox").innerHTML =  "";
			document.getElementById("leftDisplayBox").innerHTML = "";
			xhttp.open("GET", "movieSearch.php?searchKey=" + searchKey, true);
			xhttp.send();
		}
	</script>
</body>
</html>
