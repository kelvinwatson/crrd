<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
include 'dbp.php';

$mysqli = new mysqli('oniddb.cws.oregonstate.edu', 'watsokel-db', $dbpass, 'watsokel-db');
if ($mysqli->connect_errno) {
  echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
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
      <a class="navbar-brand pull-left" href="#"><img src="images/cscLogo.jpg" style="max-width:100px; margin-top: -7px;"></a>
    </div>
    <div id="navbar" class="navbar-collapse collapse">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Home</a></li>
        <li><a href="#about">About</a></li>
        <li><a href="#contact">Contact</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Quick Links<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li class="dropdown-header">REUSE</li>
            <li><a href="#">Businesses</a></li>
            <li><a href="#">Item Categories</a></li>
            <li><a href="#">Items</a></li>
            <li role="separator" class="divider"></li>
            <li class="dropdown-header">REPAIR</li>
            <li><a href="#">Businesses</a></li>
            <li><a href="#">Item Categories</a></li>
            <li><a href="#">Items</a></li>
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
    <h3>View Reuse Categories</h3>
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
              "SELECT DISTINCT c.id, c.name FROM category c WHERE c.id!=16"))) {
              echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
            }

            if (!$stmt->execute()) {
              echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            }

            if(!$stmt->bind_result($cID, $cN)){
              echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqlii->connect_error;
            }
            while($stmt->fetch()){
              echo
              "<tr><form action=\"https://web.engr.oregonstate.edu/~watsokel/crrd/wmi/reusecategories.php#view-items\" method=\"post\">
              <td><input class=\"btn btn-success\" type=\"submit\" value=\"view\">
              <input type=\"hidden\" name=\"reuse-category-id\" value=\"".$cID."\"></td>
              <td>".$cN."<input type=\"hidden\" name=\"reuse-category-name\" value=\"".$cN."\"></td>
              <input type=\"hidden\" name=\"user-action\" value=\"view-items\"></form></tr>";
            }
            $stmt->close();
            ?>
          </tbody>
      </table>
    </div>

  </div> <!--END VIEW TABLE ROW-->

  <div id="view-items"></div>
  <div class="row"><!--VIEW ROW-->

<?php if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['user-action'])):?>
  <?php if($_POST['user-action']=='view-items'):?>
    <h3 style="padding-top: 70px;">Items Within
      <?php echo htmlspecialchars($_POST['reuse-category-name'])?>  Category</h3>

    <ul>
      <?php
      $cID = $_POST['reuse-category-id'];

      if (!($stmt = $mysqli->prepare(
        "SELECT DISTINCT i.id, i.name FROM item i
        INNER JOIN business_category_item bci ON bci.iid=i.id
        INNER JOIN category c ON c.id=bci.cid
        WHERE c.id=?"))) {
        echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
      }

      if (!$stmt->bind_param("i", $cID)) {
          echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
      }

      if (!$stmt->execute()) {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
      }

      if(!$stmt->bind_result($iID, $iN)){
        echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqlii->connect_error;
      }

      while($stmt->fetch()){
        echo
        "<li>".$iN."</li>";
      }

      $stmt->close();
      ?>
    </ul>
  <?php endif; ?>
 <?php endif; ?>

  </div><!--END VIEW ROW-->

</div><!--END CONTAINER -->

<!--SCRIPTS-->
<script src="js/toast.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?"></script>

</body>
</html>
