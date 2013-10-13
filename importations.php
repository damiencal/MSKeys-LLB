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
  <body><br><br><br>
    <? include "fonctionDB.php";
    
        connect();
        
        $xmlfile = $_FILES['file']['name'];
        
        if(isset($_POST['submit'])){
            
            $fichier = $xmlfile;
            
            baliseOuvrante($parseur, $nomBalise, $tableauAttributs);
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
            <form class="form-inline" role="form" enctype="multipart/form-data" method="post">
                <select name="OS"> 
                    <option value="Windows7" selected="selected">Windows 7</option>
                    <option value="Windows8">Windows 8</option>
                    <option value="WindowsServer">Windows Server</option>
                <select>
                <div class="input-group">
                    <input type="file" name="file" class="form-control">
                    <span class="input-group-addon"><input type="submit" name="submit" value="Envoyer"></input></span>
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