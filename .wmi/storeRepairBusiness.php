<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
header('Content-Type: application/json');
include 'dbp.php';

$arr = array();

$mysqli = new mysqli('oniddb.cws.oregonstate.edu', 'watsokel-db', $dbpass, 'watsokel-db');

if ($mysqli->connect_errno) {
  echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
} 

$action = $_POST['action'];
$businessName = $_POST['business_name'];
$street = $_POST['street'];
$city = $_POST['city'];
$state = $_POST['state'];
$zipcode = $_POST['zipcode'];
$phone = $_POST['phone'];
$website = $_POST['website'];
$latitude = $_POST['lat'];
$longitude = $_POST['long'];
$type = repair;
$obj = new stdClass(); 
if ($action == 'edit')
{
  $businessId = $_POST['business_id'];
  if (!($stmt = $mysqli->prepare("UPDATE business SET name=?, street=?, city=?, state=?, zipcode=?, phone=?, website=?, latitude=?, longitude=? WHERE id=?"))) {
      echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }

  if (!$stmt->bind_param("ssssissddi", $businessName, $street, $city, $state, $zipcode, $phone, $website, $latitude, $longitude, $businessId)) {
        echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    }

  if (!$stmt->execute()) {
      echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    }
    
  $obj->httpResponseCode = 200;
  $obj->response = "editSuccess";
  $obj->errorMessage = 'Edit item successful.';
  echo json_encode($obj);
  return;
}
else ($action == 'add')
{
  if (!($stmt = $mysqli->prepare("INSERT INTO business(name, street, city, state, zipcode, phone, website, type, latitude, longitude) VALUES (?,?,?,?,?,?,?,?,?,?)"))){
    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
  }

  if (!$stmt->bind_param("ssssisssdd", $businessName, $street, $city, $state, $zipcode, $phone, $website, $type, $latitude, $longitude)) {
    echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
  }

  if (!$stmt->execute()) {
    echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
  }
    
  $obj->httpResponseCode = 200;
  $obj->response = "addSuccess";
  $obj->errorMessage = 'Add item successful.';
  echo json_encode($obj);
  return;
}
?>
