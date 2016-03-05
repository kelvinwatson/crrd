<?php session_start();
error_reporting(E_ALL);
ini_set('display_errors',1);
header('Content-Type: application/json');
include 'dbp.php';
//require 'password_compat/lib/password.php';

/* CONNECT TO DATABASE */
$mysqli = new mysqli($hostname, $dbuser, $dbpass, $dbname);
if ($mysqli->connect_errno) {
  echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

$username = $_POST['userName'];
$plainTextPassword = $_POST['userPassword'];

$obj = new stdClass(); //for JSON output
  
if (!($stmt = $mysqli->prepare("SELECT * FROM users WHERE username=?"))){
  $obj->httpResponseCode = 400;
  $obj->response = "authenticateFailure";
  $obj->errorMessage = "Prepare failed:".$mysqli->error;
  echo json_encode($obj);
  return;
}

if (!$stmt->bind_param("s", $username)) {
  $obj->httpResponseCode = 400;
  $obj->response = "authenticateFailure";
  $obj->errorMessage = "Bind parameters failed:".$mysqli->error;
  echo json_encode($obj);
  return;
}

if (!$stmt->execute()) {
  $obj->httpResponseCode = 400;
  $obj->response = "authenticateFailure";
  $obj->errorMessage = "Execute failed:".$mysqli->error;
  echo json_encode($obj);
  return;
}

if(!$stmt->bind_result($uId,$uName,$uEmail,$uPassword,$uSuperUser)){
  $obj->httpResponseCode = 400;
  $obj->response = "authenticateFailure";
  $obj->errorMessage = "Bind result failed:".$mysqli->error;
  echo json_encode($obj);
  return;
}

$retrievedUserId=$retrievedUsername=$retrievedEmail=$hashedPassword=$isSuperUser=null;

while($stmt->fetch()){
  $retrievedUserId = $uId;
  $retrievedUsername = $uName;
  $retrievedEmail = $uEmail;
  $hashedPassword = $uPassword;
  $isSuperUser = $uSuperUser;
}

$isValid = password_verify($plainTextPassword, $hashedPassword);

if($isValid==true){
  $_SESSION['loggedIn']=true;
  $_SESSION['username']=$retrievedUsername;
  $_SESSION['userEmail']=$retrievedEmail;
  if($isSuperUser){
    $_SESSION['superUser']=true;
  } else{
    $_SESSION['superUser']=false;  
  }
  $obj->httpResponseCode = 200;
  $obj->response = "authenticateSuccess";
  $obj->errorMessage = "User found!";
  echo json_encode($obj);  
}else{
  $obj->httpResponseCode = 400;
  $obj->response = "authenticateFailure";
  $obj->errorMessage = "Password does not match.";
  echo json_encode($obj);  
}

$stmt->close();

return;
  
?>