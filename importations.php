<!DOCTYPE html>
<html lang="fr">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="MSDN LLB Keys">
    <meta name="author" content="LLB">
    <link rel="shortcut icon" href="favicon.png">
    <title>MSKeys LLB</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
  </head>
  <body>
    <? include "fonctionDB.php" ?>
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <a class="navbar-brand">MSKeys LLB</a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><a href="index.php">Accueil</a></li>
                <li class="active" ><a href="#">Importations</a></li>
            </ul>
            <form class="navbar-form navbar-right">
                <div class="form-group">
                <input type="text" placeholder="Login" class="form-control">
                </div>
                <div class="form-group">
                <input type="password" placeholder="Password" class="form-control">
                </div>
                <button type="submit" class="btn btn-success">Sign in</button>
            </form>
        </div><!--/.navbar-collapse -->
      </div>
    </div>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="container"><br><br><br><br>
        <div class="panel panel-default">
        <!-- Default panel contents -->
            <div class="panel-heading">Importations</div>
            <div class="panel-body">
            <form class="form-inline" role="form">                
                <div class="input-group">
                    <input type="file" class="form-control">
                    <span class="input-group-addon"><input type="submit" value="Ok"></input></span>
                </div>
            </form>
                  
            </div>
            <div class="alert alert-success">Réussi</div>
        </div>
        
        <div class="panel panel-default">
        <!-- Default panel contents -->
            <div class="panel-heading">Importations manuelle</div>
            <div class="panel-body">
                <div class="btn-group">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                        Dropdown
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a href="#">Dropdown link</a></li>
                    </ul>
                </div>
            </div>
            <div class="alert alert-success">Réussi</div>
        </div>
    </div>
    <footer>
        <p>© LLB 2013</p>
    </footer>
    <!--Bootstrap core JavaScript-->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
