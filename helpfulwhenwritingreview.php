
<!DOCTYPE html>
<html>
<head>
<!--  Rick Mercer -->
<title>Code Demo</title>
<meta charset="utf-8" />
<style>
</style>
</head>

<body>
	<p></p>
	&nbsp;Array of Objects
	<br>
	<input type="button" id="show" value="Show JSON array of objects">
	<br>
	<div class="search" id="arrayOfObjects"></div>

	<script>
	    var clicks = 0;
		var array;

		function getArrayFromServer() {
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
				if (xhttp.readyState == 4 && xhttp.status == 200) {
					array = JSON.parse(xhttp.responseText);
				}
			};
			xhttp.open("GET", "model.php", true);
			xhttp.send();
		}

		getArrayFromServer(); // called on page load or make above function an iife
		// TODO Have an anonymous callback function show all reviews for a Specific Movies
		//  Also, show how often the button is clicked
		document.getElementById("show").onclick = function() {
             review = array[0]['rating'];
             review += '<br>';
             review += array[0]['review'];
             review += '<br>';
             review += array[0]['name'];
             review += '<br>';
             review += array[0]['publication'];
             clicks++;
             review += '<br><br> Clicks: ' + clicks;
             document.getElementById("arrayOfObjects").innerHTML = review;
     	};
   </script>


</body>
</html>
