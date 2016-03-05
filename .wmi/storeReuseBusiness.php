<?php session_start();
error_reporting(E_ALL);
ini_set('display_errors',1);
header('Content-Type: application/json');
include 'dbp.php';
$arr = array();
$mysqli = new mysqli($hostname, $dbuser, $dbpass, $dbname);

if ($mysqli->connect_errno) {
  echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

if (!$mysqli->set_charset("utf8")) {
	$obj->http_response_code = 400;
	$obj->error_description = 'Error loading character set utf8.';
	echo json_encode($obj);		
	return;
}

$action = $_POST['action'];
$businessName = $_POST['business_name'];
$street = $_POST['street'];
$city = $_POST['city'];
$state = $_POST['state'];
$zipcode = $_POST['zipcode'];
$phone = $_POST['phone'];
$website = $_POST['website'];
$hours = $_POST['hours'];
if($hours==''){
  $hours=null;
}
$latitude = $_POST['lat'];
if($latitude==''){
  $latitude=null;
}
$longitude = $_POST['long'];
if($longitude==''){
  $longitude=null;
}
$catItemIdsChecked = json_decode($_POST['itemIdsChecked'],TRUE);
$catItemIdsNotChecked = json_decode($_POST['itemIdsNotChecked'],TRUE);

//debug statements
//error_log(print_r($_POST,true),3,"/nfs/stak/students/w/watsokel/public_html/crrd/wmi/err.log");
//error_log(gettype($catItemIdsChecked),3,"/nfs/stak/students/w/watsokel/public_html/crrd/wmi/err.log");
error_log(print_r($catItemIdsChecked,TRUE),3,"/nfs/stak/students/w/watsokel/public_html/crrd/wmi/err.log");
//error_log(gettype($catItemIdsNotChecked),3,"/nfs/stak/students/w/watsokel/public_html/crrd/wmi/err.log");
error_log(print_r($catItemIdsNotChecked,TRUE),3,"/nfs/stak/students/w/watsokel/public_html/crrd/wmi/err.log");

$obj = new stdClass();
/*$obj->httpResponseCode = 200;
$obj->response = "editSuccess";
$obj->catItemIdsChecked = $catItemIdsChecked;
$obj->catItemIdsNotChecked = $catItemIdsNotChecked;
$obj->errorMessage = 'YAY.';
echo json_encode($obj);
return;*/

if ($action == 'edit'){
  // $itemIdsNotChecked = json_decode($_POST['itemIdsNotChecked'],TRUE);
  $businessId = $_POST['business_id'];
  //Update demographics
  if (!($stmt = $mysqli->prepare("UPDATE business SET name=?, street=?, city=?, state=?, zipcode=?, phone=?, website=?, hours=?, latitude=?, longitude=? WHERE id=?"))) {
    $obj->httpResponseCode = 400;
    $obj->response = "editFailure";
    $obj->errorMessage = 'Prepare failed.';
    echo json_encode($obj);
    return;
  }
  if (!$stmt->bind_param("ssssisssddi", $businessName, $street, $city, $state, $zipcode, $phone, $website, $hours, $latitude, $longitude, $businessId)) {
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
  
  //Add reuse items for checked items
  $stmtBCI=null;
  if (!($stmtBCI = $mysqli->prepare("INSERT INTO business_category_item(bid,cid,iid) VALUES(?,?,?)"))) {
    $obj->httpResponseCode = 400;
    $obj->response = "editFailure";
    $obj->errorMessage = 'Prepare for add checked item failed.';
    echo json_encode($obj);
    return;
  }
  
  for ($i=0,$len=count($catItemIdsChecked); $i<$len; ++$i) {
    $kvarr=explode("=",$catItemIdsChecked[$i]); //explode the string into an two-element array [catId,itemId]
    $catId=(int)$kvarr[0];
    $itemId=(int)$kvarr[1];
    error_log("catId=".$catId,3,"/nfs/stak/students/w/watsokel/public_html/crrd/wmi/err.log");
    error_log("itemId=".$itemId,3,"/nfs/stak/students/w/watsokel/public_html/crrd/wmi/err.log");
    error_log("businessId=".$businessId,3,"/nfs/stak/students/w/watsokel/public_html/crrd/wmi/err.log");
    try{
      $stmtBCI->bind_param("iii", $businessId, $catId, $itemId);
      $stmtBCI->execute(); //insert regardless and ignore errors
    } catch( Exception $e ){
      error_log("exception!",3,"/nfs/stak/students/w/watsokel/public_html/crrd/wmi/err.log");  
    }
  }
  $stmtBCI->close();
  
  //Remove reuse items for unchecked items
  $stmtBCIDel=null;
  if (!($stmtBCIDel = $mysqli->prepare("DELETE FROM business_category_item WHERE bid=? AND cid=? AND iid=?"))) {
    $obj->httpResponseCode = 400;
    $obj->response = "editFailure";
    $obj->errorMessage = 'Prepare for delete unchecked item failed.';
    echo json_encode($obj);
    return;
  }
  error_log("prep3 ok",3,"/nfs/stak/students/w/watsokel/public_html/crrd/wmi/err.log");
  for ($j=0,$nLen=count($catItemIdsNotChecked); $j<$nLen; ++$j) {
    $NCkvarr=explode("=",$catItemIdsNotChecked[$j]); //explode the string into an two-element array [catId,itemId]
    $NCcatId=(int)$NCkvarr[0];
    $NCitemId=(int)$NCkvarr[1];
    error_log("NCcatId=".$NCcatId,3,"/nfs/stak/students/w/watsokel/public_html/crrd/wmi/err.log");
    error_log("NCitemId=".$NCitemId,3,"/nfs/stak/students/w/watsokel/public_html/crrd/wmi/err.log");
    error_log("businessId=".$businessId,3,"/nfs/stak/students/w/watsokel/public_html/crrd/wmi/err.log");
    try{
      $stmtBCIDel->bind_param("iii", $businessId, $NCcatId, $NCitemId);
      $stmtBCIDel->execute(); //insert regardless and ignore errors
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
  $type = 'Reuse';
  
  if (!($stmt = $mysqli->prepare("INSERT INTO business(name, street, city, state, zipcode, phone, website, hours, type, latitude, longitude) VALUES (?,?,?,?,?,?,?,?,?,?,?)"))){
    $obj->httpResponseCode = 400;
    $obj->response = "addFailure";
    $obj->errorMessage = 'Prepare failed.';
    echo json_encode($obj);
    return;
  }

  if (!$stmt->bind_param("ssssissssdd", $businessName, $street, $city, $state, $zipcode, $phone, $website, $hours, $type, $latitude, $longitude)) {
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
  
  //Retrieve business id after insertion
  
  if (!($stmtBid = $mysqli->prepare("SELECT b.id FROM business b WHERE b.name='".$businessName."'"))){
      $obj->httpResponseCode = 400;
      $obj->response = "addFailure";
      $obj->errorMessage = "Prepare failed (2):".$mysqli->error;
      echo json_encode($obj);
      return;
    }
    if (!$stmtBid->execute()) {
      $obj->httpResponseCode = 400;
      $obj->response = "addFailure";
      $obj->errorMessage = "Execute failed (2):".$mysqli->error;
      echo json_encode($obj);
      return;
		}

    $retrievedBid=NULL;
		if(!$stmtBid->bind_result($retrievedBid)){
      $obj->httpResponseCode = 400;
      $obj->response = "addFailure";
      $obj->errorMessage = "Bind failed (2):".$mysqli->error;
      echo json_encode($obj);
      return;
		}
    
    while($stmtBid->fetch()){
		  $businessId = $retrievedBid;
		}
  
  error_log("businessId just inserted",3,"/nfs/stak/students/w/watsokel/public_html/crrd/wmi/err.log");
  error_log("$businessId",3,"/nfs/stak/students/w/watsokel/public_html/crrd/wmi/err.log");
  
  $stmtBCI=null;
  if (!($stmtBCI = $mysqli->prepare("INSERT INTO business_category_item(bid,cid,iid) VALUES(?,?,?)"))) {
    $obj->httpResponseCode = 400;
    $obj->response = "addFailure";
    $obj->errorMessage = 'Prepare for add checked item failed.';
    echo json_encode($obj);
    return;
  }
  error_log("add prep ok",3,"/nfs/stak/students/w/watsokel/public_html/crrd/wmi/err.log");
  error_log(print_r($catItemIdsChecked,TRUE),3,"/nfs/stak/students/w/watsokel/public_html/crrd/wmi/err.log");
  
  for ($k=0,$aLen=count($catItemIdsChecked); $k<$aLen; ++$k) {
    $Akvarr=explode("=",$catItemIdsChecked[$k]); //explode the string into an two-element array [catId,itemId]
    $AcatId=(int)$Akvarr[0];
    $AitemId=(int)$Akvarr[1];
    error_log("catId=".$AcatId,3,"/nfs/stak/students/w/watsokel/public_html/crrd/wmi/err.log");
    error_log("itemId=".$AitemId,3,"/nfs/stak/students/w/watsokel/public_html/crrd/wmi/err.log");
    error_log("businessId=".$businessId,3,"/nfs/stak/students/w/watsokel/public_html/crrd/wmi/err.log");
    try{
      $stmtBCI->bind_param("iii", $businessId, $AcatId, $AitemId);
      $stmtBCI->execute(); //insert regardless and ignore errors
    } catch( Exception $e ){
      error_log("exception!",3,"/nfs/stak/students/w/watsokel/public_html/crrd/wmi/err.log");  
    }
  }  
  
  $obj->httpResponseCode = 200;
  $obj->response = "addSuccess";
  $obj->errorMessage = 'Add item successful.';
  echo json_encode($obj);
  return;
 }
?>