<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
header('Content-Type: application/json');
include 'dbp.php';

$itemName=$_GET['item'];

$mysqli = new mysqli('oniddb.cws.oregonstate.edu', 'watsokel-db', $dbpass, 'watsokel-db');

if ($mysqli->connect_errno) {
  echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqlii
->connect_error;
}

if (!($stmt = $mysqli->prepare("SELECT b.name, b.street, b.city, b.state, b.zipcode, b.latitude, b.longitude, i.name FROM business b
  INNER JOIN business_category_item bci ON bci.bid=b.id
  INNER JOIN item i ON i.id=bci.iid
  INNER JOIN category c ON c.id=bci.cid
  WHERE b.type='Repair' AND i.name='".$itemName."'"
  ))) {
  echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
}

if (!$stmt->execute()) {
    echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
}

if(!$stmt->bind_result($bN,$bStr,$bC,$bSta,$bZ,$bLat,$bLng,$iN)){
  echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqlii->connect_error;
}

$arr = array();
$i=0;

while($stmt->fetch()){
  $obj = new stdClass();
  $obj->type = 'repairBusiness';
  $obj->name = $bN;
  $obj->street = $bStr;
  $obj->city = $bC;
  $obj->state = $bSta;
  $obj->zip = $bZ;
  $obj->lat = $bLat;
  $obj->lng = $bLng;
  $arr[$i++] = $obj;
}

echo json_encode($arr);

$stmt->close();
?>
