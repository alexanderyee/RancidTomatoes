<?php
require_once "./model.php";

if ( !isset($_FILES['file']['error']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK )
  die( "Upload failed with error" );

if ( !isPNG( $_FILES['file']['tmp_name']) )
  die( "Cannot upload the file as it is not a PNG file" );

$id = addToFileTable( $_FILES['file'] );
move_uploaded_file( $_FILES['file']['tmp_file'] , "uploads/{$id}.png" );

?>
