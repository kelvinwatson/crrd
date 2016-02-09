<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
header('Content-Type: application/json');
include 'dbp.php';

$arr = array();

$mysqli = new mysqli('oniddb.cws.oregonstate.edu', 'watsokel-db', $dbpass, 'watsokel-db');

if ($mysqli->connect_errno) {
  echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqlii
->connect_error;
}

if($_SERVER['REQUEST_METHOD']==='GET'){	//Retrieve repair businesses based on repair item
	if(!isset($_GET['reuseCategory'])){
		$obj = new stdClass();
		$obj->http_response_code = 400;
		$obj->error_description = 'A reuse category was not selected.';
		echo json_encode($obj);
	} else{
		$category=htmlspecialchars($_GET['reuseCategory']);
  
		if (!($stmt = $mysqli->prepare("SELECT DISTINCT i.url, i.name FROM item i
		  INNER JOIN business_category_item bci ON bci.iid=i.id
		  INNER JOIN category c ON c.id=bci.cid
		  WHERE c.name=?"))) {
		  $obj->http_response_code = 400;
  		$obj->error_description = 'Prepare failed.';
  		echo json_encode($obj);
    }

    if (!$stmt->bind_param("s", $category)) {
      $obj->http_response_code = 400;
  		$obj->error_description = 'Bind param failed.';
  		echo json_encode($obj);
    }

		if (!$stmt->execute()) {
		  $obj->http_response_code = 400;
  		$obj->error_description = 'Execute failed.';
  		echo json_encode($obj);		
    }

		if(!$stmt->bind_result($itemURL,$itemName)){
		  $obj->http_response_code = 400;
  		$obj->error_description = 'Bind result failed.';
  		echo json_encode($obj);		
    }

		$i=0;

		while($stmt->fetch()){
      $obj = new stdClass();
		  $obj->type = 'reuseItem';
		  $obj->url = $itemURL;
		  $obj->name = $itemName;
		  $arr[$i++] = $obj;
		}
		if(!empty($arr)){
			echo json_encode($arr);
		} else{
			$obj = new stdClass();
			$obj->http_response_code = 400;
			$obj->error_description = "No reuse items retrieved. The reuse item may not exist, or there may be no items associated with that reuse category.";
			echo json_encode($obj);
		}
		$stmt->close();
	}
}

?>
