<!DOCTYPE html>

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
			<a href="login.php">Login</a>&nbsp|&nbsp<a href="register.php">Register</a>&nbsp|&nbsp<a href="addReview.php">Add Review</a>&nbsp|&nbsp<a href="addNewMovie.php">Add New Movie</a>
		</div>
		<br>
			<div id="container">
				<form id="searchForm" action="http://localhost/github/337final/review.php" method="post">
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
					<a href="review.php?searchKey=Garfield: A Tale of Two Kitties"><img id="adImage" src="images/ad.png" alt="Garfield Ad"></a> <!--STILL NEED TO TEST !-->
				</div>

	  	</div>
			<p id="footer">By <a href="blank.html"class="name">Alex Yee</a> & <a href="blank.html"class="name">Bijan Anjavi</a> </p>
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
						if(i > 19) //greater than 20 titles, so break
							break;
						else if (i > 9) //greater than 10 titles, so put in right box
							document.getElementById("rightDisplayBox").innerHTML = document.getElementById("rightDisplayBox").innerHTML + array[i] + "<br>";
						else //between 0 and 9 index, meaning up to and including 10 titles -> put in left box
							document.getElementById("leftDisplayBox").innerHTML = document.getElementById("leftDisplayBox").innerHTML + array[i] + "<br>";
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
