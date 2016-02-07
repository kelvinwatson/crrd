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
if($latitude==''){
  $latitude=null;
}
$longitude = $_POST['long'];
if($longitude==''){
  $longitude=null;
}
$obj = new stdClass();

if ($action == 'edit'){
  $businessId = $_POST['business_id'];
  if (!($stmt = $mysqli->prepare("UPDATE business SET name=?, street=?, city=?, state=?, zipcode=?, phone=?, website=?, latitude=?, longitude=? WHERE id=?"))) {
    $obj->httpResponseCode = 400;
    $obj->response = "editFailure";
    $obj->errorMessage = 'Prepare failed.';
    echo json_encode($obj);
    return;
  }

  if (!$stmt->bind_param("ssssissddi", $businessName, $street, $city, $state, $zipcode, $phone, $website, $latitude, $longitude, $businessId)) {
    $obj->httpResponseCode = 400;
    $obj->response = "editFailure";
    $obj->errorMessage = 'Bind failed.';
    echo json_encode($obj);
    return;    
  }

  if (!$stmt->execute()) {
    $obj->httpResponseCode = 400;
    $obj->response = "editFailure";
    $obj->errorMessage = 'Execute failed.';
    echo json_encode($obj);
    return;   
  }
    
  $obj->httpResponseCode = 200;
  $obj->response = "editSuccess";
  $obj->errorMessage = 'Edit item successful.';
  echo json_encode($obj);
  return;
  
} else if ($action == 'add') {
  $type = 'Repair';
  if (!($stmt = $mysqli->prepare("INSERT INTO business(name, street, city, state, zipcode, phone, website, type, latitude, longitude) VALUES (?,?,?,?,?,?,?,?,?,?)"))){
    $obj->httpResponseCode = 400;
    $obj->response = "addFailure";
    $obj->errorMessage = 'Prepare failed.';
    echo json_encode($obj);
    return;
  }
  
  if (!$stmt->bind_param("ssssisssdd", $businessName, $street, $city, $state, $zipcode, $phone, $website, $type, $latitude, $longitude)) {
    $obj->httpResponseCode = 400;
    $obj->response = "addFailure";
    $obj->errorMessage = 'Bind failed.';
    echo json_encode($obj);
    return;   
  }

  
  if (!$stmt->execute()) {
    $obj->httpResponseCode = 400;
    $obj->response = "addFailure";
    $obj->errorMessage = 'Execute failed.';
    echo json_encode($obj);
    return;
  }
  
  $obj->httpResponseCode = 200;
  $obj->response = "addSuccess";
  $obj->errorMessage = 'Add item successful.';
  echo json_encode($obj);
  return;
}
?>
