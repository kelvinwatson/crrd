<?php session_start();
error_reporting(E_ALL);
ini_set('display_errors',1);
ini_set('session.save_path', '../session_saver');
header('Content-Type: text/html; charset=utf-8');
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
  <link rel= "shortcut icon" media="all" type="image/x-icon" href="favicon.ico" />
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
        <!--<li><a href="#about">About</a></li>
        <li><a href="#contact">Contact</a></li>-->
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
            <li class="dropdown-header">USERS</li>
            <li><a href="users.php">Users</a></li>
          </ul>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-log-in"></span> Logged In<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#"><span class="glyphicon glyphicon-asterisk"></span>  Logged In</a></li>
            <li><a href="#"><span class="glyphicon glyphicon-user"></span>  Profile</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="logout.php"><span class="glyphicon glyphicon-off"></span>  Logout</a></li>
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
    <h3>View Repair Items</h3>
    <div class="table-responsive">
      <table class="table">
        <thead>
            <tr>
              <!--<th>Edit</th>-->
              <th>Item Name</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if (!($stmt = $mysqli->prepare(
              "SELECT DISTINCT i.id, i.name FROM item i
              INNER JOIN business_category_item bci ON bci.iid=i.id
              INNER JOIN category c ON c.id=bci.cid
              WHERE c.id=16 ORDER BY i.name ASC"))) {
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
              "<tr><td>".$iN."<input type=\"hidden\" name=\"repair-item-name\" value=\"".$iN."\"></td>
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
      <label for="iName" class="col-sm-2 control-label">Repair Item</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="iName" value="<?php echo htmlspecialchars($_POST['repair-item-name']); ?>">
      </div>
      </div>
      
    <div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
        <input type="hidden" id="iId" value="<?php echo htmlspecialchars($_POST['repair-item-id']); ?>">
        <button type="submit" class="btn btn-primary" onclick="manageRepairItem('edit'); return false;">Confirm Edit</button>
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
      <label for="iName" class="col-sm-2 control-label">Repair Item Name</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="iName" placeholder="Repair item">
      </div>
      </div>
      
      <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
          <button type="button" class="btn btn-primary" onclick="manageRepairItem('add'); return false;">Add Item</button>
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
<script type="text/javascript" src="https://maps.google.com/maps/api/js?"></script> 
<script type="text/javascript">
  
  Toast.defaults.width='600px';
  Toast.defaults.displayDuration=7000;        
  
  window.onload = function(){
    var queryStr = window.location.search;
    if(queryStr=='?editSuccess=True'){
      Toast.success('Edit Successful!', 'Edit Confirmation');
    } else if(queryStr=='?editSuccess=False&err=NoItemName'){
      Toast.error('You did not enter an item name', 'Edit Failed');        
    } else if(queryStr=='?addSuccess=True'){
      Toast.success('Item added successfully!', 'Add Confirmation');      
    } else if(queryStr=='?addSuccess=False&err=NoItemName'){
      Toast.error('You did not enter an item name.', 'Add Failed');        
    } else if(queryStr=="?genSuccess=False&err=NoItemName"){
      Toast.error('You did not enter an item name.', 'Failed');
    } else if(queryStr =="?addSuccess=False&err=Duplicate"){
      Toast.error('Item already exists in database.', 'Failed');      
    }
  }
  
  function manageRepairItem(action){
    var itemName = document.getElementById("iName").value;
    if(!itemName.match(/\S/)){ //if empty name, short circuit
      window.location = "https://web.engr.oregonstate.edu/~watsokel/crrd/wmi/repairitems.php?genSuccess=False&err=NoItemName";
      return;
    }
    if(action=='edit'){
      console.log(action);
      var itemId = document.getElementById("iId").value;
      constructRequest('edit',itemId,itemName,null);
    } else if (action=='add'){
      console.log(action);
      constructRequest('add',null,itemName,null);
    }
  }
  
  
  
  function constructRequest(action, itemId, itemName, formData){
      if(window.XMLHttpRequest) httpRequest = new XMLHttpRequest();
      else if(window.ActiveXObject){
        try { 
          httpRequest = new ActiveXObject('Msxml2.XMLHTTP');
        }
        catch(e){
          try{  
            httpRequest = new ActiveXObject('Microsoft.XMLHTTP');
          } catch(e){}
        }
      }
      if (!httpRequest){
        alert('Unable to create XMLHTTP instance.');
        return false;
      }
      httpRequest.onreadystatechange = processResponse;
      httpRequest.open('POST','https://web.engr.oregonstate.edu/~watsokel/crrd/wmi/storeRepairItem.php',true);
      httpRequest.setRequestHeader('Content-type','application/x-www-form-urlencoded');    
      var postParams;
      if(action=='edit'){  
        postParams = 'action='+action+'&item_id='+itemId+'&item_name='+itemName;
      } else if(action=='add'){
        debugger;
        postParams = 'action='+action+'&item_name='+itemName;
      }
      httpRequest.send(postParams); 
  }

  
  function processResponse(){
    try{
      console.log(httpRequest.readyState);
      if(httpRequest.readyState===4 && httpRequest.status===200){
        var obj = JSON.parse(httpRequest.responseText);
        console.log(obj);
        if(obj.httpResponseCode==400){
          if(obj.response=='editFailure'){
             if(obj.errorMessage=='Missing item name.'){
                window.location = "https://web.engr.oregonstate.edu/~watsokel/crrd/wmi/repairitems.php?editSuccess=False&err=NoItemName"; 
             }
          }else if (obj.response=='addFailure'){
            if(obj.errorMessage=='Missing item name.'){
                window.location = "https://web.engr.oregonstate.edu/~watsokel/crrd/wmi/repairitems.php?addSuccess=False&err=NoItemName"; 
             }
            if(obj.errorMessage=='Duplicate item.'){
                window.location = "https://web.engr.oregonstate.edu/~watsokel/crrd/wmi/repairitems.php?addSuccess=False&err=Duplicate"; 
             }
          } else if (obj.response=='failure'){
            if(obj.errorMessage=='Item name is not set.'){
                window.location = "https://web.engr.oregonstate.edu/~watsokel/crrd/wmi/repairitems.php?genSuccess=False&err=NoItemName"; 
            }
          }
        } else{ //obj.httpResponseCode is 200
          if(obj.response=='editSuccess'){
            window.location = "https://web.engr.oregonstate.edu/~watsokel/crrd/wmi/repairitems.php?editSuccess=True"; 
          } else if(obj.response=='addSuccess'){
            window.location = "https://web.engr.oregonstate.edu/~watsokel/crrd/wmi/repairitems.php?addSuccess=True";   
          }
        }
      }else console.log('Problem with the request');
    } catch(e){
      console.log('Caught Exception: ' + e);
    }
  }
  
</script> 
  

</body>
</html>
