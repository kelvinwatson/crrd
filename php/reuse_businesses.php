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
	if(!isset($_GET['reuseItem'])){
		$obj = new stdClass();
		$obj->http_response_code = 400;
		$obj->error_description = 'A reuse item was not selected.';
		echo json_encode($obj);
	} else{
		$itemName=htmlspecialchars($_GET['reuseItem']);

		if (!($stmt = $mysqli->prepare("SELECT DISTINCT b.name, b.street, b.city, b.state, b.zipcode, b.latitude, b.longitude FROM business b
		  INNER JOIN business_category_item bci ON bci.bid=b.id
		  INNER JOIN item i ON i.id=bci.iid
		  WHERE b.type='Reuse' AND i.name=? ORDER BY b.name ASC"))) {
		  echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		}

    if (!$stmt->bind_param("s", $itemName)) {
      $obj->http_response_code = 400;
  		$obj->error_description = 'Bind param failed.';
  		echo json_encode($obj);
    }

		if (!$stmt->execute()) {
      $obj->http_response_code = 400;
  		$obj->error_description = 'Execute failed.';
  		echo json_encode($obj);
		}

		if(!$stmt->bind_result($bN,$bStr,$bC,$bSta,$bZ,$bLat,$bLng)){
      $obj->http_response_code = 400;
  		$obj->error_description = 'Bind result failed.';
  		echo json_encode($obj);
		}

		$i=0;

		while($stmt->fetch()){
      if($bN=='generic_repair_business'){
        continue;
      }
      $obj = new stdClass();
		  $obj->type = 'reuseBusiness';
		  $obj->name = $bN;
		  $obj->street = $bStr;
		  $obj->city = $bC;
		  $obj->state = $bSta;
		  $obj->zip = $bZ;
		  $obj->lat = $bLat;
		  $obj->lng = $bLng;
		  $arr[$i++] = $obj;
		}
		if(!empty($arr)){
			echo json_encode($arr);
		} else{
			$obj = new stdClass();
			$obj->http_response_code = 400;
			$obj->error_description = "No reuse businesses retrieved.";
			echo json_encode($obj);
		}
		$stmt->close();
	}
}
?>
