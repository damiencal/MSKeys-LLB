<!DOCTYPE html>
<html lang="fr">
    <?php
        session_start();
    ?>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="MSDN LLB Keys">
    <meta name="author" content="LLB">
    <link rel="shortcut icon" href="favicon.ico">
    <title>MSKeys LLB</title>
    
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
    
    <!--Bootstrap core JavaScript-->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </head>
  <body>
    <?php if (($_SESSION['login']) and ($_SESSION['password'])){
       
        include "fonctionDB.php";
        
        connect();
    ?>
      
    <!-- MENU -->
    
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand">MSKeys LLB</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav">
                <li><a href="index.php">Accueil</a></li>
                <li class="active" ><a href="importations.php">Importations</a></li>
            </ul>
            <form class="navbar-form navbar-right" role="form" action="index.php" method="post">
                <input class="btn btn-warning" name="logout" type="submit" value="Déconnexion"></input>
            </form>
        </div><!-- /.navbar-collapse -->
    </nav>
        
    <!-- GERER LES CLEES -->

    <div class="panel panel-default">
    <!-- Default panel contents -->
        <div class="panel-heading">Tableau de clefs</div>
        <div class="panel-body">
            <form class="form-inline" role="form"
            <?php
            
            $select = "SELECT `idKey`, `key`, `utilisee`, `name` FROM `Keys` INNER JOIN Product ON Keys.idProduct = Product.idProduct";
            $result = mysql_query($select) or die("Erreur SQL SELECT");
            $row = mysql_fetch_array($result);
            list($idKey, $key, $utilisee, $name) = $row;
            
            $product = mysql_query("SELECT `name` FROM  `Product`");

            if(isset($_GET['action'])){
                if($_GET['action']=="insert"){
                    echo "?action=insert";
                }
                if($_GET['action']=="modif"){
                    echo "?numero=$_GET[numero]&action=modif";
                }
            }
            ?> action="importations.php" method="post">
                <center><div class="input-group">
                    <h3>Clé</h3><input class="form-control" type="text" name="key" value="<?php if($_GET['action']=="modif") {echo "$key";} ?>"><br>
                    <h3>Utilisée</h3><input class="form-control" type="text" name="utilisee" value="0<?php if ($_GET['action']=="modif") {echo "$utilisee";}?>"><br>
                    <h3>Nom Produit</h3>
                    <select class="btn btn-primary dropdown-toggle" name="name">
                        <? while ($tab = mysql_fetch_array($product)){ ?>
                            <option value="<?php if ($_GET['action']=="modif") {echo "$tab[name]";}?>"><?echo "$tab[name]"?></option>
                        <? } ?>
                    </select><br><br>
                    <input class="btn btn-primary" type="submit" value="Valider">
                </div></center><!-- /input-group -->
            </form>
        </div>
    </div>
    <?php } else {
        header("Location:index.php");
    } ?>
  </body>
</html>