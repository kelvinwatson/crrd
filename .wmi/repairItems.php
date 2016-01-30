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
  <link rel= "shortcut icon" media="all" type="image/x-icon" href="http://web.engr.oregonstate.edu/~watsokel/crrd/wmi/favicon.ico" />
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
    <h3>View/Edit Repair Businesses</h3>
    <div class="table-responsive">
      <table class="table">
        <thead>
            <tr>
              <th>Edit</th>
              <th>Item Name</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if (!($stmt = $mysqli->prepare(
              "SELECT DISTINCT i.id, i.name FROM item i
              INNER JOIN business_category_item bci ON bci.iid=i.id
              INNER JOIN category c ON c.id=bci.cid
              WHERE c.id=16"))) {
              echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
            }
            
            if (!$stmt->execute()) {
              echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            }
            
            if(!$stmt->bind_result($iID, $iN)){
              echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqlii->connect_error;
            }
            
            while($stmt->fetch()){
              echo 
              "<tr><form action=\"http://web.engr.oregonstate.edu/~watsokel/crrd/wmi/repairItems.php#edit\" method=\"post\">
              <td><input class=\"btn btn-warning\" type=\"submit\" value=\"edit\"><input type=\"hidden\" name=\"repair-item-id\" value=\"".$iID."\"></td>
              <td>".$iN."<input type=\"hidden\" name=\"repair-item-name\" value=\"".$iN."\"></td>
              <input type=\"hidden\" name=\"user-action\" value=\"edit-item\"></form></tr>";              
            }
            $stmt->close();
            ?>
          </tbody>
      </table>
    </div>
    
  </div> <!--END VIEW TABLE ROW-->

  <div id="edit"></div>
  <div class="row"><!--EDIT ROW-->

<?php if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['user-action'])):?> 
  <?php if($_POST['user-action']=='edit-item'):?>
    <h3 style="padding-top: 70px;">Edit Repair Item</h3>
    <form class="form-horizontal" action="/">
      
      <div class="form-group">
      <label for="bName" class="col-sm-2 control-label">Repair Item</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="bName" value="<?php echo htmlspecialchars($_POST['repair-item-name']); ?>">
      </div>
      </div>
      
    <div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
        <input type="hidden" id="bId" value="<?php echo htmlspecialchars($_POST['repair-item-id']); ?>">
        <button type="submit" class="btn btn-primary" onclick="codeAddress('edit'); return false;">Confirm Edit</button>
      </div>
    </div>
    </form>
  <?php endif; ?>
 <?php endif; ?>

  </div><!--END EDIT ROW-->
  
  
  <div id="add"></div>
  <div class="row"> <!-- START ADD ROW -->
    <h3 style="padding-top: 70px;">Add Repair Item</h3>
    <form class="form-horizontal" action="/">
      
      <div class="form-group">
      <label for="bName" class="col-sm-2 control-label">Repair Item Name</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="repairItemName" placeholder="Repair item">
      </div>
      </div>
                
      <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
          <button type="submit" class="btn btn-primary" onclick="manageRepairItem('add'); return false;">Add Item</button>
        </div>
      </div>
      
    </form>
  </div><!-- END ADD ROW --> 
  
  
  
</div><!--END CONTAINER -->

<!--SCRIPTS-->
<script src="js/toast.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?"></script> 
<script type="text/javascript">
  
  Toast.defaults.width='600px';
  Toast.defaults.displayDuration=7000;        
  
  window.onload = function(){
    var queryStr = window.location.search;
    /*if(queryStr=='?editSuccess=True'){
      Toast.success('Edit Successful!', 'Edit Confirmation');
    } else if(queryStr=='?editSuccess=False'){
      Toast.error('There was an error in one or more of your inputs!', 'Edit Status');        
    }*/
  }
  
  function manageRepairItem(action){
    console.log(action);
  }
  
</script> 
  

</body>
</html>
