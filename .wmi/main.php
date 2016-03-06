<?php session_start();
error_reporting(E_ALL);
ini_set('display_errors',1);
ini_set('session.save_path', '../session_saver');
header('Content-Type: text/html; charset=utf-8');
include 'dbp.php';

if(!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn']){
  header('Location: index.php');
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
            <li><a href="repairItems.php">Items</a></li>
            <li role="separator" class="divider"></li>
            <li class="dropdown-header">USERS</li>
            <li><a href="users.php">Users</a></li>
          </ul>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-asterisk" style="color:#7FFF00"></span> Logged In (<?php echo $_SESSION['username']; ?>)<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="logout.php"><span class="glyphicon glyphicon-off"></span>  Logout</a></li>
          </ul>
        </li>
      </ul>
    </div><!--/.nav-collapse -->
  </div>
</nav>

<div class="container">
  <h1>Administrator Portal</h1>
  <div class="row">
    <div class="col-md-6">
      <div class="panel panel-warning">
        <div class="panel-heading">
          <h3 class="panel-title">Manage REUSE Content</h3>
        </div>
        <div id="reuse-panel-body" class="panel-body">

          <h4>Reuse Businesses</h4>
          <div class="list-group">
            <a href="reusebusinesses.php" class="list-group-item">
              <div class="row">
                <div class="col-xs-1" style="margin-top:10px;">
                  <span class="glyphicon glyphicon-eye-open"></span>
                </div>
                <div class="col-xs-11">
                  <h4 class="list-group-item-heading">View businesses</h4>
                  <p class="list-group-item-text">View existing businesses in the database.</p>
                </div>
              </div>
            </a>
            <a href="reusebusinesses.php#add" class="list-group-item">
        			<div class="row">
        				<div class="col-xs-1">
        					<span class="glyphicon glyphicon-plus" style="margin-top:10px;"></span>
        				</div>
        				<div class="col-xs-11">
        					<h4 class="list-group-item-heading">Add business</h4>
        					<p class="list-group-item-text">Create a new business and add it to the database.</p>
        				</div>
          		</div>
            </a>
            <a href="reusebusinesses.php" class="list-group-item">
              <div class="row">
                <div class="col-xs-1" style="margin-top:10px;">
                  <span class="glyphicon glyphicon-pencil"></span>
                </div>
                <div class="col-xs-11">
                  <h4 class="list-group-item-heading">Edit business</h4>
                  <p class="list-group-item-text">Edit existing business information.</p>
                </div>
              </div>
            </a>
            <a href="removereusebusinesses.php" class="list-group-item">
              <div class="row">
                <div class="col-xs-1" style="margin-top:10px;">
                  <span class="glyphicon glyphicon-remove"></span>
                </div>
                <div class="col-xs-11">
                  <h4 class="list-group-item-heading">Remove business</h4>
                  <p class="list-group-item-text">Delete a business from the database.<br>
                  <em style="color:red">Warning: Deletions are irreversible.</em></p>
                </div>
              </div>
            </a>
          </div>

          <h4>Reuse Item Categories</h4>
          <div class="list-group">
            <a href="reusecategories.php" class="list-group-item">
              <div class="row">
                <div class="col-xs-1" style="margin-top:10px;">
                  <span class="glyphicon glyphicon-eye-open"></span>
                </div>
                <div class="col-xs-11">
                  <h4 class="list-group-item-heading">View item categories</h4>
                  <p class="list-group-item-text">View existing item categories in the database.</p>
                </div>
              </div>
            </a>
            <a href="reusecategories.php#add" class="list-group-item">
              <div class="row">
                <div class="col-xs-1">
                  <span class="glyphicon glyphicon-plus" style="margin-top:10px;"></span>
                </div>
                <div class="col-xs-11">
                  <h4 class="list-group-item-heading">Add category</h4>
                  <p class="list-group-item-text">Create a category and add it to an existing category list.</p>
                </div>
              </div>
            </a>
            <!--<a class="list-group-item">
        			<div class="row">
        				<div class="col-xs-1">
        					<span class="glyphicon glyphicon-plus" style="margin-top:10px;"></span>
        				</div>
        				<div class="col-xs-11">
        					<h4 class="list-group-item-heading">Add item category</h4>
        					<p class="list-group-item-text">Create a new item category.</p>
        				</div>
          		</div>
            </a>
            <a class="list-group-item">
              <div class="row">
                <div class="col-xs-1" style="margin-top:10px;">
                  <span class="glyphicon glyphicon-pencil"></span>
                </div>
                <div class="col-xs-11">
                  <h4 class="list-group-item-heading">Edit item category</h4>
                  <p class="list-group-item-text">Edit an existing item category.</p>
                </div>
              </div>
            </a>
            <a class="list-group-item">
              <div class="row">
                <div class="col-xs-1" style="margin-top:10px;">
                  <span class="glyphicon glyphicon-remove"></span>
                </div>
                <div class="col-xs-11">
                  <h4 class="list-group-item-heading">Remove item category</h4>
                  <p class="list-group-item-text">Delete an item category from the database.<span class="text-warning">Warning: removing a category removes all items within a category, and removes
                  those items from businesses that currently accept those items.</span></p>
                </div>
              </div>
            </a>-->
          </div>

          <h4>Reuse Items</h4>
          <div class="list-group">
            <a href="reuseitems.php" class="list-group-item">
              <div class="row">
                <div class="col-xs-1" style="margin-top:10px;">
                  <span class="glyphicon glyphicon-eye-open"></span>
                </div>
                <div class="col-xs-11">
                  <h4 class="list-group-item-heading">View items</h4>
                  <p class="list-group-item-text">View existing items in the database.</p>
                </div>
              </div>
            </a>
            <a href="reuseitems.php#add" class="list-group-item">
              <div class="row">
                <div class="col-xs-1">
                  <span class="glyphicon glyphicon-plus" style="margin-top:10px;"></span>
                </div>
                <div class="col-xs-11">
                  <h4 class="list-group-item-heading">Add item</h4>
                  <p class="list-group-item-text">Create a new item and add it to an existing item category.</p>
                </div>
              </div>
            </a>
            <!--<a class="list-group-item">
              <div class="row">
                <div class="col-xs-1" style="margin-top:10px;">
                  <span class="glyphicon glyphicon-pencil"></span>
                </div>
                <div class="col-xs-11">
                  <h4 class="list-group-item-heading">Edit item</h4>
                  <p class="list-group-item-text">Edit the name of an existing item.</p>
                </div>
              </div>
            </a>
            <a class="list-group-item">
              <div class="row">
                <div class="col-xs-1" style="margin-top:10px;">
                  <span class="glyphicon glyphicon-remove"></span>
                </div>
                <div class="col-xs-11">
                  <h4 class="list-group-item-heading">Remove item</h4>
                  <p class="list-group-item-text">Delete an item from the database.<span class="text-warning">Warning: removing an item removes it from all business that accept that item.</span></p>
                </div>
              </div>
            </a>-->
          </div>

        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="panel panel-info">
        <div class="panel-heading">
          <h3 class="panel-title">Manage REPAIR Content</h3>
        </div>
        <div id="repair-panel-body" class="panel-body">


          <h4>Repair Businesses</h4>
          <div class="list-group">
            <a href="repairbusinesses.php" class="list-group-item">
              <div class="row">
                <div class="col-xs-1" style="margin-top:10px;">
                  <span class="glyphicon glyphicon-eye-open"></span>
                </div>
                <div class="col-xs-11">
                  <h4 class="list-group-item-heading">View businesses</h4>
                  <p class="list-group-item-text">View existing businesses in the database.</p>
                </div>
              </div>
            </a>
            <a href="repairbusinesses.php#add" class="list-group-item">
        			<div class="row">
        				<div class="col-xs-1">
        					<span class="glyphicon glyphicon-plus" style="margin-top:10px;"></span>
        				</div>
        				<div class="col-xs-11">
        					<h4 class="list-group-item-heading">Add business</h4>
        					<p class="list-group-item-text">Create a new business and add it to the database.</p>
        				</div>
          		</div>
            </a>
            <a href="repairbusinesses.php" class="list-group-item">
              <div class="row">
                <div class="col-xs-1" style="margin-top:10px;">
                  <span class="glyphicon glyphicon-pencil"></span>
                </div>
                <div class="col-xs-11">
                  <h4 class="list-group-item-heading">Edit business</h4>
                  <p class="list-group-item-text">Edit existing business information.</p>
                </div>
              </div>
            </a>
            <a href="removerepairbusinesses.php" class="list-group-item">
              <div class="row">
                <div class="col-xs-1" style="margin-top:10px;">
                  <span class="glyphicon glyphicon-remove"></span>
                </div>
                <div class="col-xs-11">
                  <h4 class="list-group-item-heading">Remove business</h4>
                  <p class="list-group-item-text">Delete a business from the database.<br>
                  <em style="color:red">Warning: Deletions are irreversible.</em></p>
                </div>
              </div>
            </a>
          </div>


          <h4>Repair Items</h4>
          <div class="list-group">
            <a href="repairItems.php" class="list-group-item">
              <div class="row">
                <div class="col-xs-1" style="margin-top:10px;">
                  <span class="glyphicon glyphicon-eye-open"></span>
                </div>
                <div class="col-xs-11">
                  <h4 class="list-group-item-heading">View items</h4>
                  <p class="list-group-item-text">View existing items in the database.</p>
                </div>
              </div>
            </a>
            <a href="repairItems.php#add" class="list-group-item">
              <div class="row">
                <div class="col-xs-1">
                  <span class="glyphicon glyphicon-plus" style="margin-top:10px;"></span>
                </div>
                <div class="col-xs-11">
                  <h4 class="list-group-item-heading">Add item</h4>
                  <p class="list-group-item-text">Create a new item and add it to an existing item category.</p>
                </div>
              </div>
            </a>
<!--            <a href="repairitems.php" class="list-group-item">
              <div class="row">
                <div class="col-xs-1" style="margin-top:10px;">
                  <span class="glyphicon glyphicon-pencil"></span>
                </div>
                <div class="col-xs-11">
                  <h4 class="list-group-item-heading">Edit item</h4>
                  <p class="list-group-item-text">Edit the name of an existing item.</p>
                </div>
              </div>
            </a>-->
          </div>

        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="panel panel-success">
        <div class="panel-heading">
          <h3 class="panel-title">Manage Authorized USERS</h3>
        </div>
        <div id="users-panel-body" class="panel-body">

          <h4>Users</h4>
          <div class="list-group">
            <a href="users.php" class="list-group-item">
              <div class="row">
                <div class="col-xs-1" style="margin-top:10px;">
                  <span class="glyphicon glyphicon-eye-open"></span>
                </div>
                <div class="col-xs-11">
                  <h4 class="list-group-item-heading">View users</h4>
                  <p class="list-group-item-text">View existing users.</p>
                </div>
              </div>
            </a>
            <a href="users.php#add" class="list-group-item">
              <div class="row">
                <div class="col-xs-1">
                  <span class="glyphicon glyphicon-plus" style="margin-top:10px;"></span>
                </div>
                <div class="col-xs-11">
                  <h4 class="list-group-item-heading">Add a new user</h4>
                  <p class="list-group-item-text">Create a new user account.</p>
                </div>
              </div>
            </a>
            <a href="users.php" class="list-group-item">
              <div class="row">
                <div class="col-xs-1" style="margin-top:10px;">
                  <span class="glyphicon glyphicon-pencil"></span>
                </div>
                <div class="col-xs-11">
                  <h4 class="list-group-item-heading">Edit user</h4>
                  <p class="list-group-item-text">Edit an existing user.</p>
                </div>
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div><!-- END CONTAINER -->

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
  <script src="js/bootstrap.min.js"></script>
  </body>
</html>
