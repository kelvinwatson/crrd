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
      <form action="main.php" method="post" class="form-horizontal">
        <fieldset>
          <legend>Login to continue</legend>
          <div class="form-group">
            <label for="inputEmail" class="col-md-2 control-label">Email</label>
            <div class="col-md-10">
              <input type="email" class="form-control" id="inputEmail" placeholder="Email">
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
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </div>
        </fieldset>
      </form>
    </div>
  </div>
  <div class="col-xs-0 col-md-3"></div>
</div><!--END ROW-->
</div> <!-- END CONTAINER -->


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
  <script src="js/bootstrap.min.js"></script>
</body>
</html>
