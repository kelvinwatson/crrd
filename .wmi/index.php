<?php session_start();
error_reporting(E_ALL);
ini_set('display_errors',1);
ini_set('session.save_path', '../session_saver');
header('Content-Type: text/html; charset=utf-8');
include 'dbp.php';
//Always redirect user to HTTPS
if(empty($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] !== "on"){
  header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
  exit();
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

<h1>Administrator Portal</h1>

<!--LOGIN FORM-->
<div class="row">
  <div class="col-xs-0 col-md-3"></div>
  <div class="col-xs-12 col-md-6">
    <div class="well bs-component">
      <form class="form-horizontal" action="/">
        <fieldset>
          <legend>Login to continue</legend>
          <div class="form-group">
            <label for="inputUsername" class="col-md-2 control-label">Username</label>
            <div class="col-md-10">
              <input type="text" class="form-control" id="inputUsername" placeholder="Email">
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword" class="col-md-2 control-label">Password</label>
            <div class="col-md-10">
              <input type="password" class="form-control" id="inputPassword" placeholder="Password">
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-10 col-md-offset-2">
              <button type="reset" class="btn btn-default">Reset</button>
              <button type="submit" class="btn btn-primary" onclick="authenticate(); return false;">Submit</button>
            </div>
          </div>
        </fieldset>
      </form>
    </div>
  </div>
  <div class="col-xs-0 col-md-3"></div>
</div><!--END ROW-->




</div> <!-- END CONTAINER -->

<script src="js/toast.js"></script>
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script>

window.onload = function(){
  var queryStr = window.location.search;
  if(queryStr=='?authenticated=True'){
    Toast.success('User authenticated.', 'Authentication Success');
    window.location = "main.php";
  } else if(queryStr=='?authenticated=False'){
    Toast.error('Incorrect username or password', 'Authentication Failed');
  } 
}


function authenticate(){
  var userName = $('#inputUsername').val();
  var password = $('#inputPassword').val();
  if(validateInput(userName, password)){ //check for empty inputs
    //Toast.success('no empty fields','TESTING...fields OK');
    ajaxCall(userName, password);//ajax call,pass params to db
  } 
  return;
}

function ajaxCall(userName, password){
  var formData = "userName="+userName+"&userPassword="+password;
  $.ajax({
    url: "authenticateUser.php",
    type: "POST",
    data: formData,
    dataType: 'json',
    success: function(data){
      //data - response from server
      console.log(data);
      if(data.httpResponseCode==200){
        window.location = 'index.php?authenticated=True';
      } else{ //httpResponseCode is 400
        window.location = 'index.php?authenticated=False'; 
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

function validateInput(userName, password){
  console.log("Validating inputs...");
  console.log(userName+ " "+password);
  var errString=null;
  if(!userName || !password){ //empty fields
    if(!userName){
      errString="You must enter a user name. ";
    } 
    if(!password){
      errString = errString==null?"You must enter an password. " : errString+"You must enter an password. ";
    }
    Toast.error(errString,'Failed to login.');
    return false;
  } else{
    return true;
  }
}


</script>


</body>
</html>