<!DOCTYPE html>

<html>
<!--REQUIREMENTS OF SPEC NOT MET - ADD SOME MORE ERROR CHECKING, HTML CHARS, ETC After Formatting Views - W


MAKE SURE TO GET THE USERNAME OF THE USER LOGGED IN WHILE ADDING A movieREVIEW FOR USE IN POST - reviewerID and username are the same
 -->
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
    <form id="newForm" action="http://localhost/github/337final/controller.php" method="post"> <!--MIGHT NEED TO CHANGE THE ACTION, STILL FIGURING OUT CONTROLLER AND LOGIN-->
    	Title &nbsp<input type="text" id="newTitle" name="newTitle"  required > <br><br>
			<form action="http://localhost/github/337final/controller.php" method="post" enctype="multipart/form-data">
			    Select file to upload:
			    <input type="file" id="file" name="file">
			    <input type="submit" value="Upload File" id="submitFile" name="submitFile">
			</form><br><br>

			Director &nbsp<input type="text" id="newDirector" name="newDirector"  required > <br><br>
			Rating &nbsp<input type="text" id="newRating" name="newRating"  required > <br><br>
			Score &nbsp<input type="number" id="newScore" name="newScore" min="0" max="100" required > <br><br>
			Year &nbsp<input type="number" id="newYear" name="newYear"  required > <br><br>
			Runtime &nbsp<input type="number" id="newRuntime" name="newRuntime"  required > <br><br>
			Box Office &nbsp<input type="number" id="newBoxOffice" name="newBoxOffice" min="0" required > <br><br>

    <input type="submit" id="reviewButton" name="reviewButton" value="Add Review">

    </form>

	</div>


</body>

</html>
