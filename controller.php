<?php
/*Name: Bijan Anjavi, Alex Yee
  Course: CSC 337
  TA(s): Hasanain Jamal, Dilan Jenkins
  Description: movieSearch.php gets the array from getArrayOfTitles.php and uses it
  to construct a JSONArray representation of all movie titles matching the searchKey
  entered by the user.
 */
require_once("model.php");
$modelMethods = new Model();
if (isset ( $_POST ['loginUsername'] ) && isset ( $_POST ['loginPassword'] )) {
	$username = $_POST ['loginUsername'];
	$password = $_POST ['loginPassword'];
	session_start (); // Do this in every file before accessing $_SESSION (bad name?)
	if ($modelMethods->verify($username, $password)) {
		$_SESSION ['user'] = $username;
		header ( "Location: index.php" );
	} else {
		$_SESSION ['loginError'] = 'Invalid Account/Password';
		header ( "Location: login.php" );
		}
	
} else if (isset ( $_POST ['registerUsername'] ) && isset ( $_POST ['registerPassword'] )) {
	$username = $_POST ['registerUsername'];
	$password = $_POST ['registerPassword'];
	if ($modelMethods->usernameExists($username)){
		$_SESSION ['registerError'] = 'Username has already been taken';
		header ("Location: register.php")
	} else {
		$modelMethods->register ( $username, $password );
		header ( "Location: index.php" );
	}
}
elseif (isset ( $_POST ['logout'] )) {
	session_start (); // to ensure you are using same session
	session_destroy (); // destroy the session so $SESSION['anything'] is not set
	header ( "Location: index.php" );
	
} elseif (isset ($_POST ['newTitle'])) {
	$title = $_POST ['newTitle'];
	$director = $_POST ['newDirector'];
	$mpaa = $_POST ['newRating'];
	$score = $_POST ['newScore'];
	$year = $_POST ['newYear'];
	$runtime = $_POST ['newRuntime'];
	$boxOffice = $_POST ['newBoxOffice'];
	$modelMethods->addNewMovie($title, $director, $mpaa, $score, $year, $runtime, $boxOffice);
	header ( "Location: review.php" ); 
} elseif (isset ($_POST ['reviewTitle'])) {
	$title = $_POST ['reviewTitle'];
	$review = $_POST ['reviewReview'];
	$rating = $_POST ['rating'];
	$modelMethods->addReview($title, "1"/*reviewerID?*/, $review, $rating);
	header ("Location: review.php")
} 

?>
