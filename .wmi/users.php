<?php session_start();
error_reporting(E_ALL);
ini_set('display_errors',1);
ini_set('session.save_path', '../session_saver');
header('Content-Type: text/html; charset=utf-8');
include 'dbp.php';

/* Always redirect user to HTTPS */
if(empty($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] !== "on"){
  header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
  exit();
}

/* CONNECT TO DATABASE */
$mysqli = new mysqli('oniddb.cws.oregonstate.edu', 'watsokel-db', $dbpass, 'watsokel-db');
if ($mysqli->connect_errno) {
  echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

//verify that the user is authorized to be here, using sessions:

//

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
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/navbar-fixed-top.css" rel="stylesheet">
    <link href="css/toast.css" rel="stylesheet">
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
        <li><a href="http://sustainablecorvallis.org/" target="_blank">About</a></li>
        <li><a href="http://sustainablecorvallis.org/contact/" target="_blank">Contact</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">

      </ul>
    </div><!--/.nav-collapse -->
  </div>
</nav>



<div class="container">

<h1>Administrator Portal: Manage Users</h1>

  <div class="row"> <!--START VIEW TABLE ROW -->
    <h3>View Current Users</h3>
    <div class="table-responsive">
      <table class="table">
        <thead>
            <tr>
              <th>Edit</th>
              <th>Username</th>
              <th>Email</th>
            </tr>
          </thead>
          <tbody>
            <?php

            //display table of users
            if (!($stmt = $mysqli->prepare(
              "SELECT u.id, u.username, u.email, u.password FROM users u ORDER BY u.username ASC"))) {
              echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
            }
            if (!$stmt->execute()) {
              echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            }
            if(!$stmt->bind_result($uID,$uName,$uEmail,$uPassword)){
              echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqlii->connect_error;
            }
            while($stmt->fetch()){
              echo 
              "<tr>
                <form action=\"users.php#edit\" method=\"post\">
                  <td style=\"padding-left:0px;\"><input class=\"btn btn-warning\" type=\"submit\" value=\"edit\"><input type=\"hidden\" name=\"user-id\" value=\"$uID\"></td>
                  <td>".$uName."<input type=\"hidden\" name=\"user-name\" value=\"".$uName."\"></td>
                  <td>".$uEmail."<input type=\"hidden\" name=\"user-email\" value=\"".$uEmail."\"></td>
                  <input type=\"hidden\" name=\"user-password\" value=\"$uPassword\">
                  <input type=\"hidden\" name=\"user-action\" value=\"edit-user\">
                </form>
              </tr>";              
            }
            $stmt->close();
            ?>
          </tbody>
      </table>
    </div>
  </div><!--END VIEW USERS ROW-->
  
  <div id="edit"></div>
  <div class="row"><!--EDIT ROW-->

  <?php if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['user-action'])):?>
    <?php if($_POST['user-action']=='edit-user'):?>
      <h3 style="padding-top: 70px;">Edit Existing User</h3>
      <form class="form-horizontal" action="/">

        <div class="form-group">
        <label for="uName" class="col-sm-2 control-label">Username</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="uName" value="<?php echo htmlspecialchars($_POST['user-name']); ?>" required>
        </div>
        </div>

        <div class="form-group">
        <label for="uEmail" class="col-sm-2 control-label">Street</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="uEmail" value="<?php echo htmlspecialchars($_POST['user-email']); ?>">
        </div>
        </div>

        <div class="form-group">
        <label for="uPassword" class="col-sm-2 control-label">Password</label>
        <div class="col-sm-10">
          <!-- Not sure if this should be prepopulated -->
          <!--should be <input type="text" class="form-control" id="uPassword" value="<?php //echo htmlspecialchars($_POST['user-password']);?>">-->
          <input type="text" class="form-control" id="uPassword" value="<?php echo htmlspecialchars($_POST['user-password']); ?>">
        </div>
        </div>


      <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
          <input type="hidden" id="uId" value="<?php echo htmlspecialchars($_POST['user-id']); ?>">
          <button type="button" class="btn btn-primary" onclick="manageUser('edit'); return false;">Confirm Edit</button>
        </div>
      </div>
      </form>
      <hr style="width: 100%; color: black; height: 1px; background-color:#d3d3d3;" />
      <br><br>

    <?php endif; ?>
   <?php endif; ?>

  </div><!--END EDIT ROW-->  
  

