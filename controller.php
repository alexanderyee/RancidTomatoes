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

} elseif (isset ( $_POST ['registerUsername'] ) && isset ( $_POST ['registerPassword'] )) {
	$username = $_POST ['registerUsername'];
	$password = $_POST ['registerPassword'];
 	$firstname= trim($_POST ['registerFirstName']);
	$lastname = trim($_POST ['registerLastName']);
	$publication = trim($_POST ['registerPublication']);

	if ($modelMethods->usernameExists($username)){
		session_start ();
		$_SESSION ['registerError'] = 'Username has already been taken';
		header ("Location: register.php");
	} else {
		$modelMethods->register ( $username, $password );
		$modelMethods->addReviewer($username, $firstname, $lastname, $publication);

		header ( "Location: index.php" );
	}
}
elseif (isset ( $_POST ['logout'] )) {
	session_start (); // to ensure you are using same session
	session_destroy (); // destroy the session so $SESSION['anything'] is not set
	header ( "Location: index.php" );

} elseif (isset ($_POST ['newTitle'])) {
	$title = trim($_POST ['newTitle']);

	//image
	if ( !isset($_FILES['file']['error']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK )
	  die( "Upload failed with error" );
	if ( !$modelMethods->isPNG( $_FILES['file']['tmp_name']) )
	  die( "Cannot upload the file as it is not a PNG file" );


		$fileTitle = preg_replace('/\s+/', '', $title); //remove spaces
		$target_dir = "C:/xampp/htdocs/github/337final/uploads/";
		$target_file = $target_dir . $fileTitle . ".png";
		$uploadOk = 1;

		// Check if file already exists
		if (file_exists($target_file)) {
		    echo "Sorry, file already exists.";
		    $uploadOk = 0;
		}

		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
		    echo "Sorry, your file was not uploaded.";
		// if everything is ok, try to upload file
		} else {
		    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
		        echo "The file ". basename( $_FILES["file"]["name"]). " has been uploaded.";
		    } else {
		        echo "Sorry, there was an error uploading your file.";
		    }
		}





	$imageFileName = "uploads/" . $fileTitle . ".png";


	$director = trim($_POST ['newDirector']);
	$mpaa = trim($_POST ['newRating']);
	$score = trim($_POST ['newScore']);
	$year = trim($_POST ['newYear']);
	$runtime = trim($_POST ['newRuntime']);
	$boxOffice = trim($_POST ['newBoxOffice']);
	$modelMethods->addNewMovie($title, $imageFileName, $director, $mpaa, $score, $year, $runtime, $boxOffice);

	session_start ();
	$_SESSION["title"] = $title;
	header ( "Location: review.php" );

} elseif (isset ($_POST ['reviewTitle'])) {
	$title = trim($_POST ['reviewTitle']);
	$review = trim($_POST ['reviewReview']);
	$rating = trim($_POST ['rating']);
	session_start ();
	$modelMethods->addReview($title, $_SESSION["user"], $review, $rating);
	$_SESSION["title"] = $title;
	header ("Location: review.php");
}

?>
