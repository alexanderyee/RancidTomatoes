<?php
/*Name: Alex Yee, Bijan Anjavi
  Course: CSC 337
  TA(s): Hasanain Jamal
  Description: controller for Rancid Tomatoes Enhanced, interacts between client input
	and database
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
	$username = $_POST ['registerUsername']; //not seen by user in HTML view
	$password = $_POST ['registerPassword']; //not seen by user in HTML view
 	$firstname= htmlspecialchars(trim($_POST ['registerFirstName']));
	$lastname = htmlspecialchars(trim($_POST ['registerLastName']));
	$publication = htmlspecialchars(trim($_POST ['registerPublication']));
	if ($modelMethods->usernameExists($username)){
		session_start ();
		$_SESSION ['registrationError'] = 'Username has already been taken';
		header ("Location: register.php");
	} else {
			$modelMethods->register ( $username, $password );
			$modelMethods->addReviewer($username, $firstname, $lastname, $publication);
			header ( "Location: index.php" );
	}
}
elseif (isset ( $_POST ['logout'] )) { //NOT NEEDED FOR OUR IMPLEMENTATION OF LOGOUT
	session_start (); // to ensure you are using same session
	session_destroy (); // destroy the session so $SESSION['anything'] is not set
	header ( "Location: index.php" );
} elseif (isset ($_POST ['newTitle'])) {
	$title = htmlspecialchars(trim($_POST ['newTitle']));
	//UPLOAD IMAGE
	if ( !isset($_FILES['file']['error']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK )
	    die( "Upload failed with error" );
	if ( !$modelMethods->isPNG( $_FILES['file']['tmp_name']) )
	    die( "Cannot upload the file as it is not a PNG file" );
		$fileTitle = preg_replace('/[^A-Za-z0-9 _ .-]/', '', $title); //changes into filesafe naming form
		$target_dir = "C:/xampp/htdocs/github/337final/uploads/"; //replace with your own absolute path to the upload folder, also make sure to modify permissions
		$target_file = $target_dir . $fileTitle . ".png";
		$uploadOk = 1;
		// if file already exists
		if (file_exists($target_file)) {
		    echo "File already exists.";
		    $uploadOk = 0;
		}
		// if $uploadOk is set to 0
		if ($uploadOk == 0) {
		    echo "File was not uploaded.";
		// try to upload file
		} else {
		    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
		        echo "The file ". basename( $_FILES["file"]["name"]). " has been uploaded.";
		    } else {
		        echo "Sorry, there was an error uploading your file.";
		    }
		}
	$imageFileName = "uploads/" . $fileTitle . ".png";
	$director = htmlspecialchars(trim($_POST ['newDirector']));
	$mpaa = htmlspecialchars(trim($_POST ['newRating']));
	$year = htmlspecialchars(trim($_POST ['newYear']));
	$runtime = htmlspecialchars(trim($_POST ['newRuntime']));
	$boxOffice = htmlspecialchars(trim($_POST ['newBoxOffice']));
	$boxOffice = number_format($boxOffice); //add commas to turn into a string with number format
	session_start ();
	if (!isset ($_SESSION['user'])) {
		session_start ();
		$_SESSION['notLoggedInError'] = 'Only logged-in users can add new movies.';
		header ("Location: addNewMovie.php");
	} elseif ($modelMethods->titleExists($title)){
		session_start ();
		$_SESSION ['addNewMovieError'] = 'The movie already exists in our database';
		header ("Location: addNewMovie.php");
	} else {
			$modelMethods->addNewMovie($title, $imageFileName, $director, $mpaa, $year, $runtime, $boxOffice);
			session_start ();
			$_SESSION["title"] = $title;
			header ( "Location: review.php" );
	}
} elseif (isset ($_POST ['reviewTitle'])) {
	$title = htmlspecialchars(trim($_POST ['reviewTitle']));
	$review = htmlspecialchars(trim($_POST ['reviewReview']));
	$rating = htmlspecialchars(trim($_POST ['rating']));
	session_start ();
	if (!isset ($_SESSION['user'])) {
		session_start ();
		$_SESSION['notLoggedInError'] = 'Only logged-in users can add reviews.';
		header ("Location: addReview.php");
	}
	else {
		$modelMethods->addReview($title, $_SESSION["user"], $review, $rating);
		session_start ();
		$_SESSION["title"] = $title;
		header ("Location: review.php");
	}
}
?>
