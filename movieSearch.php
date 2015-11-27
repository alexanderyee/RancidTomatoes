<?php
/*Name: Bijan Anjavi
  Course: CSC 337
  TA(s): Hasanain Jamal, Dilan Jenkins
  Description: movieSearch.php gets the array from getArrayOfTitles.php and uses it
  to construct a JSONArray representation of all movie titles matching the searchKey
  entered by the user.
 */
  require_once './model.php';
  $modelMethods = new Model();
  $arrayOfTitles = $modelMethods->getArrayOfTitles();
  $searchKey = $_GET['searchKey'];
  $JSONArray = '['; //begin JSONArray string
  foreach($arrayOfTitles as $record) {
    $title = $record['title'];
    if (strpos($title, $searchKey) !== false)
      $JSONArray = $JSONArray . ' " ' . $title . ' ",';
  }
  $JSONArray = rtrim($JSONArray, ","); //remove last comma
  $JSONArray = $JSONArray . ']'; //end JSONArray string
  echo $JSONArray; //echo for use in AJAX in suggest.html

  header ( "Location: index.php" ); //REDIRECTOIN AFTER ADDING NEW MOVIE ONLY - specify condtion MIGHT NEED DIFFERENT CONTROLLERS - not right, need to put in another file not controller

?>
