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



/* HANDLE EDIT OR ADD */
if($_SERVER['REQUEST_METHOD']==='POST'){ //Retrieve repair businesses based on repair item
  
  /* VALIDATE INPUT */
  if(!validatePOSTInput()){ //detects empty input
    return;
  }
  
  $action = $_POST['action'];
  $itemName = $_POST['item_name'];
  
  $obj = new stdClass(); //for JSON output
  
  if($action == 'edit') { //user wants to edit existing repair item
    $itemId = $_POST['item_id'];
    
    if (!($stmt = $mysqli->prepare("UPDATE item i SET i.name=? WHERE i.id=?"))) {
		  $obj->httpResponseCode = 400;
      $obj->response = "editFailure";
      $obj->errorMessage = "Prepare failed (0):".$mysqli->error;
      echo json_encode($obj);
      return;
		}

    if (!$stmt->bind_param("si", $itemName, $itemId)) {
      $obj->httpResponseCode = 400;
      $obj->response = "editFailure";
      $obj->errorMessage = "Binding parameters failed (0):".$mysqli->error;
      echo json_encode($obj);
      return;
    }

		if (!$stmt->execute()) {
			$obj->httpResponseCode = 400;
      $obj->response = "editFailure";
      $obj->errorMessage = "Execute failed (0):".$mysqli->error;
      echo json_encode($obj);
      return;
		}
    
    $obj->httpResponseCode = 200;
    $obj->response = "editSuccess";
    $obj->errorMessage = 'Edit item successful.';
    echo json_encode($obj);
    return;
    
  } else if ($action =='add'){
    $itemName = $_POST['item_name'];
    
    /* Insert item */
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

    if (!$stmt->execute()) {
    }
      
    /* Immediately query for item ID of item inserted */
    
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
    
    if (!($stmt = $mysqli->prepare("INSERT INTO business_category_item(bid,cid,iid) VALUES (86,16,?)"))){
      $obj->httpResponseCode = 400;
      $obj->response = "addFailure";
      $obj->errorMessage = "Duplicate item.";
      echo json_encode($obj);
      return;
    }
    
    if (!$stmt->bind_param("i", $obj->itemID)) {
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
