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
    <!--<link href="//netdna.bootstrapcdn.com/bootswatch/3.0.0/cosmo/bootstrap.min.css" rel="stylesheet">
    
    <!--Bootstrap core JavaScript-->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </head>
  <body>
    <? if (($_SESSION['login']) and ($_SESSION['password'])){
       
        include "fonctionDB.php";
        
        connect();
        
        if(isset($_POST['submit_import'])){
            parsingXML();// Fonction de parsage XML, importations automatique des clées
        }
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
    
    
    
    <!-- IMPORTATIONS XML -->

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="container"><br><br><br><br>
        <div class="panel panel-default">
        <!-- Default panel contents -->
            <div class="panel-heading">Importations XML</div>
            <div class="panel-body">
            <form class="form-inline" role="form" enctype="multipart/form-data" method="post">
                <div class="input-group">
                    <div class="input-group-btn">
                        <select class="btn btn-primary dropdown-toggle" name="OS1"> 
                            <option value="Windows 7 Professional" selected="selected">Windows 7</option>
                            <option value="Windows 8">Windows 8</option>
                            <option value="Windows Server 2008">Windows Server 2008</option>
                        <select>
                    </div>
                    <input type="file" name="file" class="form-control">
                    <span class="input-group-btn"><input name="submit_import" class="btn btn-primary" type="submit" value="Envoyer"></input></span>
                </div>
            </form>
            </div>
            <?
            if($_GET[success] == "1"){
                ?><div class="alert alert-success">Importation réussi</div>
                    <script>window.location='importations.php'</script><?
            } elseif ($_GET[danger] == "1") { ?><div class="alert alert-danger">Importation echoué</div>
                <script>window.location='importations.php'</script><? }
            ?>
        </div>
        
        
        
        <!-- GERER LES CLEES -->
        
        <div class="panel panel-default">
        <!-- Default panel contents -->
            <div class="panel-heading">Tableau de clefs</div>
            <div class="panel-body">
                <form class="form-inline" role="form" method="post">
                    <div class="input-group">
                        <div class="input-group-btn">
                            <select class="btn btn-primary dropdown-toggle" name="OS4"> 
                                <option value="Windows 7 Professional" selected="selected">Windows 7</option>
                                <option value="Windows 8">Windows 8</option>
                                <option value="Windows Server 2008">Windows Server 2008</option>
                            <select>
                            <input name="submit_tab" class="btn btn-primary" type="submit" value="Valider"></input>
                        </div>
                    </div><!-- /input-group -->
                </form>
            </div>
            <?if(isset($_POST['submit_tab'])){
                tab_key();// Fonction d'ajout manuelle d'une clée
                
                if(isset($_GET['action'])){
                    if($_GET['action']=="action"){
                        echo "action";
                    }
                    if($_GET['action']=="modif"){
                        echo "modif";
                    }
                    if($_GET['action']=="suppr"){
                        echo "suppr";
                    }
                }
            }?>
        </div>
    <? } else {
        header("Location:index.php");
    } ?>
  </body>
</html>