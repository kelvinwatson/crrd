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
$itemIdsChecked = json_decode($_POST['itemIdsChecked'],TRUE);
$itemIdsNotChecked = json_decode($_POST['itemIdsNotChecked'],TRUE);

//debug statements
//error_log(gettype($itemIdsChecked),3,"/nfs/stak/students/w/watsokel/public_html/crrd/wmi/err.log");
//error_log(print_r($itemIdsChecked,TRUE),3,"/nfs/stak/students/w/watsokel/public_html/crrd/wmi/err.log");
//error_log(gettype($itemIdsNotChecked),3,"/nfs/stak/students/w/watsokel/public_html/crrd/wmi/err.log");
//error_log(print_r($itemIdsNotChecked,TRUE),3,"/nfs/stak/students/w/watsokel/public_html/crrd/wmi/err.log");

$obj = new stdClass();

/*$obj->httpResponseCode = 200;
$obj->response = "editSuccess";
$obj->itemIdsChecked = $itemIdsChecked;
$obj->itemIdsNotChecked = $itemIdsNotChecked;
$obj->errorMessage = 'YAY.';
echo json_encode($obj);
return;*/


if ($action == 'edit'){
  $businessId = $_POST['business_id'];

  //Update demographics

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

  $stmt->close();

  
  //Add repair items for checked items
  $stmtBCI=null;
  if (!($stmtBCI = $mysqli->prepare("INSERT INTO business_category_item(bid,cid,iid) VALUES(?,16,?)"))) {
    $obj->httpResponseCode = 400;
    $obj->response = "editFailure";
    $obj->errorMessage = 'Prepare for add checked item failed.';
    echo json_encode($obj);
    return;
  }
  error_log("prep2 ok",3,"/nfs/stak/students/w/watsokel/public_html/crrd/wmi/err.log");

  for ($i=0; $i<count($itemIdsChecked); ++$i) {
    $itemId = $itemIdsChecked[$i];
    $categoryId = 16;
    //error_log("itemId=".$itemId,3,"/nfs/stak/students/w/watsokel/public_html/crrd/wmi/err.log");
    //error_log("businessId=".$businessId,3,"/nfs/stak/students/w/watsokel/public_html/crrd/wmi/err.log");
    try{
      $stmtBCI->bind_param("ii", $businessId, $itemId);
      error_log("pass1",3,"/nfs/stak/students/w/watsokel/public_html/crrd/wmi/err.log");
      $stmtBCI->execute(); //insert regardless and ignore errors
      error_log("pass2",3,"/nfs/stak/students/w/watsokel/public_html/crrd/wmi/err.log");
    } catch( Exception $e ){
      error_log("exception!",3,"/nfs/stak/students/w/watsokel/public_html/crrd/wmi/err.log");  
    }

  }

  //$stmtBCI->close();

  //Remove repair items for unchecked items
  $stmtBCIDel=null;
  if (!($stmtBCIDel = $mysqli->prepare("DELETE FROM business_category_item WHERE bid=? AND cid=16 AND iid=?"))) {
    $obj->httpResponseCode = 400;
    $obj->response = "editFailure";
    $obj->errorMessage = 'Prepare for delete unchecked item failed.';
    echo json_encode($obj);
    return;
  }
  error_log("prep3 ok",3,"/nfs/stak/students/w/watsokel/public_html/crrd/wmi/err.log");

  for ($j=0; $j<count($itemIdsNotChecked); ++$j) {
    $itemId = $itemIdsNotChecked[$j];
    $categoryId = 16;
    //error_log("itemId=".$itemId,3,"/nfs/stak/students/w/watsokel/public_html/crrd/wmi/err.log");
    //error_log("businessId=".$businessId,3,"/nfs/stak/students/w/watsokel/public_html/crrd/wmi/err.log");
    try{
      $stmtBCIDel->bind_param("ii", $businessId, $itemId);
      error_log("pass3",3,"/nfs/stak/students/w/watsokel/public_html/crrd/wmi/err.log");
      $stmtBCIDel->execute(); //insert regardless and ignore errors
      error_log("pass42",3,"/nfs/stak/students/w/watsokel/public_html/crrd/wmi/err.log");
    } catch( Exception $e ){
      error_log("exception!!",3,"/nfs/stak/students/w/watsokel/public_html/crrd/wmi/err.log");  
    }
  }
  
  $obj->httpResponseCode = 200;
  $obj->response = "editSuccess";
  $obj->errorMessage = 'Edit business and item(s) successful.';
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
