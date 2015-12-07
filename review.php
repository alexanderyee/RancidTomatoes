<?php
	require_once("model.php");
?>
<!DOCTYPE html>
<!-- Name: Alex Yee, Bijan Anjavi
     Course: CSC 337
		 TA(s): Hasanain Jamal
		 Description: review.php is an advanced version of the movie.php from an earlier project that
		 allows the user to see the movie page for multiple movies via AJAX/javascript, php, sql, html, and css
-->
<html>
<head>
	<title>Rancid Tomatoes</title>
	<meta charset="utf-8" />
	<link href="review.css" rel="stylesheet" type="text/css">
</head>
<body>
	<div id="banner">
		<a  href="index.php"><img src="images/rancidbanner.png" alt="Rancid Tomatoes"></a>
	</div>
  <?php
	session_start ();
	if(isset($_GET["adTitle"])){ //clicked on ad
		$_SESSION["title"] = htmlspecialchars(trim($_GET["adTitle"]));
		unset( $_GET["adTitle"] );
	}
	if(isset($_POST["searchKey"])) {
		$_SESSION["title"] = htmlspecialchars(trim($_POST["searchKey"]));
		unset( $_POST["searchKey"] );
	}
 //assume sent by controller and session is not empty
	$title = $_SESSION["title"];
	$modelMethods = new Model();
	$exists = $modelMethods->titleExists($title);
	if($exists == 1){
		header ( "Location:error.php" );
		exit;
	}
	$overallInfo = $modelMethods->getOverallInfoFor($title);
  $overviewImageFileName = $overallInfo['imageFileName'];
	$director = $overallInfo['director'];
	$mpaaRating = $overallInfo['mpaaRating'];
	$score = $overallInfo['score'];
	$year = $overallInfo['year'];
	$runtime = $overallInfo['runtime'];
	$boxOffice = $overallInfo['boxOffice'];
	if($score >= 60){
		$scoreImage =  "images/freshlarge.png";
		$scoreImageAlt = "FRESH";
	}
  else{
		$scoreImage = "images/rottenlarge.png";
		$scoreImageAlt = "ROTTEN";
	}
  ?>
	<h1><?= $title . " (" . $year . ")"?></h1>
	<div id="overallcontent">
		<div id="reviews-overall">
			<div id="reviews-header">
				<img src=<?= $scoreImage ?>  alt= <?= $scoreImageAlt ?> /> <?= $score . "%" ?>
			</div>
			<?php //set up how to divide reviews amongst columns
			$reviews = $modelMethods->getReviewsFor($title);
			$N = count($reviews);
			$maxLeftColumn = ceil($N/2); //how many to store in left column, which takes priority
			$leftColumnCount = 0;
			$rightColumnCount = 0;
			?>
			<div class="column">
				<?php
				foreach($reviews as $review) {
					$reviewRating = $review['rating'];
					$reviewText = $review['review'];
					$reviewFirstName = $review['firstname'];
					$reviewLastName = $review['lastname'];
					$reviewAuthor = $reviewFirstName . " ". $reviewLastName;
					$reviewPublication = $review['publication'];
					$reviewRatingGif = $modelMethods->reviewGif($reviewRating);
				if($leftColumnCount < $maxLeftColumn){ //how many to store in left column
			   ?>
				 <div class="review">
 					<p class="quote">
 						<img src= <?= $reviewRatingGif ?> alt= <?= $reviewRating ?>/>
 						<q><?= $reviewText ?></q>
 					</p>
 					<p class="reviewer">
 						<img src= "images/critic.gif" alt="Critic" /> <?= $reviewAuthor ?>
 						<br />
 						<em><?= $reviewPublication ?></em>
 					</p>
 				</div>
			<?php
		     }
				 $leftColumnCount = $leftColumnCount + 1; //increment left
			 }
			 ?>
		 </div>
			<div class="column">
				<?php
				foreach($reviews as $review) {
					$reviewRating = $review['rating'];
					$reviewText = $review['review'];
					$reviewFirstName = $review['firstname'];
					$reviewLastName = $review['lastname'];
					$reviewAuthor = $reviewFirstName . " ". $reviewLastName;
					$reviewPublication = $review['publication'];
					$reviewRatingGif = $modelMethods->reviewGif($reviewRating);
					if($rightColumnCount >= $maxLeftColumn){ //right column takes priority after left
			   ?>
				 <div class="review">
 					<p class="quote">
						<!-- FUNCTIONS -->
 						<img src= <?= $reviewRatingGif ?> alt= <?= $reviewRating ?>/>
 						<q><?= $reviewText ?></q>
 					</p>
 					<p class="reviewer">
 						<img src= "images/critic.gif" alt="Critic" /> <?= $reviewAuthor ?>
 						<br />
 						<em><?= $reviewPublication ?></em>
 					</p>
 				</div>

				<?php
					 }
					 $rightColumnCount = $rightColumnCount + 1; //increment right
				 }
				 ?>
			</div>
		</div>
		<div id="general-overview">
			<div>
				<img src= <?= $overviewImageFileName ?> alt="general overview" />
			</div>
			<dl>
				<dt>DIRECTOR</dt>
				<dd><?= $director ?></dd>
				<dt>MPAA RATING</dt>
				<dd><?= $mpaaRating ?></dd>
				<dt>THEATRICAL RELEASE YEAR</dt>
				<dd><?= $year ?></dd>
				<dt>SCORE</dt>
				<dd><?= $score ?>%</dd>
				<dt>RUNTIME</dt>
				<dd><?= $runtime ?> minutes</dd>
				<dt>BOX OFFICE</dt>
				<dd>$<?= $boxOffice ?></dd>
			</dl>
		</div>
		<p id="footer">(1-<?= $N ?>) of <?= $N ?></p>
    <div id="bottom-reviews-header">
			<img src=<?= $scoreImage ?>  alt= <?= $scoreImageAlt ?> /> <?= $score . "%" ?>
    </div>
	</div>
  <div id="bottom-banner">
		<a  href="index.php"><img src="images/rancidbanner.png" alt="Rancid Tomatoes"></a>
  </div>
</body>
</html>
