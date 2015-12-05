<?php
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
  public function addNewMovie($title, $director, $mpaa, $score, $year, $runtime, $boxOffice){
  	$stmt = $this->conn->prepare (
				"INSERT INTO titles(title, director, mpaaRating, score, year, runtime, boxOffice)
				VALUES(:title, :director, :mpaa, :score, :year, :runtime, :boxOffice); ");
		$stmt->bindParam ( 'title', $title );
		$stmt->bindParam ( 'director', $director );
		$stmt->bindParam ( 'mpaa', $mpaa );
		$stmt->bindParam ( 'score', $score );
		$stmt->bindParam ( 'year', $year );
		$stmt->bindParam ( 'runtime', $runtime );
		$stmt->bindParam ( 'boxOffice', $boxOffice );
		$stmt->execute ();
  }
  public function addReview($title, $ID, $review, $rating){
  	$stmt = $this->conn->prepare (
				"INSERT INTO reviews(title, reviewerID, review, rating)
				VALUES(:title, :ID, :review, :rating); ");
		$stmt->bindParam ( 'title', $title );
		$stmt->bindParam ( 'ID', $ID );
		$stmt->bindParam ( 'review', $review );
		$stmt->bindParam ( 'rating', $rating );
		$stmt->execute ();
  }
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
  public function exists($title){
  // search key in titles, returns true if exists
  	$stmt = $this->conn->prepare ( 'SELECT * FROM titles WHERE title = :title' );
	$stmt->bindParam ( 'title', $title );
	$stmt->execute ();
	$stmt->fetch ();
	if ($stmt->rowCount () === 0)
		return TRUE;
	else
		return FALSE;
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
  public function register($username, $password) {
  	$hash = password_hash ( $password, PASSWORD_DEFAULT );
	$sth = $this->conn->prepare ( "INSERT INTO users (username, hash) VALUES ( :username, :hash);" );
	$sth->bindParam ( ':username', $username );
	$sth->bindParam ( ':hash', $hash );
	$sth->execute ();
  }
  public function usernameExists($username){ // returns true if username exists in users
  	$stmt = $this->conn->prepare ( 'SELECT * FROM users WHERE username = :username' );
	$stmt->bindParam ( ':username', $username );
	$stmt->execute ();
	$stmt->fetch ();
	// Hashing the password with its hash as the salt returns the same hash
	if ($stmt->rowCount () === 0)
		return FALSE;
	else
		return TRUE;
  }
}
?>
