<!DOCTYPE html>

<html>
<!--REQUIREMENTS OF SPEC NOT MET - ADD SOME MORE ERROR CHECKING, HTML CHARS, ETC After Formatting Views - W


MAKE SURE TO GET THE USERNAME OF THE USER LOGGED IN WHILE ADDING A movieREVIEW FOR USE IN POST - reviewerID and username are the same
 -->
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
    <form id="reviewForm" action="controller.php" method="post"> <!--MIGHT NEED TO CHANGE THE ACTION, STILL FIGURING OUT CONTROLLER AND LOGIN-->
    	Title &nbsp<input type="text" id="reviewTitle" name="reviewTitle"  required > <br><br>
			Review <textarea rows="10" cols="50" id="reviewReview" name="reviewReview" maxlength=500 required></textarea> <!--ADD CANCEL EFFORT FEATURE -->
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
