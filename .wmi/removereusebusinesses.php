<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
include 'dbp.php';

$mysqli = new mysqli('oniddb.cws.oregonstate.edu', 'watsokel-db', $dbpass, 'watsokel-db');
if ($mysqli->connect_errno) {
  echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['user-action'])){
  if($_POST['user-action']=='delete-business'){
      $bID = htmlspecialchars($_POST['reuse-business-id']);
      removeBusiness($bID);
  }
}

function removeBusiness($bID){
  global $mysqli;
  if (!($stmt = $mysqli->prepare(
    "DELETE FROM business WHERE business.id=?"))) {
    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
  }
  if (!$stmt->bind_param("i", $bID)) {
    echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
  }
  if (!$stmt->execute()) {
    echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
  }
  $stmt->close();   
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel= "shortcut icon" media="all" type="image/x-icon" href="https://web.engr.oregonstate.edu/~watsokel/crrd/wmi/favicon.ico" />
  <link href="css/bootstrap.css" rel="stylesheet">
  <link href="css/navbar-fixed-top.css" rel="stylesheet">
  <link href="css/toast.css" rel="stylesheet">
  <title>Admin Portal: Corvallis Reuse and Repair Directory</title>
</head>
<body>
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand pull-left" href="main.php"><img src="images/cscLogo.jpg" style="max-width:100px; margin-top: -7px;"></a>
    </div>
    <div id="navbar" class="navbar-collapse collapse">
      <ul class="nav navbar-nav">
        <li class="active"><a href="main.php">Home</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Quick Links<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li class="dropdown-header">REUSE</li>
            <li><a href="reusebusinesses.php">Businesses</a></li>
            <li><a href="reusecategories.php">Item Categories</a></li>
            <li><a href="reuseitems.php">Items</a></li>
            <li role="separator" class="divider"></li>
            <li class="dropdown-header">REPAIR</li>
            <li><a href="repairbusinesses.php">Businesses</a></li>
            <li><a href="repairitems.php">Items</a></li>
            <li role="separator" class="divider"></li>
            <li class="dropdown-header">RECYCLE</li>
            <li><a href="#">Links</a></li>
          </ul>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Logged In<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#"><span class="glyphicon glyphicon-asterisk"></span>  Logged In</a></li>
            <li><a href="#"><span class="glyphicon glyphicon-user"></span>  Profile</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#"><span class="glyphicon glyphicon-off"></span>  Logout</a></li>
          </ul>
        </li>
      </ul>
    </div><!--/.nav-collapse -->
  </div>
</nav>

<div class="container">
  <div class="row">
    <h1>Administrator Portal</h1>
  </div>

  <div class="row"> <!--START VIEW TABLE ROW -->
    <h3>Remove Reuse Business(es)</h3>
    <div class="table-responsive">
      <table class="table">
        <thead>
            <tr>
              <th>View Items</th>
              <th>Category Name</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if (!($stmt = $mysqli->prepare(
          "SELECT b.id, b.name FROM business b WHERE b.type='Reuse'"))) {
          echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
        }
        if (!$stmt->execute()) {
          echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        if(!$stmt->bind_result($bID, $bN)){
          echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqlii->connect_error;
        }
        while($stmt->fetch()){
          echo
          "<tr><form action=\"https://web.engr.oregonstate.edu/~watsokel/crrd/wmi/removereusebusinesses.php?deleteDone=True\" method=\"post\">
          <td><input data-toggle=\"modal\" data-target=\"#deleteBusinessModal".$bID."\" class=\"btn btn-danger\" value=\"delete\" type=\"button\">
          <input type=\"hidden\" name=\"reuse-business-id\" value=\"".$bID."\"></td>
          <td>".$bN."<input type=\"hidden\" name=\"reuse-business-name\" value=\"".$bN."\"></td>
          
          <div class=\"modal fade\" id=\"deleteBusinessModal".$bID."\"  tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\">
            <div class=\"modal-dialog\">

              <div class=\"modal-content\">
                <div class=\"modal-header\">
                  <button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>
                  <h4 class=\"modal-title\">Confirm Delete Business</h4>
                </div>
                <div class=\"modal-body\">
                  <p>You are about to remove the business: <strong>\"$bN\"</strong>. Deletion is permanent. Are you sure you want to proceed?</p>
                </div>
                <div class=\"modal-footer\">
                  <button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Close</button>
                  <button type=\"submit\" class=\"btn btn-danger\">Delete</button>
                </div>
              </div>

            </div>
          </div>
          <input type=\"hidden\" name=\"user-action\" value=\"delete-business\"></form></tr>";
        }
        $stmt->close();
        ?>
        </tbody>
      </table>
    </div>
  </div> <!--END VIEW TABLE ROW-->
</div><!--END CONTAINER -->

<!--SCRIPTS-->
<script src="js/toast.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script>
Toast.defaults.width='600px';
Toast.defaults.displayDuration=7000;
window.onload = function(){
  var queryStr = window.location.search;
  if(queryStr=='?deleteDone=True'){
    Toast.success('Delete Successful!', 'Delete Confirmation');
  } else if (queryStr=='?deleteDone=False') {
    Toast.error('An error occurred, and the delete was not processed.', 'Delete Status');
  }
}
</script>
</body>
</html>
