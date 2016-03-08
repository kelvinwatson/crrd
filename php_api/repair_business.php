<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
header('Content-Type: application/json');
include 'dbp.php';

$mysqli = new mysqli('oniddb.cws.oregonstate.edu', 'watsokel-db', $dbpass, 'watsokel-db');

if ($mysqli->connect_errno) {
  echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqlii
->connect_error;
}

if (!$mysqli->set_charset("utf8")) {
	$obj->http_response_code = 400;
	$obj->error_description = 'Error loading character set utf8.';
	echo json_encode($obj);
	return;
}

if($_SERVER['REQUEST_METHOD']==='GET'){	//Retrieve repair businesses based on repair item
  $obj = new stdClass();
	if(!isset($_GET['repairBusiness'])){
		$obj->http_response_code = 400;
		$obj->error_description = 'A repair business was not selected.';
		echo json_encode($obj);
		return;
	} else{
		$businessName=htmlspecialchars($_GET['repairBusiness']);

    $obj->businessName = $businessName;

		if (!($stmt = $mysqli->prepare("SELECT b.name, b.street, b.city, b.state, b.zipcode, b.phone, b.hours, b.website, b.latitude, b.longitude, b.info FROM business b
		  WHERE b.name=?"))) {
      $obj->http_response_code = 400;
  		$obj->error_description = 'Prepare failed.';
  		echo json_encode($obj);
		}

    if (!$stmt->bind_param("s", $businessName)) {
      $obj->http_response_code = 400;
  		$obj->error_description = 'Bind param failed.';
  		echo json_encode($obj);
    }

		if (!$stmt->execute()) {
      $obj->http_response_code = 400;
  		$obj->error_description = 'Execute failed.';
  		echo json_encode($obj);
		}

		if(!$stmt->bind_result($bN,$bStr,$bC,$bSta,$bZ,$bP,$bH,$bW,$bLat,$bLng,$bI)){
      $obj->http_response_code = 400;
  		$obj->error_description = 'Bind result failed.';
  		echo json_encode($obj);
		}

		while($stmt->fetch()){
		  $obj->type = 'repairBusiness';
		  $obj->name = $bN;
		  $obj->street = $bStr;
		  $obj->city = $bC;
		  $obj->state = $bSta;
		  $obj->zip = $bZ;
		  $obj->phone = $bP;
      $obj->hours = $bH;
		  $obj->website = $bW;
		  $obj->lat = $bLat;
		  $obj->lng = $bLng;
      $obj->info = $bI;
		}

		if(!empty($obj)){
			echo json_encode($obj);
		} else{
			$obj->http_response_code = 400;
			$obj->error_description = "No repair business retrieved. The repair business may not exist, or there may be no businesses associated with that repair item.";
			echo json_encode($obj);
		}
		$stmt->close();
	}
}

?>
