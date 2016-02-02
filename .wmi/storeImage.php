<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
header('Content-Type: application/json');
include 'dbp.php';

/* CONNECT TO DATABASE */
$mysqli = new mysqli('oniddb.cws.oregonstate.edu', 'watsokel-db', $dbpass, 'watsokel-db');
if ($mysqli->connect_errno) {
  echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
} 
?>

/*
<?php
$fileName = $_FILES["image1"]["name"]; // The file name
$fileTmpLoc = $_FILES["image1"]["tmp_name"];
$fileType = $_FILES["image1"]["type"];
$fileSize = $_FILES["image1"]["size"];
$fileErrorMsg = $_FILES["image1"]["error"];
if (!$fileTmpLoc)
    {
    if file not chosen echo "ERROR: Please browse for a file before clicking
    the upload button."; exit(); }
if(move_uploaded_file($fileTmpLoc, "test_uploads/$fileName"))
                   { echo "$fileName upload is complete"; }
                    else
                   { echo "move_uploaded_file function failed"; }
?>*/