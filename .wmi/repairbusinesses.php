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
    <div class="table">
      <table class="table" style="font-size:0.8em">
        <thead>
            <tr>
              <th>Edit</th>
              <th>Name</th>
              <th>Street</th>
              <th>City</th>
              <th>State</th>
              <th>Zip</th>
              <th>Phone</th>
              <th>Website</th>
              <th>Operating Hours</th>
              <th>Items Accepted</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if (!($stmt = $mysqli->prepare(
              "SELECT b.id, b.type, b.name, b.street, b.city, b.state, b.zipcode, b.phone, b.website, b.hours, b.latitude, b.longitude, i.name
              FROM business b LEFT JOIN business_category_item bci ON bci.bid = b.id
              LEFT JOIN item i ON i.id = bci.iid
              WHERE b.type =  'Repair' AND b.name != 'generic_repair_business'"))) {
              echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
            }

            if (!$stmt->execute()) {
              echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            }

            if(!$stmt->bind_result($bID,$bT,$bN,$bStr,$bC,$bSta,$bZ,$bP,$bW,$bH,$bLat,$bLng,$iN)){
              echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqlii->connect_error;
            }

            $prevbID = $prevbN = $prevbStr = $prevbC = $prevbSta = $prevbZ = $prevbP = $prevbW = $prevbH = $prevbLat = $prevbLng = NULL;
            $i=0;
            
            $arr = array();
          
            $stmt->store_result();
            
            $numRows = $stmt->num_rows;
            $j=1;
            
            while($row = $stmt->fetch()){
              if($prevbID==NULL){ //only executes the first iteration
                $prevbID = $bID;
                echo print_r($arr,true);
                echo "$bN *1*<br>";
              }
              if($bID == $prevbID) {
                $arr[$i++] = $iN;
                $prevbID = $bID;
                $prevbN = $bN;
                $prevbStr = $bStr;
                $prevbC = $bC;
                $prevbSta = $bSta;
                $prevbZ = $bZ;
                $prevbP = $bP;
                $prevbW = $bW;
                $prevbH = $bH;
                $prevbLat = $bLat;
                $prevbLng = $bLng;
                echo print_r($arr,true);
                echo "$bN *2*<br>";
              } else {
                echo
                  "<tr><form action=\"https://web.engr.oregonstate.edu/~watsokel/crrd/wmi/repairbusinesses.php#edit\" method=\"post\">
                  <td><input class=\"btn btn-warning\" type=\"submit\" value=\"edit\"><input type=\"hidden\" name=\"repair-business-id\" value=\"".$prevbID."\"></td>
                  <td>".$prevbN."<input type=\"hidden\" name=\"repair-business-name\" value=\"".$prevbN."\"></td>
                  <td>".$prevbStr."<input type=\"hidden\" name=\"repair-business-street\" value=\"".$prevbStr."\"></td>
                  <td>".$prevbC."<input type=\"hidden\" name=\"repair-business-city\" value=\"".$prevbC."\"></td>
                  <td>".$prevbSta."<input type=\"hidden\" name=\"repair-business-state\" value=\"".$prevbSta."\"></td>
                  <td>".$prevbZ."<input type=\"hidden\" name=\"repair-business-zip\" value=\"".$prevbZ."\"></td>
                  <td>".$prevbP."<input type=\"hidden\" name=\"repair-business-phone\" value=\"".$prevbP."\"></td>
                  <td>".$prevbW."<input type=\"hidden\" name=\"repair-business-website\" value=\"".$prevbW."\"></td>
                  <td>".$prevbH."<input type=\"hidden\" name=\"repair-business-hours\" value=\"".$prevbH."\"></td>
                  <td>
                  <ul style=\"padding-left: 0;\">";
                
                foreach($arr as $v){
                  echo "<li>".$v."</li>";
                  echo "<input type=\"hidden\" name=\"repair-items-accepted[]\" value=\"".$v."\">";
                }
                echo "</ul></td>
                  <input type=\"hidden\" name=\"user-action\" value=\"edit-business\"></form></tr>";
                echo print_r($arr,true);
                echo "$prevbN *3*<br>";
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
                $prevbW = $bW;
                $prevbH = $bH;
                $prevbLat = $bLat;
                $prevbLng = $bLng;
                $arr[$i++] = $iN;
              }
              ++$j;
              echo print_r($arr,true);
              echo "$bN *4*<br>";
            }
            echo
              "<tr><form action=\"https://web.engr.oregonstate.edu/~watsokel/crrd/wmi/repairbusinesses.php#edit\" method=\"post\">
              <td><input class=\"btn btn-warning\" type=\"submit\" value=\"edit\"><input type=\"hidden\" name=\"repair-business-id\" value=\"".$prevbID."\"></td>
              <td>".$prevbN."<input type=\"hidden\" name=\"repair-business-name\" value=\"".$prevbN."\"></td>
              <td>".$prevbStr."<input type=\"hidden\" name=\"repair-business-street\" value=\"".$prevbStr."\"></td>
              <td>".$prevbC."<input type=\"hidden\" name=\"repair-business-city\" value=\"".$prevbC."\"></td>
              <td>".$prevbSta."<input type=\"hidden\" name=\"repair-business-state\" value=\"".$prevbSta."\"></td>
              <td>".$prevbZ."<input type=\"hidden\" name=\"repair-business-zip\" value=\"".$prevbZ."\"></td>
              <td>".$prevbP."<input type=\"hidden\" name=\"repair-business-phone\" value=\"".$prevbP."\"></td>
              <td>".$prevbW."<input type=\"hidden\" name=\"repair-business-website\" value=\"".$prevbW."\"></td>
              <td>".$prevbH."<input type=\"hidden\" name=\"repair-business-hours\" value=\"".$prevbH."\"></td>
              <td>
              <ul style=\"padding-left: 0;\">";
              foreach($arr as $v){
                echo "<li>".$v."</li>";
                echo "<input type=\"hidden\" name=\"repair-items-accepted[]\" value=\"".$v."\">";
              }
              echo "</ul></td>
                <input type=\"hidden\" name=\"user-action\" value=\"edit-business\"></form></tr>";
                
            $stmt->free_result();
             
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
      <label for="bWebsite" class="col-sm-2 control-label">Website</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="bWebsite" value="<?php echo htmlspecialchars($_POST['repair-business-website']); ?>">
      </div>
      </div>
      
      <div class="form-group">
      <label for="bHours" class="col-sm-2 control-label">Hours</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="bHours" value="<?php echo htmlspecialchars($_POST['repair-business-hours']); ?>">
      </div>
      </div>

      <div class="form-group">
      <label for="bItems" class="col-sm-2 control-label">Items</label>
      <div class="col-sm-10">

      <ul class="list-unstyled">
        <?php
        if (!($stmt = $mysqli->prepare(
          "SELECT DISTINCT i.id, i.name FROM item i
          INNER JOIN business_category_item bci ON bci.iid=i.id
          INNER JOIN category c ON c.id=bci.cid WHERE c.id=16" ))) {
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
          "<li>";
          if (in_array($iN, $_POST['repair-items-accepted'])){
            echo "<input type=\"checkbox\" id=\"".$iID."\" name=\"edit-repair-item-id\" value=\"".$iID."\" checked>"." ".$iN;
          } else{
            echo "<input type=\"checkbox\" id=\"".$iID."\" name=\"edit-repair-item-id\" value=\"".$iID."\">"." ".$iN;
          }
          echo "</li>";
        }
        $stmt->close();

        ?>
      </ul>


    <div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
        <input type="hidden" id="bId" value="<?php echo htmlspecialchars($_POST['repair-business-id']); ?>">
        <button type="button" class="btn btn-primary" onclick="codeAddress('edit'); return false;">Confirm Edit</button>
      </div>
    </div>
    </form>
    <hr style="width: 100%; color: black; height: 1px; background-color:#d3d3d3;" />
    <br><br>

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
        <input type="tel" class="form-control" id="bPhone" placeholder="Phone number (format 012-345-6789)">
      </div>
      </div>

      <div class="form-group">
      <label for="bWebsite" class="col-sm-2 control-label">Website</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="bWebsite" placeholder="Website address (e.g. http://www.example.com)">
      </div>
      </div>
      
      <div class="form-group">
      <label for="bHours" class="col-sm-2 control-label">Website</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="bHours" placeholder="Operating hours (e.g. Mon-Fri 9am-5:30pm, Sat 8:30am-4pm, Sun 10am-3pm)">
      </div>
      </div>

      <div class="form-group">
        <label for="bItems" class="col-sm-2 control-label">Items</label>
        <div class="col-sm-10">
          <ul class="list-unstyled">
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
            "<li><input type=\"checkbox\" id=\"".$iID."\" name=\"add-repair-item-id\" value=\"".$iID."\">"." ".$iN."</li>";
          }
          $stmt->close();
          ?>
          </ul>
        </div>
      </div>

      <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
          <button type="button" class="btn btn-primary" onclick="codeAddress('add'); return false;">Add Business</button>
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
<script type="text/javascript" src="https://maps.google.com/maps/api/js?"></script>
<script type="text/javascript">

  Toast.defaults.width='600px';
  Toast.defaults.displayDuration=7000;

  window.onload = function(){
    var queryStr = window.location.search;
    if(queryStr=='?editSuccess=True'){
      Toast.success('Edit Successful!', 'Edit Confirmation');
    } else if(queryStr=='?editSuccess=False'){
      Toast.error('There was an error in one or more of your inputs!', 'Edit Status');
    } else if(queryStr=='?addSuccess=True'){
      Toast.success('Add Successful!', 'Add Confirmation');
    }else if(queryStr=='?addSuccess=False'){
      Toast.error('There was an error in one or more of your inputs!', 'Add Status');
    }
  }

  function codeAddress(action){
    console.log(action);
    var geocoder = new google.maps.Geocoder();
    var businessId;
    if(action=='edit'){
      businessId = document.getElementById("bId").value;
      var checkboxes = document.getElementsByName("edit-repair-item-id");
      var cbCheckedIds = [];
      var cbNotCheckedIds = [];
      for(var k=0, len=checkboxes.length; k<len; k++){
        if(checkboxes[k].checked){
          cbCheckedIds.push(parseInt(checkboxes[k].value));
        } else{
          cbNotCheckedIds.push(parseInt(checkboxes[k].value));
        }
      }
      if(cbCheckedIds.length<=0){
        Toast.error('You must select repair item.', 'Edit Status');
        return; //cannot have a business that does not accept any items
      }
      var cbCheckedIdsJSON = JSON.stringify(cbCheckedIds);
      var cbNotCheckedIdsJSON = JSON.stringify(cbNotCheckedIds);
      console.log('==checkboxes checked==');
      console.log(cbCheckedIdsJSON);
      console.log('==checkboxes NOT checked==');
      console.log(cbNotCheckedIdsJSON);
    }
    if(action=='add'){
      var checkboxes = document.getElementsByName("add-repair-item-id");
      var cbCheckedIds = [];
      for(var k=0, len=checkboxes.length; k<len; k++){
        if(checkboxes[k].checked){
          cbCheckedIds.push(parseInt(checkboxes[k].value));
        } 
      }
      if(cbCheckedIds.length<=0){
        Toast.error('You must select repair item.', 'Edit Status');
        return; //cannot have a business that does not accept any items
      }
      var cbCheckedIdsJSON = JSON.stringify(cbCheckedIds);
      console.log('==ADD checkboxes checked==');
      console.log(cbCheckedIdsJSON);
    }
    var businessName = document.getElementById("bName").value; //internal use only
    var street = document.getElementById("bStreet").value;
    var city = document.getElementById("bCity").value;
    var state = document.getElementById("bState").value;
    var zipcode = document.getElementById("bZip").value;
    var phone = document.getElementById("bPhone").value;
    var website = document.getElementById("bWebsite").value;
    var hours = document.getElementById("bHours").value;
    var address = street+", "+city+", "+state;
    geocoder.geocode( {'address': address}, function(geoCodedResults, status) {
      if (status == google.maps.GeocoderStatus.OK){
        var latitude = geoCodedResults[0].geometry.location.lat();
        var longitude = geoCodedResults[0].geometry.location.lng();
        //make AJAX request to PHP file to store lat lng
        constructRequest(action, businessId, businessName, street, city, state, zipcode, phone, website, hours, latitude, longitude, cbCheckedIdsJSON, cbNotCheckedIdsJSON);
      } else{
        //if not geocodable, transmit lat and lng as null
        constructRequest(action, businessId, businessName, street, city, state, zipcode, phone, website, hours, null, null, cbCheckedIdsJSON, cbNotCheckedIdsJSON);
      }
    });
  }

  function constructRequest(action, businessId, businessName, street, city, state, zipcode, phone, website, hours, latitude, longitude, itemIdsChecked, itemIdsNotChecked){
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
    httpRequest.open('POST','https://web.engr.oregonstate.edu/~watsokel/crrd/wmi/storeRepairBusiness.php',true);
    httpRequest.setRequestHeader('Content-type','application/x-www-form-urlencoded');
    var postParams;
    if(latitude==null){
      latitude='';
    }
    if(longitude==null){
      longitude='';
    }
    if(hours==null){
      hours='';
    }
    if(action=='edit'){
      postParams = 'action='+action+'&business_id='+businessId+'&business_name='+businessName+'&street='+street+'&city='+city+'&state='+state+'&zipcode='+zipcode+'&phone='+phone+'&website='+website+'&hours='+hours+'&lat='+latitude+'&long='+longitude+'&itemIdsChecked='+itemIdsChecked+'&itemIdsNotChecked='+itemIdsNotChecked;
    } else if(action=='add'){
      postParams = 'action='+action+'&business_name='+businessName+'&street='+street+'&city='+city+'&state='+state+'&zipcode='+zipcode+'&phone='+phone+'&website='+website+'&hours='+hours+'&lat='+latitude+'&long='+longitude+'&itemIdsChecked='+itemIdsChecked+'&itemIdsNotChecked='+null;
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
            window.location = "https://web.engr.oregonstate.edu/~watsokel/crrd/wmi/repairbusinesses.php?editSuccess=False";
          }else if (obj.response=='addFailure'){
            window.location = "https://web.engr.oregonstate.edu/~watsokel/crrd/wmi/repairbusinesses.php?addSuccess=False";
          }
        } else{ //obj.httpResponseCode is 200
          if(obj.response=='editSuccess'){
            window.location = "https://web.engr.oregonstate.edu/~watsokel/crrd/wmi/repairbusinesses.php?editSuccess=True";
          } else if(obj.response=='addSuccess'){
            window.location = "https://web.engr.oregonstate.edu/~watsokel/crrd/wmi/repairbusinesses.php?addSuccess=True";
          }
        }
      }else {
        console.log('Problem with the request');

      }
    }catch(e){
      console.log('Caught Exception: ' + e);
    }
  }
</script>


</body>
</html>
