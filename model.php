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
				"SELECT Reviews.rating, Reviews.review, Reviewers.name, Reviewers.publication
				 FROM Reviewers
				 INNER JOIN Reviews
				 ON Reviewers.reviewerID=Reviews.reviewerID
				 WHERE title = :title" );
		$stmt->bindParam ( 'title', $title );
		$stmt->execute ();
		$array = $stmt->fetchAll ( PDO::FETCH_ASSOC );
		return $array;
	}

  public function addNewMovie($title, $filename, $director, $mpaa, $score, $year, $runtime, $boxOffice){
  	$stmt = $this->conn->prepare (
				"INSERT INTO titles(title, imageFileName, director, mpaaRating, score, year, runtime, boxOffice)
				VALUES(:title, :filename, :director, :mpaa, :score, :year, :runtime, :boxOffice); ");
		$stmt->bindParam ( 'title', $title );
		$stmt->bindParam ( 'filename', $filename );
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
		$array = $stmt->fetchAll ( PDO::FETCH_ASSOC );
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
}
?>
