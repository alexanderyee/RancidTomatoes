<?php
/*Name: Alex Yee, Bijan Anjavi
  Course: CSC 337
  TA(s): Hasanain Jamal
  Description: movieSearch.php is used to construct a JSON representation of the
  titles in the database that match what the user is entering on index.php via AJAX
 */
  require_once './model.php';
  $modelMethods = new Model();
  $arrayOfTitles = $modelMethods->getAllTitles();
  $searchKey = $_GET['searchKey'];
  $JSONArray = '['; //begin JSONArray string
  foreach($arrayOfTitles as $record) {
    $title = $record['title'];
    if (strpos($title, $searchKey) !== false)
      $JSONArray = $JSONArray . ' " ' . $title . ' ",';
  }
  $JSONArray = rtrim($JSONArray, ","); //remove last comma
  $JSONArray = $JSONArray . ']'; //end JSONArray string
  echo $JSONArray; //echo for use in AJAX in index.php
?>
