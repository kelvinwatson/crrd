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
  <link rel="icon" href="../../favicon.ico">
  <title>Admin Portal: Corvallis Reuse and Repair Directory</title>
  <link href="css/bootstrap.css" rel="stylesheet">
  <link href="css/navbar-fixed-top.css" rel="stylesheet">
  <link href="css/toast.css" rel="stylesheet"/>
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
              <th>Name</th>
              <th>Street</th>
              <th>City</th>
              <th>State</th>
              <th>Zip</th>
              <th>Phone</th>
              <th>Items</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if (!($stmt = $mysqli->prepare(
              "SELECT b.id, b.name, b.street, b.city, b.state, b.zipcode, b.phone, b.latitude, b.longitude, i.name FROM business b
              INNER JOIN business_category_item bci ON bci.bid=b.id
              INNER JOIN item i ON i.id=bci.iid
              INNER JOIN category c ON c.id=bci.cid
              WHERE b.type='Repair' AND c.id=16 "))) {
              echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
            }
            
            if (!$stmt->execute()) {
              echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            }
            
            if(!$stmt->bind_result($bID, $bN,$bStr,$bC,$bSta,$bZ,$bP,$bLat,$bLng,$iN)){
              echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqlii->connect_error;
            }
            
            $prevbN = $prevbStr = $prevbC = $prevbSta = $prevbZ = $prevbP = $prevbLat = $prevbLng = NULL;
            $i=0;
            $arr = array();
            
            while($stmt->fetch()){
              if($prevbN==NULL){ //only executes the first iteration
                $prevbN = $bN;
              }
              if($bN == $prevbN) {
                $arr[$i++] = $iN;
                $prevbID = $bID;
                $prevbN = $bN;
                $prevbStr = $bStr;
                $prevbC = $bC;
                $prevbSta = $bSta;
                $prevbZ = $bZ;
                $prevbP = $bP;
                $prevbLat = $bLat;
                $prevbLng = $bLng;
              } else {
                echo 
                "<tr><form action=\"http://web.engr.oregonstate.edu/~watsokel/crrd/wmi/repairbusinesses.php#edit\" method=\"post\">
                <td><input class=\"btn btn-warning\" type=\"submit\" value=\"edit\"><input type=\"hidden\" name=\"repair-business-id\" value=\"".$prevbID."\"></td>
                <td>".$prevbN."<input type=\"hidden\" name=\"repair-business-name\" value=\"".$prevbN."\"></td>
                <td>".$prevbStr."<input type=\"hidden\" name=\"repair-business-street\" value=\"".$prevbStr."\"></td>
                <td>".$prevbC."<input type=\"hidden\" name=\"repair-business-city\" value=\"".$prevbC."\"></td>
                <td>".$prevbSta."<input type=\"hidden\" name=\"repair-business-state\" value=\"".$prevbSta."\"></td>
                <td>".$prevbZ."<input type=\"hidden\" name=\"repair-business-zip\" value=\"".$prevbZ."\"></td>
                <td>".$prevbP."<input type=\"hidden\" name=\"repair-business-phone\" value=\"".$prevbP."\"></td>
                <td><ul>";
                foreach($arr as $v){
                  echo "<li>".$v."</li>";
                }
                echo "</ul></td><input type=\"hidden\" name=\"user-action\" value=\"edit-business\"></form></tr>";
                unset($arr);
                $arr = array();
                $i=0;
                $prevbID = $bID;
                $prevbN = $bN;
                $prevbStr = $bStr;
                $prevbC = $bC;
                $prevbSta = $bSta;
                $prevbZ = $bZ;
                $prevbP = $bP;
                $prevbLat = $bLat;
                $prevbLng = $bLng;
                $arr[$i++] = $iN;                
              }
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
  <?php if($_POST['user-action']=='edit-business'):?>
    <h3 style="padding-top: 70px;">Edit Repair Business</h3>
    <form class="form-horizontal" action="/">
      
      <div class="form-group">
      <label for="bName" class="col-sm-2 control-label">Repair Business Name</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="bName" value="<?php echo htmlspecialchars($_POST['repair-business-name']); ?>">
      </div>
      </div>
      
      <div class="form-group">
      <label for="bStreet" class="col-sm-2 control-label">Street</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="bStreet" value="<?php echo htmlspecialchars($_POST['repair-business-street']); ?>">
      </div>
      </div>
      
      <div class="form-group">
      <label for="bCity" class="col-sm-2 control-label">City</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="bCity" value="<?php echo htmlspecialchars($_POST['repair-business-city']); ?>">
      </div>
      </div>
      
      <div class="form-group">
      <label for="bState" class="col-sm-2 control-label">State</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="bState" value="<?php echo htmlspecialchars($_POST['repair-business-state']); ?>">
      </div>
      </div>  

      <div class="form-group">
      <label for="bZip" class="col-sm-2 control-label">Zip code</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="bZip" value="<?php echo htmlspecialchars($_POST['repair-business-zip']); ?>">
      </div>
      </div>    
      
      <div class="form-group">
      <label for="bPhone" class="col-sm-2 control-label">Phone</label>
      <div class="col-sm-10">
        <input type="tel" class="form-control" id="bPhone" value="<?php echo htmlspecialchars($_POST['repair-business-phone']); ?>">
      </div>
      </div>    
      
      
    <div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
        <input type="hidden" id="bId" value="<?php echo htmlspecialchars($_POST['repair-business-id']); ?>">
        <button type="submit" class="btn btn-primary" onclick="codeAddress('edit'); return false;">Confirm Edit</button>
      </div>
    </div>
    </form>
  <?php endif; ?>
 <?php endif; ?>

  </div><!--END EDIT ROW-->

  <div id="add"></div>
  <div class="row">
    <h3 style="padding-top: 70px;">Add Repair Business</h3>
    <form class="form-horizontal" action="/">
      
      <div class="form-group">
      <label for="bName" class="col-sm-2 control-label">Repair Business Name</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="bName" placeholder="Repair business name">
      </div>
      </div>
      
      <div class="form-group">
      <label for="bStreet" class="col-sm-2 control-label">Street</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="bStreet" placeholder="Street address">
      </div>
      </div>
      
      <div class="form-group">
      <label for="bCity" class="col-sm-2 control-label">City</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="bCity" placeholder="City">
      </div>
      </div>
      
      <div class="form-group">
      <label for="bState" class="col-sm-2 control-label">State</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="bState" placeholder="State">
      </div>
      </div>  

      <div class="form-group">
      <label for="bZip" class="col-sm-2 control-label">Zip code</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="bZip" placeholder="Zip code">
      </div>
      </div>    
      
      <div class="form-group">
      <label for="bPhone" class="col-sm-2 control-label">Phone</label>
      <div class="col-sm-10">
        <input type="tel" class="form-control" id="bPhone" placeholder="Phone number">
      </div>
      </div>    
          
      <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
          <button type="submit" class="btn btn-primary" onclick="codeAddress('add'); return false;">Add Business</button>
        </div>
      </div>
      
    </form>
  </div>
  
  
  
</div> <!-- END CONTAINER -->

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
    if(queryStr=='?editSuccess=True'){
      Toast.success('Edit Successful!', 'Edit Confirmation');
    } else if(queryStr=='?editSuccess=False'){
      Toast.error('There was an error in one or more of your inputs!', 'Edit Status');        
    }
  }
  
  function codeAddress(action){
    console.log(action);
    var geocoder = new google.maps.Geocoder();
    var businessId; 
    if(action=='edit'){
      businessId = document.getElementById("bId").value;
    }
    var businessName = document.getElementById("bName").value; //internal use only
    var street = document.getElementById("bStreet").value;
    var city = document.getElementById("bCity").value;
    var state = document.getElementById("bState").value;
    //var zip = document.getElementById("bZip").value;
    var address = street+", "+city+", "+state;
    geocoder.geocode( {'address': address}, function(geoCodedResults, status) {
      if (status == google.maps.GeocoderStatus.OK){
        console.log(businessId);//internal use only
        console.log(businessName);
        console.log(geoCodedResults[0].geometry.location.lat());
        console.log(geoCodedResults[0].geometry.location.lng());
        var latitude = geoCodedResults[0].geometry.location.lat();
        var longitude = geoCodedResults[0].geometry.location.lng();
        constructRequest(action, businessId, latitude, longitude);//make AJAX request to PHP file to store lat lng
      } else{
        constructRequest(action, businessId, null, null); //if not geocodable, transmit lat and lng as null
      }
    });
  }
  
  function constructRequest(action, businessId, latitude, longitude){
    debugger;
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
    httpRequest.open('POST','http://web.engr.oregonstate.edu/~watsokel/crrd/wmi/storeRepairBusiness.php',true);
    httpRequest.setRequestHeader('Content-type','application/x-www-form-urlencoded');    
    var postParams;
    if(action=='edit'){  
      postParams = 'action='+action+'business_id='+businessId+'&lat='+latitude+'&lat='+longitude;
    } else if(action=='add'){
      postParams = 'action='+action+'&lat='+latitude+'&lat='+longitude;  
    }
    httpRequest.send(postParams);
  }

  function processResponse(){
    try{
      console.log(httpRequest.readyState);
      if(httpRequest.readyState===4 && httpRequest.status===200){
        var response = JSON.parse(httpRequest.responseText);
        console.log(response);
        if(response=='editSuccess'){
          window.location = "http://web.engr.oregonstate.edu/~watsokel/crrd/wmi/repairbusinesses.php?editSuccess=True"; 
        } else if (response=='editFailure'){
          window.location = "http://web.engr.oregonstate.edu/~watsokel/crrd/wmi/repairbusinesses.php?editSuccess=False"; 
        } else if(response=='addSuccess'){
          window.location = "http://web.engr.oregonstate.edu/~watsokel/crrd/wmi/repairbusinesses.php?addSuccess=True";   
        } else if (response=='addFailure'){
          window.location = "http://web.engr.oregonstate.edu/~watsokel/crrd/wmi/repairbusinesses.php?addSuccess=False"; 
        }
      }else console.log('Problem with the request');
    }
    catch(e){
      console.log('Caught Exception: ' + e);
    }
  }
</script> 
  

</body>
</html>



<!--
CREATE TABLE business (
   id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
   name VARCHAR(255) NOT NULL,
   type VARCHAR(255) NOT NULL,
   phone VARCHAR(255) DEFAULT NULL,
   website VARCHAR(255) DEFAULT NULL,
   street VARCHAR(255) DEFAULT NULL,
   city VARCHAR(255) DEFAULT NULL,
   state VARCHAR(255) DEFAULT NULL,
   zipcode INT(11) DEFAULT NULL,
   latitude FLOAT DEFAULT NULL,
   longitude FLOAT DEFAULT NULL,
   info VARCHAR(255) DEFAULT NULL
)ENGINE=InnoDB;
CREATE TABLE item (
id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(255) UNIQUE NOT NULL,
url VARCHAR(255) DEFAULT NULL
)ENGINE=InnoDB;

DROP TABLE IF EXISTS category;
CREATE TABLE category (
id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(255) NOT NULL
)ENGINE=InnoDB;

DROP TABLE IF EXISTS business_category_item;
CREATE TABLE business_category_item (
  bid INT(11) not null,
  cid INT(11) not null,
  iid INT(11) not null,
  FOREIGN KEY(bid) REFERENCES business(id)
    ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY(cid) REFERENCES category(id)
    ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY(iid) REFERENCES item(id)
    ON UPDATE CASCADE ON DELETE CASCADE,
  PRIMARY KEY (bid,cid,iid)
)ENGINE=InnoDB;

DROP TABLES IF EXISTS operating_day;
CREATE TABLE operating_day (
id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
day VARCHAR(255) UNIQUE NOT NULL
)ENGINE=InnoDB;

DROP TABLES IF EXISTS open_hour;
CREATE TABLE open_hour (
id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
open_time TIME NOT NULL
)ENGINE=InnoDB;

DROP TABLES IF EXISTS close_hour;
CREATE TABLE close_hour (
id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
close_time TIME NOT NULL
)ENGINE=InnoDB;
-->