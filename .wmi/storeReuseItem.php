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

error_log(print_r($_POST,true),3,"/nfs/stak/students/w/watsokel/public_html/crrd/wmi/err.log");

//DEBUG
// $obj = new stdClass(); //for JSON output
// $obj->httpResponseCode = 200;
// $obj->response = "addSuccess";
// $obj->errorMessage = 'Successfully inserted into item and business_category_item tables';
// echo json_encode($obj);
// return;

if($_SERVER['REQUEST_METHOD']==='POST'){ //Retrieve repair businesses based on repair item

  $action = $_POST['action'];
  $categoryId = $_POST['category_id'];
  $itemName = $_POST['item_name'];  
  $obj = new stdClass(); //for JSON output
  
  
  if ($action =='add'){
    if (!($stmt = $mysqli->prepare("INSERT INTO item(name) VALUES (?)"))){
      $obj->httpResponseCode = 400;
      $obj->response = "addFailure";
      $obj->errorMessage = "Prepare failed (1):".$mysqli->error;
      echo json_encode($obj);
      return;
    }
  
  if (!$stmt->bind_param("s", $itemName)) {
      $obj->httpResponseCode = 400;
      $obj->response = "addFailure";
      $obj->errorMessage = "Binding parameters failed (1):".$mysqli->error;
      echo json_encode($obj);
      return;
    }

    if (!$stmt->execute()) { //execute regardless of failure
    }
      
    // Immediately query for item ID of item inserted   
    if (!($stmt = $mysqli->prepare("SELECT i.id FROM item i WHERE i.name='".$itemName."'"))){
      $obj->httpResponseCode = 400;
      $obj->response = "addFailure";
      $obj->errorMessage = "Prepare failed (2):".$mysqli->error;
      echo json_encode($obj);
      return;
    }

    if (!$stmt->execute()) {
      $obj->httpResponseCode = 400;
      $obj->response = "addFailure";
      $obj->errorMessage = "Execute failed (2):".$mysqli->error;
      echo json_encode($obj);
      return;
		}

    $iID = NULL;
    
		if(!$stmt->bind_result($iID)){
      $obj->httpResponseCode = 400;
      $obj->response = "addFailure";
      $obj->errorMessage = "Bind failed (2):".$mysqli->error;
      echo json_encode($obj);
      return;
		}
    
    while($stmt->fetch()){
		  $obj->itemID = $iID;
		}
    
    if (!($stmt = $mysqli->prepare("INSERT INTO business_category_item(bid,cid,iid) VALUES (86,?,?)"))){
      $obj->httpResponseCode = 400;
      $obj->response = "addFailure";
      $obj->errorMessage = "Duplicate item.";
      echo json_encode($obj);
      return;
    }
    
    if (!$stmt->bind_param("ii", $categoryId, $obj->itemID)) {
      $obj->httpResponseCode = 400;
      $obj->response = "addFailure";
      $obj->errorMessage ="Duplicate item.";
      echo json_encode($obj);
      return;
    }

    if (!$stmt->execute()) {
      $obj->httpResponseCode = 400;
      $obj->response = "addFailure";
      $obj->errorMessage = "Duplicate item.";
      echo json_encode($obj);
      return;
    }
   
    $obj->httpResponseCode = 200;
    $obj->response = "addSuccess";
    $obj->errorMessage = 'Successfully inserted into item and business_category_item tables';
    echo json_encode($obj);
    return;
    
  } else{
    $obj->httpResponseCode = 400;
    $obj->response = "invalidAction";
    $obj->errorMessage = 'Add item unsuccessful.';
    echo json_encode($obj);
    return;
  }
  $stmt->close();
  return;
}
        
?>
