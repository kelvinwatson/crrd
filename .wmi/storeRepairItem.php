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
    $itemId = $_POST['item_id'];
    
    if (!($stmt = $mysqli->prepare("UPDATE item i SET i.name=? WHERE i.id=?"))) {
		  echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		}

    if (!$stmt->bind_param("si", $itemName, $itemId)) {
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
    
  } else if ($action =='add'){

    $obj->httpResponseCode = 200;
    $obj->response = "addSuccess";
    $obj->errorMessage = 'Add item successful.';
    echo json_encode($obj);
    return;
  } else{
    $obj->httpResponseCode = 400;
    $obj->response = "wrongAction";
    $obj->errorMessage = 'Add item successful.';
    echo json_encode($obj);
    return;
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
