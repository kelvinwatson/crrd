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
  $categoryName = $_POST['category_name'];
  
  $obj = new stdClass(); //for JSON output
  
  if ($action =='add'){
    $categoryName = $_POST['category_name'];
    
    /* Insert item */
    if (!($stmt = $mysqli->prepare("INSERT INTO category(name) VALUES (?)"))){
      $obj->httpResponseCode = 400;
      $obj->response = "addFailure";
      $obj->errorMessage = "Prepare failed (1):".$mysqli->error;
      echo json_encode($obj);
      return;
    }
    
    if (!$stmt->bind_param("s", $categoryName)) {
      $obj->httpResponseCode = 400;
      $obj->response = "addFailure";
      $obj->errorMessage = "Binding parameters failed (1):".$mysqli->error;
      echo json_encode($obj);
      return;
    }

    if (!$stmt->execute()) {
      $obj->httpResponseCode = 400;
      $obj->response = "addFailure";
      $obj->errorMessage = "Execute query failed (1):".$mysqli->error;
      echo json_encode($obj);
      return;
    }
      
    /* Immediately query for item ID of item inserted */
    $obj->httpResponseCode = 200;
    $obj->response = "addSuccess";
    $obj->errorMessage = 'Add category successful.';
    echo json_encode($obj);
    return;
    } else{
    $obj->httpResponseCode = 400;
    $obj->response = "invalidAction";
    $obj->errorMessage = 'Add category unsuccessful.';
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
    if ($_POST['action']=='add'){
      if(isset($_POST['category_name'])){
          if($_POST['category_name']==''){
            $obj->httpResponseCode = 400;
            $obj->response = 'addFailure';
            $obj->errorMessage = 'Missing category name.';
            echo json_encode($obj); 
            return False;
          }
      } else {
        $obj->httpResponseCode = 400;
        $obj->response = 'addFailure';
        $obj->errorMessage = 'Category name is not set.';
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
