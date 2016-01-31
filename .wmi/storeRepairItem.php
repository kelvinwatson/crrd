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

$action = $_POST['action'];
$itemName = $_POST['item_name'];
//$itemID = $_POST['item_id'];


/* HANDLE EDIT OR ADD */
if($_SERVER['REQUEST_METHOD']==='POST'){ //Retrieve repair businesses based on repair item
  
  /* VALIDATE INPUT */
  if(!validatePOSTInput()){ //detects empty input
    return;
  }
  
  
  $obj = new stdClass(); //for JSON output
  
  if($action == 'edit') { //user wants to edit existing repair item
    $itemName = $_POST['item_name'];
    $itemID = $_POST['item_id'];
    //$obj = new stdClass(); //for JSON output
    
    if (!($stmt = $mysqli->prepare("UPDATE item i SET i.name='".$itemName."' 
      WHERE i.id='".$itemID."'"))) {
		  echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		}
    $obj->httpResponseCode = 200;
    $obj->response = "prepare passed";
    $obj->errorMessage = 'Validated Input';
    echo json_encode($obj);
    return;
		/*if (!$stmt->execute()) {
			echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
		}

		if(!$stmt->bind_result($bN,$bStr,$bC,$bSta,$bZ,$bLat,$bLng,$iN)){
		  echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqlii->connect_error;
		}*/

    
    
    //$obj->httpResponseCode = 200;
    //$obj->response = "itemName=".$itemName;
    //$obj->errorMessage = 'Validated Input';
    return; 
  } else if ($action =='add'){
    
  }
}
  
/* METHODS */      
function validatePOSTInput(){
  $obj = new stdClass(); //for JSON output
  if(isset($_POST['action'])){  
    if($_POST['action']==='edit'){
      if(isset($_POST['item_name'])){
          if($_POST['item_name']==''){
            $obj->httpResponseCode = 400;
            $obj->response = 'editFailure';
            $obj->errorMessage = 'Missing item name.';
            echo json_encode($obj); 
            return False;
          }
      } else {
            $obj->httpResponseCode = 400;
            $obj->response = 'editFailure';
            $obj->errorMessage = 'Item name is not set.';
            echo json_encode($obj); 
            return False;
      }      
    }else if ($_POST['action']=='add'){
      if(isset($_POST['item_name'])){
          if($_POST['item_name']==''){
            $obj->httpResponseCode = 400;
            $obj->response = 'addFailure';
            $obj->errorMessage = 'Missing item name.';
            echo json_encode($obj); 
            return False;
          }
      } else {
        $obj->httpResponseCode = 400;
        $obj->response = 'addFailure';
        $obj->errorMessage = 'Item name is not set.';
        echo json_encode($obj); 
        return False;
      }
    }  
  } else{
    $obj->httpResponseCode = 400;
    $obj->response = 'failure';
    $obj->errorMessage = 'Missing action.';
    echo json_encode($obj); 
    return False;
  }
  return True;
}
        
?>