<!--CREATE USER FORM-->
<a id="add"></a>
<div class="row">
      <form class="form-horizontal" action="/">
        <fieldset>
          <legend>Create a New User</legend>
          <div class="form-group">
            <label for="inputUsername" class="col-sm-2 control-label">Username</label>
            <div class="col-sm-10">
              <input type="username" class="form-control" id="inputUsername" placeholder="Username" required>
            </div>
          </div>
          <div class="form-group">
            <label for="inputEmail" class="col-sm-2 control-label">Email</label>
            <div class="col-sm-10">
              <input type="email" class="form-control" id="inputEmail" placeholder="Email" required>
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword" class="col-sm-2 control-label">Password</label>
            <div class="col-sm-10">
              <input type="password" class="form-control" id="inputPassword" placeholder="Password" required>
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-10 col-md-offset-2">
              <button type="reset" class="btn btn-default">Reset</button>
              <button type="submit" class="btn btn-primary" onclick="manageUser('add'); return false;">Submit</button>
            </div>
          </div>
        </fieldset>
      </form>
  </div>
  <div class="col-xs-0 col-md-3"></div>
</div><!--END ROW-->




</div> <!-- END CONTAINER -->

<script src="js/toast.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script>
Toast.defaults.width='600px';
Toast.defaults.displayDuration=4000;    

window.onload = function(){
  var queryStr = window.location.search;
  if(queryStr=='?editSuccess=True'){
    Toast.success('User editted successfully.', 'Edit Confirmation');
  } else if(queryStr=='?editSuccess=False'){
    Toast.error('There was an error in one or more of your inputs!', 'Edit Failed');
  } else if(queryStr=='?addSuccess=True'){
    Toast.success('User added successfully.', 'Add Confirmation');
  }else if(queryStr=='?addSuccess=False'){
    Toast.error('There was an error in one or more of your inputs.', 'Add Failed');
  }
}

function manageUser(action) { 
  if(action=='add'){
    console.log("add user");
    var userName = $('#inputUsername').val(); 
    var email = $('#inputEmail').val();
    var password = $('#inputPassword').val();    var params = [userName,email,password];
    if(validateInput(userName, email, password)){ //check for empty inputs
      ajaxCall('add', params);//ajax call,pass params to db
    } 
    return;
  } else if(action=='edit'){
    console.log("edit user");
    var userId = $('#uId').val();
    var userName = $('#uName').val();
    var email = $('#uEmail').val();
    var password = $('#uPassword').val();
    var params = [userId,userName,email,password];
    if(validateInput(userName, email, password)){ //check for empty inputs
      ajaxCall('edit', params);//ajax call,pass params to db
    } 
  }
}

function ajaxCall(action, params){
  if(action=='add'){
    var formData = "userAction=add&userName="+params[0]+"&userEmail="+params[1]+"&userPassword="+params[2];
  } else{
    var formData = "userAction=edit&userId="+params[0]+"&userName="+params[1]+"&userEmail="+params[2]+"&userPassword="+params[3];
  }
  $.ajax({
    url: "storeUser.php",
    type: "POST",
    data: formData,
    dataType: 'json',
    success: function(data){
      //data - response from server
      console.log(data);
      if(data.httpResponseCode==200){
        if(data.response=='addSuccess'){
          window.location = 'users.php?addSuccess=True';
        } else if (data.response=='addFailure'){
          window.location = 'users.php?addSuccess=False';
        } else if (data.response=='editSuccess'){
          window.location = 'users.php?editSuccess=True';  
        } else if (data.response=='editFailure'){
          window.location = 'users.php?editSuccess=False';
        }
      } else{ //httpResponseCode is 400
        if(data.response=='addFailure'){
          window.location = 'users.php?addSuccess=False';
        } else if (data.response=='editFailure'){
          window.location = 'users.php?editSuccess=False';
        }
        
      }
        
    },
    error: function (jqXHR, textStatus, errorThrown){
      console.log("==AJAX ERR==");
      console.log(jqXHR);
      console.log(textStatus);
      console.log(errorThrown);
    }
  });
}

function validateInput(userName, email, password){
    console.log("Validating inputs...");
    console.log(userName+ " "+email+" "+password);
    debugger;
    var errString=null;
    if(!userName || !email || !password){ //empty fields
      if(!userName){
        errString="You must enter a user name. ";
      } 
      if(!email) {
        errString = errString==null? "You must enter an email address. " : errString+"You must enter an email address. ";
      }
      if(!password){
        errString = errString==null?"You must enter an password. " : errString+"You must enter an password. ";
      }
      Toast.error(errString,'Failed to add user');
      return false;
  } else{
    return true;
  }
}

</script>
</body>
</html>
