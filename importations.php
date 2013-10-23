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
    <link rel="shortcut icon" href="favicon.png">
    <title>MSKeys LLB</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
  </head>
  <body>
    <? if (($_SESSION['login']) and ($_SESSION['password'])){
       
        include "fonctionDB.php";
        
        connect();
        
        if(isset($_POST['submit_import'])){
            
            $fichier = $_FILES['file']['tmp_name'];
            
            baliseOuvrante($parseur, $nomBalise);
            baliseFermante($parseur, $nomBalise);
            affichageTexte($parseur, $texte);
            
            $parseurXML = xml_parser_create();// Création du parseur XML
            xml_set_element_handler($parseurXML, "baliseOuvrante", "baliseFermante");// Indique la balise de début et de fin du fichier XML
            xml_set_character_data_handler($parseurXML, "affichageTexte");// Indique le texte à récupérer entre les balises

            $open = fopen($fichier, "r");// Ouverture du fichier en lecture
            if (!$open) die("Impossible d'ouvrir le fichier XML");

            while ( $ligneXML = fgets($open, 1024)){
                xml_parse($parseurXML, $ligneXML) or die("Erreur XML");// Analyse le document XML ligne par ligne
            }

            xml_parser_free($parseurXML);// Met fin à l'analyse
            fclose($open);// Fermeture du fichier
            header('Location: importations.php?success=1'); die;
        }
        
        if(isset($_POST['ajout'])){
            add_key();
            header('Location: importations.php?success=2'); die;
        }
    ?>
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
            <form class="navbar-form navbar-right" role="form" action="index.php" method="post">
                <input class="btn btn-warning" name="logout" type="submit" value="Déconnexion"></input>
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
                ?><div class="alert alert-success">Importation réussi</div><?
            }
            ?>
        </div>
        
        <div class="panel panel-default">
        <!-- Default panel contents -->
            <div class="panel-heading">Importations manuelle</div>
            <div class="panel-body">
                <form class="form-inline" role="form" method="post">
                    <div class="col-lg-6">
                        <div class="input-group">
                            <div class="input-group-btn">
                                <select class="btn btn-primary dropdown-toggle" name="OS2"> 
                                    <option value="Windows 7 Professional" selected="selected">Windows 7</option>
                                    <option value="Windows 8">Windows 8</option>
                                    <option value="Windows Server 2008">Windows Server 2008</option>
                                <select>
                            </div>
                            <input name="insertion" type="text" class="form-control">
                            <span class="input-group-btn"><input name="submit_ajout" class="btn btn-primary" type="submit" value="Ajouter"></input></span>
                        </div><!-- /input-group -->
                    </div><!-- /.col-lg-6 -->
                </form>
            </div>
            <?
            if($_GET[success] == "2"){
                ?><div class="alert alert-success">Importation manuelle réussi</div><?
            }
            ?>
        </div>
    </div>
    <footer>
        <p>© LLB 2013</p>
    </footer>
    <!--Bootstrap core JavaScript-->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <? } else {
        header("Location:index.php");
    } ?>
  </body>
</html>