<?php
/*Name: Alex Yee, Bijan Anjavi
  Course: CSC 337
  TA(s): Hasanain Jamal
  Description: model for Rancid Tomatoes Enhanced database
 */
class Model {
  private $conn;
  /*Description: constructor for the Model class, used to assign instance variable to the database. */
  public function __construct(){
    $db= 'mysql:dbname=movies;host=127.0.0.1';
    $user = 'root';
    $password = '';
    try{
        $this->conn = new PDO($db, $user, $password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e){
    echo "Error: " . $e->getMessage();
    }
    //$conn = null; not necessary
  }
  /*Description: returns the titles from the title table as an associative array.*/
  public function getAllTitles() {
    $stmt = $this->conn->prepare("SELECT title FROM titles");
    $stmt->execute(); //prepared statements
    $arrayOfTitles = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $arrayOfTitles;
  }
  /*Description: returns the overall info from the title table for a specific movie as an associative array.*/
  public function getOverallInfoFor($title){
    $stmt = $this->conn->prepare (
        "SELECT imageFileName, director, mpaaRating, score, year, runtime, boxOffice
         FROM titles
         WHERE title = :title" );
    $stmt->bindParam ( 'title', $title );
    $stmt->execute ();
    $array = $stmt->fetch ( PDO::FETCH_ASSOC );
    return $array;
  }
  /*Description: returns the reviews from the reviews + reviewers tables for a specific movie as an associative array.*/
  public function getReviewsFor($title) {
		$stmt = $this->conn->prepare (
				"SELECT reviews.rating, reviews.review, reviewers.firstname, reviewers.lastname, reviewers.publication
				 FROM reviewers
				 INNER JOIN reviews
				 ON reviewers.reviewerID=reviews.reviewerID
				 WHERE reviews.title = :title" );
		$stmt->bindParam ( 'title', $title );
		$stmt->execute ();
		$array = $stmt->fetchAll ( PDO::FETCH_ASSOC );
		return $array;
	}
  public function reviewGif($reviewRating) {
    if($reviewRating == "FRESH"){
      $reviewImage =  "images/fresh.gif";
    }
    else{
        $reviewImage = "images/rotten.gif";
      }
    return $reviewImage;
  }
  /*Description: adds a new movie to the database, to the title table.*/
  public function addNewMovie($title, $imageFileName, $director, $mpaa, $score, $year, $runtime, $boxOffice){
  	$stmt = $this->conn->prepare (
				"INSERT INTO titles(title, imageFileName, director, mpaaRating, score, year, runtime, boxOffice)
				VALUES(:title, :imageFileName, :director, :mpaa, :score, :year, :runtime, :boxOffice); ");
		$stmt->bindParam ( 'title', $title );
    $stmt->bindParam ( 'imageFileName', $imageFileName );
		$stmt->bindParam ( 'director', $director );
		$stmt->bindParam ( 'mpaa', $mpaa );
		$stmt->bindParam ( 'score', $score );
		$stmt->bindParam ( 'year', $year );
		$stmt->bindParam ( 'runtime', $runtime );
		$stmt->bindParam ( 'boxOffice', $boxOffice );
		$stmt->execute ();
  }
  /*Description: adds a new reviewer to the database, to the reviewers table. note: username == reviewerID*/
  public function addReviewer($username, $firstname, $lastname, $publication) {
  	$stmt = $this->conn->prepare (
				"INSERT INTO reviewers(reviewerID, firstname, lastname, publication)
				VALUES(:reviewerID, :firstname, :lastname, :publication); ");
		$stmt->bindParam ( 'reviewerID', $username );
		$stmt->bindParam ( 'firstname', $firstname );
		$stmt->bindParam ( 'lastname', $lastname );
		$stmt->bindParam ( 'publication', $publication );
		$stmt->execute ();
  }
  /*Description: adds a new review to the database, to the reviews table.*/
  public function addReview($title, $ID, $review, $rating){
  	$stmt = $this->conn->prepare (
				"INSERT INTO reviews(title, reviewerID, review, rating)
				VALUES(:title, :reviewerID, :review, :rating); ");
		$stmt->bindParam ( 'title', $title );
		$stmt->bindParam ( 'reviewerID', $ID );
		$stmt->bindParam ( 'review', $review );
		$stmt->bindParam ( 'rating', $rating );
		$stmt->execute ();
  }
  /*Description: adds a new users to the users table.*/
  public function register($username, $password) {
    $hash = password_hash ( $password, PASSWORD_DEFAULT );
    $sth = $this->conn->prepare ( "INSERT INTO users (username, hash) VALUES ( :username, :hash);" );
    $sth->bindParam ( ':username', $username );
    $sth->bindParam ( ':hash', $hash );
    $sth->execute ();
  }
  /*Description: checks to see whether $username exists in the users table*/
  public function usernameExists($username){ // returns true if username exists in users
  	$stmt = $this->conn->prepare ( 'SELECT * FROM users WHERE username = :username' );
	$stmt->bindParam ( ':username', $username );
	$stmt->execute ();
	$stmt->fetch ();
	if ($stmt->rowCount () === 0)
		return FALSE;
	else
		return TRUE;
  }
  /*Description: verifies that the entered password is correct when user is trying to login, and its hash matches with the stored hash*/
  public function verify($username, $password) {
    $stmt = $this->conn->prepare ( 'SELECT hash FROM users WHERE username = :username' );
  $stmt->bindParam ( ':username', $username );
  $stmt->execute ();
  $user = $stmt->fetch ();
  // Hashing the password with its hash as the salt returns the same hash
  if (password_verify ( $password, $user ['hash'] ))
    return TRUE;
  else
    return FALSE;
  }
  /*Description: checks to see whether $title exists in the titles table*/
  public function titleExists($title){ // returns true if title title in titles
    $stmt = $this->conn->prepare ( 'SELECT * FROM titles WHERE title = :title' );
  $stmt->bindParam ( ':title', $title );
  $stmt->execute ();
  $stmt->fetch ();
  if ($stmt->rowCount () === 0)
    return FALSE;
  else
    return TRUE;
  }
  /*Description: checks to see whether uploaded file for overview image is in png format*/
  public function isPNG( $filePath ){
    $mime = mime_content_type($filePath);
    return ( $mime === 'image/png' );
  }
  /*Description: calculates dyanmic review score for a movie page*/
  public function getScore($title){
    $stmt = $this->conn->prepare( 'SELECT rating FROM reviews WHERE title = :title' );
    $stmt->bindParam ( ':title', $title );
    $stmt->execute ();
    $stmt->fetch ();
    $stmh = $this->conn->prepare( 'SELECT rating FROM reviews WHERE title = :title AND rating = "FRESH"' );
    $stmh->bindParam ( ':title', $title );
    $stmh->execute ();
    $stmh->fetch ();
    if($stmh->rowCount () == 0)
      return 0;
    else
      return (int) ($stmh->rowCount () / $stmt->rowCount () * 100);
  }
}
?>
