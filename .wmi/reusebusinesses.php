<?php session_start();
error_reporting(E_ALL);
ini_set('display_errors',1);
ini_set('session.save_path', '../session_saver');
header('Content-Type: text/html; charset=utf-8');
include 'dbp.php';

if(!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn']){
  header('Location: index.php');
}

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
  <link rel="icon" href="favicon.ico">
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
        <li><a href="main.php">Home</a></li>
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
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-asterisk" style="color:#7FFF00"></span> Logged In<span class="caret"></span></a>
          <ul class="dropdown-menu">
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
    <h3>View/Edit Reuse Businesses</h3>
    <div class="table">
      <table class="table" style="font-size:0.8em; table-layout: fixed; word-wrap: break-word;">
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
              "SELECT b.id, b.type, b.name, b.street, b.city, b.state, b.zipcode, b.phone, b.website, b.hours, b.latitude, b.longitude, c.id, c.name, i.id, i.name
              FROM business b LEFT JOIN business_category_item bci ON bci.bid = b.id
              LEFT JOIN category c ON c.id=bci.cid
              LEFT JOIN item i ON i.id = bci.iid
              WHERE b.type = 'Reuse' AND b.name != 'generic_reuse_business'"))) {
              echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
            }

            if (!$stmt->execute()) {
              echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            }

            if(!$stmt->bind_result($bID,$bT,$bN,$bStr,$bC,$bSta,$bZ,$bP,$bW,$bH,$bLat,$bLng,$cI,$cN,$iI,$iN)){
              echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqlii->connect_error;
            }

            $prevbID = $prevbN = $prevbStr = $prevbC = $prevbSta = $prevbZ = $prevbP = $prevbW = $prevbH = $prevbLat = $prevbLng = NULL;
            $prevcI = $prevcN = $previI = $previN = NULL;
            $i=0;
            $arrI = array(); //associative array, structure:  [  [catName]=>[itemName,itemName...]    [catName]=>[itemName,itemName...] ...]
            $arrN = array(); //associative array, structure:  [  [catID]=>[itemID,itemID...]    [catID]=>[itemID,itemID...] ...]
            
            while($row = $stmt->fetch()){
              if($prevbID==NULL){ //only executes the first iteration
                $prevbID = $bID;
                //echo print_r($arr,true);
                //echo "$bN 1<br>";
              }
              if($bID == $prevbID) {
                $arrI[$cI][]=$iI;
                $arrN[$cN][]=$iN;
                //echo var_dump($arrN);
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
                //echo print_r($arrI,true);
                //echo print_r($arrN,true);
                //echo "$bN 2<br>";
              } else {
                echo
                  "<tr><form action=\"reusebusinesses.php#edit\" method=\"post\">
                  <td style=\"padding-left:0px;\"><input class=\"btn btn-warning\" type=\"submit\" value=\"edit\"><input type=\"hidden\" name=\"reuse-business-id\" value=\"".$prevbID."\"></td>
                  <td style=\"padding-left:0px;\">".$prevbN."<input type=\"hidden\" name=\"reuse-business-name\" value=\"".$prevbN."\"></td>
                  <td style=\"padding-left:0px;\">".$prevbStr."<input type=\"hidden\" name=\"reuse-business-street\" value=\"".$prevbStr."\"></td>
                  <td style=\"padding-left:0px;\">".$prevbC."<input type=\"hidden\" name=\"reuse-business-city\" value=\"".$prevbC."\"></td>
                  <td style=\"padding-left:0px;\">".$prevbSta."<input type=\"hidden\" name=\"reuse-business-state\" value=\"".$prevbSta."\"></td>
                  <td style=\"padding-left:0px;\">".$prevbZ."<input type=\"hidden\" name=\"reuse-business-zip\" value=\"".$prevbZ."\"></td>
                  <td style=\"padding-left:0px; white-space: nowrap;\">".$prevbP."<input type=\"hidden\" name=\"reuse-business-phone\" value=\"".$prevbP."\"></td>
                  <td style=\"font-size:0.77em;word-wrap: break-word;\">".$prevbW."<input type=\"hidden\" name=\"reuse-business-website\" value=\"".$prevbW."\"></td>
                  <td style=\"padding-left:0px;\">".$prevbH."<input type=\"hidden\" name=\"reuse-business-hours\" value=\"".$prevbH."\"></td>
                  <td style=\"padding-left:0px;\"><a style=\"cursor: pointer;\" data-toggle=\"modal\" data-target=\"#itemModal".$prevbID."\">Click to view items</a></td>";
                  //echo var_dump($arrN);

                //define modal
                echo "
                <div class=\"modal fade\" id=\"itemModal".$prevbID."\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\">
                  <div class=\"modal-dialog\" role=\"document\">
                    <div class=\"modal-content\">
                      <div class=\"modal-header\">
                        <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>
                        <h4 class=\"modal-title\" id=\"myModalLabel\">Reuse items accepted by ".$prevbN."</h4>
                      </div>
                      <div class=\"modal-body\">
                        <div class=\"panel panel-default\">";
                          if(!empty($arrN) && count($arrN)>0 && !isset($arrN[""])){
                            ksort($arrN);
                            foreach($arrN as $categoryName=>$itemArr){
                              echo "<div class=\"panel-heading\"><h3 class=\"panel-title\">$categoryName</h3></div><div class=\"panel-body\">";
                              echo "<ul>";
                              for($i=0, $len=count($itemArr); $i<$len; $i++){
                                echo "<li>".$itemArr[$i]."</li>";
                                echo "<input type=\"hidden\" name=\"reuse-cats-items-accepted[]\" value=\"".$categoryName."=".$itemArr[$i]."\">";
                              }
                              echo "</ul></div>";
                            }
                          } else{
                            echo "<div class=\"panel-heading\"><h3 class=\"panel-title\">No items</h3></div><div class=\"panel-body\">This business currently does not accept any items for reuse.</div>";
                          }
                echo    "</div></td>";
                echo "</div>
                      <div class=\"modal-footer\">
                        <button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Close</button>
                      </div>
                    </div>
                  </div>
                </div>";
                
                
                
                echo "<input type=\"hidden\" name=\"user-action\" value=\"edit-business\"></form></tr>";
                //echo print_r($arrI,true);
                //echo "$bN 3<br><br>";

                unset($arrI);
                unset($arrN);
                $arrI = array();
                $arrN = array();
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
                $arrI[$cI][]=$iI;
                $arrN[$cN][]=$iN;
              }
              //echo print_r($arrI,true);
              //echo print_r($arrN,true);
              //echo "$bN 4<br>";
            }
            echo
              "<tr><form action=\"reusebusinesses.php#edit\" method=\"post\">
              <td style=\"padding-left:0px;\"><input class=\"btn btn-warning\" type=\"submit\" value=\"edit\"><input type=\"hidden\" name=\"reuse-business-id\" value=\"".$prevbID."\"></td>
              <td style=\"padding-left:0px;\">".$prevbN."<input type=\"hidden\" name=\"reuse-business-name\" value=\"".$prevbN."\"></td>
              <td style=\"padding-left:0px;\">".$prevbStr."<input type=\"hidden\" name=\"reuse-business-street\" value=\"".$prevbStr."\"></td>
              <td style=\"padding-left:0px;\">".$prevbC."<input type=\"hidden\" name=\"reuse-business-city\" value=\"".$prevbC."\"></td>
              <td style=\"padding-left:0px;\">".$prevbSta."<input type=\"hidden\" name=\"reuse-business-state\" value=\"".$prevbSta."\"></td>
              <td style=\"padding-left:0px;\">".$prevbZ."<input type=\"hidden\" name=\"reuse-business-zip\" value=\"".$prevbZ."\"></td>
              <td style=\"padding-left:0px;\">".$prevbP."<input type=\"hidden\" name=\"reuse-business-phone\" value=\"".$prevbP."\"></td>
              <td style=\"font-size:0.77em;word-wrap:break-word;\">".$prevbW."<input type=\"hidden\" name=\"reuse-business-website\" value=\"".$prevbW."\"></td>
              <td style=\"padding-left:0px;\">".$prevbH."<input type=\"hidden\" name=\"reuse-business-hours\" value=\"".$prevbH."\"></td>
              <td style=\"padding-left:0px;\"><a style=\"cursor: pointer;\" data-toggle=\"modal\" data-target=\"#itemModal".$prevbID."\">Click to view items</a></td>";
              
              //define modal
                echo "
                <div class=\"modal fade\" id=\"itemModal".$prevbID."\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\">
                  <div class=\"modal-dialog\" role=\"document\">
                    <div class=\"modal-content\">
                      <div class=\"modal-header\">
                        <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>
                        <h4 class=\"modal-title\" id=\"myModalLabel\">Reuse items accepted by ".$prevbN."</h4>
                      </div>
                      <div class=\"modal-body\">
                        <div class=\"panel panel-default\">";
                          if(!empty($arrN) && count($arrN)>0 && !isset($arrN[""])){
                            ksort($arrN);
                            foreach($arrN as $categoryName=>$itemArr){
                              echo "<div class=\"panel-heading\"><h3 class=\"panel-title\">$categoryName</h3></div><div class=\"panel-body\">";
                              echo "<ul>";
                              for($i=0, $len=count($itemArr); $i<$len; $i++){
                                echo "<li>".$itemArr[$i]."</li>";
                                echo "<input type=\"hidden\" name=\"reuse-cats-items-accepted[]\" value=\"".$categoryName."=".$itemArr[$i]."\">";
                              }
                              echo "</ul></div>";
                            }
                          } else{
                            echo "<div class=\"panel-heading\"><h3 class=\"panel-title\">No items</h3></div><div class=\"panel-body\">This business currently does not accept any items for reuse.</div>";
                          }
                echo    "</div></td>";
                echo "</div>
                      <div class=\"modal-footer\">
                        <button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Close</button>
                      </div>
                    </div>
                  </div>
                </div>";
                echo "<input type=\"hidden\" name=\"user-action\" value=\"edit-business\"></form></tr>";
      
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
    <?php //echo var_dump($_POST);
    //echo "<br>";
    //echo print_r($_POST);
    //echo var_dump($_POST['reuse-cats-items-accepted']);
    //error_log(print_r($_POST,true),3,"/nfs/stak/students/w/watsokel/public_html/crrd/wmi/err.log");
    
    $catItemNameArr = $_POST['reuse-cats-items-accepted'];
    //echo var_dump($catItemNameArr);
    /*for($k=0, $len=count($catItemNameArr); $k<$len; $k++){
      $kvar=explode("=",$catItemNameArr[$k]);
      echo $kvar[0];
      echo "<br>";
      echo $kvar[1];
    }*/
    
    ?>  
    
    <h3 style="padding-top: 70px;">Edit Reuse Business</h3>
    <form class="form-horizontal" action="/">

      <div class="form-group">
      <label for="bName" class="col-sm-2 control-label">Reuse Business Name</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="bName" value="<?php echo htmlspecialchars($_POST['reuse-business-name']); ?>" required>
      </div>
      </div>

      <div class="form-group">
      <label for="bStreet" class="col-sm-2 control-label">Street</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="bStreet" value="<?php echo htmlspecialchars($_POST['reuse-business-street']); ?>">
      </div>
      </div>

      <div class="form-group">
      <label for="bCity" class="col-sm-2 control-label">City</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="bCity" value="<?php echo htmlspecialchars($_POST['reuse-business-city']); ?>">
      </div>
      </div>

      <div class="form-group">
      <label for="bState" class="col-sm-2 control-label">State</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="bState" value="<?php echo htmlspecialchars($_POST['reuse-business-state']); ?>">
      </div>
      </div>

      <div class="form-group">
      <label for="bZip" class="col-sm-2 control-label">Zip code</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="bZip" value="<?php echo htmlspecialchars($_POST['reuse-business-zip']); ?>">
      </div>
      </div>

      <div class="form-group">
      <label for="bPhone" class="col-sm-2 control-label">Phone</label>
      <div class="col-sm-10">
        <input type="tel" class="form-control" id="bPhone" value="<?php echo htmlspecialchars($_POST['reuse-business-phone']); ?>">
      </div>
      </div>

      <div class="form-group">
      <label for="bWebsite" class="col-sm-2 control-label">Website</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="bWebsite" value="<?php echo htmlspecialchars($_POST['reuse-business-website']); ?>">
      </div>
      </div>
      
      <div class="form-group">
      <label for="bHours" class="col-sm-2 control-label">Hours</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="bHours" value="<?php echo htmlspecialchars($_POST['reuse-business-hours']); ?>">
      </div>
      </div>

      <div class="form-group">
      <label for="bItems" class="col-sm-2 control-label">Items</label>
      <div class="col-sm-10">

      <?php
          if (!($stmt = $mysqli->prepare(
            "SELECT c.id, c.name, i.id, i.name FROM item i
            INNER JOIN business_category_item bci ON bci.iid=i.id
            INNER JOIN category c ON c.id=bci.cid WHERE cid != 16 ORDER BY c.name ASC"))) {
            echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
          }

          if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
          }

          if(!$stmt->bind_result($cID, $cN, $iID, $iN)){
            echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqlii->connect_error;
          }
          
          ?>
          <table class="table" style="font-size:0.9em;">  
            <thead>
              <th>Category</th>
              <th>Items</th>
            </thead>
            <tbody>
            <?php
            $arr=array();
            $prevcID=$prevcN=$currCatItemName=NULL;
 
            while($stmt->fetch()){
              //echo "print4";
              if($prevcID==null){
                $prevcID=$cID;
                $prevcN=$cN;
                //echo "<br><br>$cN==<br>";
                //echo print_r($arr);
                //echo "print5<br>";
              }
              if($prevcID==$cID){
                $arr[$iID]=$iN; //associative array
                $prevcID=$cID;
                $prevcN=$cN;
                //echo print_r($arr);
                //echo "print6<br>";
              } else {
                //echo "<br><br>$prevcN==<br>";
                //echo print_r($arr,true);
                //echo "print7<br>";
                echo "<tr><td>".$prevcN."</td>
                <td><ul class=\"list-unstyled\">";
                
                foreach($arr as $k=>$v){ //arr is itemID:itemName pair
                  $currCatItemName=$prevcN."=".$v;
                  //echo $currCatItemName;
                  if(in_array($currCatItemName,$catItemNameArr)){
                    echo "<li><input type=\"checkbox\" name=\"edit-reuse-catid-itemid\" value=\"".$prevcID."=".$k."\" checked>"." ".$v."</li>";  //value format is cID:iID
                  } else{
                    echo "<li><input type=\"checkbox\" name=\"edit-reuse-catid-itemid\" value=\"".$prevcID."=".$k."\">"." ".$v."</li>";
                  }
                }
                echo "</ul></td></tr>";
                unset($arr);
                $arr=array();
                $prevcID=$cID;
                $prevcN=$cN;
                $arr[$iID]=$iN;
                //echo "<br><br>$cN==<br>";
                //echo print_r($arr,true);
                //echo "print8<br>";
              }
            }
            echo
              "<tr><td>".$prevcN."</td>
              <td><ul class=\"list-unstyled\">";
              foreach($arr as $k=>$v){ //arr is itemID:itemName pair
                  $currCatItemName=$prevcN."=".$v;
                  //echo $currCatItemName;
                  if(in_array($currCatItemName,$catItemNameArr)){
                    echo "<li><input type=\"checkbox\" name=\"edit-reuse-catid-itemid\" value=\"".$prevcID."=".$k."\" checked>"." ".$v."</li>";  //value format is cID:iID
                  } else{
                    echo "<li><input type=\"checkbox\" name=\"edit-reuse-catid-itemid\" value=\"".$prevcID."=".$k."\">"." ".$v."</li>";
                  }
                }
            echo "</ul></td></tr>";
            //echo "<br><br>$cN==<br>";
            //echo print_r($arr,true);
            //echo "print9<br>";
            ?>
            </tbody>
          </table>
          <?php $stmt->close(); ?>


    <div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
        <input type="hidden" id="bId" value="<?php echo htmlspecialchars($_POST['reuse-business-id']); ?>">
        <button type="button" class="btn btn-primary" onclick="prepareParams('edit'); return false;">Confirm Edit</button>
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
    <h3 style="padding-top: 70px;">Add Reuse Business</h3>
    <form class="form-horizontal" action="/">

      <div class="form-group">
      <label for="bName" class="col-sm-2 control-label">Reuse Business Name</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="bName" placeholder="Reuse business name" required>
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
          
          <?php
          if (!($stmt = $mysqli->prepare(
            "SELECT c.id, c.name, i.id, i.name FROM item i
            INNER JOIN business_category_item bci ON bci.iid=i.id
            INNER JOIN category c ON c.id=bci.cid WHERE cid != 16 ORDER BY c.name ASC"))) {
            echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
          }

          if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
          }

          if(!$stmt->bind_result($cID, $cN, $iID, $iN)){
            echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqlii->connect_error;
          }
          
          ?>
          <table class="table" style="font-size:0.9em;">  
            <thead>
              <th>Category</th>
              <th>Items</th>
            </thead>
            <tbody>
            <?php
            $arr=array();
            $prevcID=$prevcN=NULL;
            while($stmt->fetch()){
              //echo "WTF4";
              if($prevcID==null){
                $prevcID=$cID;
                $prevcN=$cN;
                //echo "<br><br>$cN==<br>";
                //echo print_r($arr);
                //echo "wtf5<br>";
              }
              if($prevcID==$cID){
                $arr[$iID]=$iN; //associative array
                $prevcID=$cID;
                $prevcN=$cN;
                //echo print_r($arr);
                //echo "wtf6<br>";
              } else {
                //echo "<br><br>$prevcN==<br>";
                //echo print_r($arr,true);
                //echo "wtf7<br>";

                echo "<tr><td>".$prevcN."</td>
                <td><ul class=\"list-unstyled\">";
                foreach($arr as $k=>$v){
                  echo "<li><input type=\"checkbox\" name=\"add-reuse-catid-itemid\" value=\"".$prevcID."=".$k."\">"." ".$v."</li>";
                }
                echo "</ul></td></tr>";
                unset($arr);
                $arr=array();
                $prevcID=$cID;
                $prevcN=$cN;
                $arr[$iID]=$iN;
                //echo "<br><br>$cN==<br>";
                //echo print_r($arr,true);
                //echo "wtf8<br>";
              }
            }
            echo
              "<tr><td>".$prevcN."</td>
              <td><ul class=\"list-unstyled\">";
              foreach($arr as $k=>$v){
                echo "<li><input type=\"checkbox\" name=\"add-reuse-catid-itemid\" value=\"".$prevcID."=".$k."\">"." ".$v."</li>";
              }
            echo "</ul></td></tr>";
            //echo "<br><br>$cN==<br>";
            //echo print_r($arr,true);
            //echo "wtf9<br>";
            ?>
            </tbody>
          </table>
          <?php $stmt->close(); ?>
        </div>
      </div>

      <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
          <button type="button" class="btn btn-primary" onclick="prepareParams('add'); return false;">Add Business</button>
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
    }else if(queryStr=='?err=NoBusinessName'){
      Toast.error('You did not specify a business name.', 'Error');     
    }
  }

  function prepareParams(action){
    var businessName = document.getElementById("bName").value;
    if(!businessName.match(/\S/)){ //if empty name, short circuit
      window.location = "reusebusinesses.php?err=NoBusinessName";
      return;
    }
    Toast.defaults.displayDuration=2000; 
    Toast.warning('Processing your request...','Please wait');
    var geocoder = new google.maps.Geocoder();
    var businessId;
    if(action=='edit'){
      businessId = document.getElementById("bId").value;
      var checkboxes = document.getElementsByName("edit-reuse-catid-itemid");
      var cbCheckedIds = [];
      var cbNotCheckedIds = [];
      for(var k=0, len=checkboxes.length; k<len; k++){
        if(checkboxes[k].checked){
          cbCheckedIds.push(checkboxes[k].value);
        } else{
          cbNotCheckedIds.push(checkboxes[k].value);
        }
      }
      if(cbCheckedIds.length<=0){
        Toast.error('You must select reuse item.', 'Edit Status');
        return; //cannot have a business that does not accept any items
      }
      var cbCheckedIdsJSON = JSON.stringify(cbCheckedIds);
      var cbNotCheckedIdsJSON = JSON.stringify(cbNotCheckedIds);
    }
    if(action=='add'){
      var checkboxes = document.getElementsByName("add-reuse-catid-itemid");
      var cbCheckedIds = [];
      for(var k=0, len=checkboxes.length; k<len; k++){
        if(checkboxes[k].checked){
          cbCheckedIds.push(checkboxes[k].value);
        } 
      }
      if(cbCheckedIds.length<=0){
        Toast.error('You must select reuse item.', 'Edit Status');
        return; //cannot have a business that does not accept any items
      }
      var cbCheckedIdsJSON = JSON.stringify(cbCheckedIds);
    }
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
    httpRequest.open('POST','storeReuseBusiness.php',true);
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
      if(httpRequest.readyState===4 && httpRequest.status===200){
        var obj = JSON.parse(httpRequest.responseText);
        console.log(obj);
        if(obj.httpResponseCode==400){
          if(obj.response=='editFailure'){
            window.location = "reusebusinesses.php?editSuccess=False";
          }else if (obj.response=='addFailure'){
            window.location = "reusebusinesses.php?addSuccess=False";
          }
        } else{ //obj.httpResponseCode is 200
          if(obj.response=='editSuccess'){
            window.location = "reusebusinesses.php?editSuccess=True";
          } else if(obj.response=='addSuccess'){
            window.location = "reusebusinesses.php?addSuccess=True";
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
