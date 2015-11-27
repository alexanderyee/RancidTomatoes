<?php
	require_once("functions.php");
?>
<!DOCTYPE html>
<!-- Name: Bijan Anjavi
     Course: CSC 337
		 TA(s): Hasanain Jamal, Dilan Jenkins
		 Description: movie.php is an advanced version of the movie.html from an earlier project that
		 allows the user to see the movie page for multiple movies. The name of the movie to be looked
		 at is determined by looking at the URL query parameter named film.-->
<html>

<head>
	<title>Rancid Tomatoes</title>
	<meta charset="utf-8" />
	<link href="css/review.css" rel="stylesheet" type="text/css">
</head>

<body>
	<div id="banner">
		<img src="images/rancidbanner.png" alt="Rancid Tomatoes">
	</div>
  <?php //to set up the page, get URL queryParameter,set up header, and set up overviewImage
	if(empty($_GET)){
		$movie = "tmnt";
	}
  else{
  	$movie = trim($_GET["film"]);
	}
  $infoFile = $movie . "/info.txt";
	list($title, $year, $rating) = file($infoFile);
	$title = trim($title);
	$year = trim($year);
	$rating = trim($rating);
	if($rating >= 60){ //Could be modularized, not much bc not be repeated (unlike reviews + overview)
		$ratingImage =  "images/freshlarge.png";
		$ratingImageAlt = "FRESH";
	}
  else{
		$ratingImage = "images/rottenlarge.png";
		$ratingImageAlt = "ROTTEN";
	}
	$overviewImage = $movie . "/overview.png";
  ?>
	<h1><?= $title . " (" . $year . ")"?></h1>
	<div id="overallcontent">
		<div id="reviews-overall">
			<div id="reviews-header">
				<img src=<?= $ratingImage ?>  alt= <?= $ratingImageAlt ?> /> <?= $rating . "%" ?>
			</div>
			<?php //set up how to divide reviews amongst columns
			$reviewFiles = glob($movie . "/" . "review*.txt");
			$N = count($reviewFiles);
			$maxLeftColumn = ceil($N/2); //how many to store in left column, which takes priority
			$leftColumnCount = 0;
			$rightColumnCount = 0;
			?>
			<div class="column">
				<?php
				foreach($reviewFiles as $reviewFileName) {
					if(count(file($reviewFileName)) < 4){ //case where there is no source/organization for review
						$reviewSource = "";
						list($reviewText, $reviewRating, $reviewAuthor) = file($reviewFileName);
					}
					else{
						list($reviewText, $reviewRating, $reviewAuthor, $reviewSource) = file($reviewFileName);
					}
				if($leftColumnCount < $maxLeftColumn){ //how many to store in left column
			   ?>
				 <div class="review">
 					<p class="quote">
						<!-- FUNCTIONS -->
 						<img src= <?= reviewGif(trim($reviewRating)) ?> alt= <?= trim($reviewRating) ?>/>
 						<q><?= trim($reviewText) ?></q>
 					</p>
 					<p class="reviewer">
 						<img src= "images/critic.gif" alt="Critic" /> <?= trim($reviewAuthor) ?>
 						<br />
 						<em><?= trim($reviewSource) ?></em>
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
				foreach($reviewFiles as $reviewFileName) {
					if($rightColumnCount >= $maxLeftColumn){ //right column takes priority after left
						if(count(file($reviewFileName)) < 4){ //case where there is no source/organization for review
							$reviewSource = "";
							list($reviewText, $reviewRating, $reviewAuthor) = file($reviewFileName);
						}
						else{
							list($reviewText, $reviewRating, $reviewAuthor, $reviewSource) = file($reviewFileName);
						}
			   ?>
				 <div class="review">
 					<p class="quote">
						 <!-- FUNCTIONS -->
 						<img src= <?= reviewGif(trim($reviewRating)) ?> alt= <?= trim($reviewRating) ?>/>
 						<q><?= trim($reviewText) ?></q>
 					</p>
 					<p class="reviewer">
 						<img src= "images/critic.gif" alt="Critic" /> <?= trim($reviewAuthor) ?>
 						<br />
 						<em><?= trim($reviewSource) ?></em>
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
				<img src= <?= $overviewImage ?> alt="general overview" />
			</div>
			<dl>
				<?php
				$overviewFileName = $movie . "/overview.txt"; //STARRING: actors on same line with comma
				$overviewLines = file($overviewFileName);
				$count = count($overviewLines); //counts number of elements in array, or number of lines
				for($i = 0; $i < $count; $i++){
				?>
				<!-- FUNCTIONS -->
				<dt><?= overviewItem($overviewLines[$i]) ?></dt>
				<dd><?= overviewDescription($overviewLines[$i]) ?></dd>
				<?php
			   }
				?>
			</dl>
		</div>
		<p id="footer">(1-<?= $N ?>) of <?= $N ?></p>
    <div id="bottom-reviews-header">
			<img src=<?= $ratingImage ?>  alt= <?= $ratingImageAlt ?> /> <?= $rating . "%" ?>
    </div>
	</div>
  <div id="bottom-banner">
    <img src="images/rancidbanner.png" alt="Rancid Tomatoes">
  </div>
</body>

</html>
