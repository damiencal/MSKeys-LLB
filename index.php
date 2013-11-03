<!DOCTYPE html>
<html lang="fr">
    <?php
        session_start();

        include "fonctionDB.php";

        if ($_POST['logout']) {
            session_destroy();
            header("Location:index.php");
        }
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
    <?    
    connect();
    sessionConnexion();
    ?>
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
                <li class="active"><a href="index.php">Accueil</a></li>
                <li><a href="importations.php">Importations</a></li>
            </ul>
            <? 
            if (($_SESSION['login']) and ($_SESSION['password'])){
                ?><form class="navbar-form navbar-right" role="form" action="index.php" method="post">
                    <input class="btn btn-warning" name="logout" type="submit" value="Déconnexion"></input>
                </form><?
            } else {?>
            <form class="navbar-form navbar-right" role="form" action="index.php" method="post">
                <div class="form-group">
                <input name="login" type="text" placeholder="Login" class="form-control">
                </div>
                <div class="form-group">
                <input name="password" type="password" placeholder="Password" class="form-control">
                </div>
                <input name="submit_session" type="submit" class="btn btn-success">Connexion</input>
            </form>
            <?}?>
        </div><!--/.navbar-collapse -->
      </div>
    </div>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
        <div class="container">
            <?if (($_SESSION['login']) AND ($_SESSION['password'])){ ?>
                <center><h3>Veuillez faire une recherche en fonction de la clef du Système d'Exploitation</h3>
                <form class="form-inline" role="form" method="post">
                    <select class="btn btn-info dropdown-toggle" name="OS3"> 
                        <option value="Windows 7 Professional" selected="selected">Windows 7</option>
                        <option value="Windows 8">Windows 8</option>
                        <option value="Windows Server 2008">Windows Server 2008</option>
                    <select>
                    <input class="btn btn-info" type="submit" name="submit_option" value="Valider"></input>
                </form></center><br>
                <?if($_GET[success] == "1"){
                    ?><div class="alert alert-success"><center>Réussi</center></div>
                    <script>window.location='index.php'</script><?
                }?>
            <? if ($_POST['submit_option']){
                
                    $os = $_POST['OS3'];// valeurs du select option pour l'affichage des clefs
                    $result_key = mysql_query("SELECT * FROM `Keys` INNER JOIN Product ON Keys.idProduct = Product.idProduct WHERE Product.name LIKE '$os%' AND utilisee = '0'  LIMIT 0,6");
                    $nbclef = mysql_query("SELECT * FROM `Keys` INNER JOIN Product ON Keys.idProduct = Product.idProduct WHERE Product.name LIKE '$os%' AND utilisee = '0'");
                    $nb = mysql_num_rows($nbclef);
                    
                    if (mysql_num_rows($nbclef) != ""){
                        ?><form class="form-inline" role="form" method="get">
                            <table class="table">
                                <div class="panel panel-primary">
                                <div class="panel-heading"><center><? echo $os; ?></center></div><?

                                while ($row = mysql_fetch_array($result_key)){
                                    list($idKey, $key, $idProduct, $utilisee) = $row;?>
                                    <div class="col-lg-6">
                                        <div class="input-group">
                                            <input type="text" name="key" value="<? echo $key; ?>" class="form-control" readonly>
                                            <span class="input-group-btn">
                                                <a class="btn btn-info" 
                                                   onClick="email = prompt('Veulliez rentrer votre email pour recevoir la clef');
                                                            if (confirm('Est se que votre email est bon ?\n\n' + email)){
                                                                location.href='index.php?idKey=<?echo $idKey?>&action=clef&success=1&email='+ email;
                                                            }else{
                                                                alert('Votre email est mauvais');
                                                            }">Obtenir</a>
                                            </span>
                                        </div><!-- /input-group -->
                                    </div><!-- /.col-lg-6 --><?
                                }?>
                                </div>
                            </table>
                        </form>
                        <center><h4 class="text-warning">Copier la clef puis cliquez sur le bouton utiliser</h4><?
                        echo "$nb clefs $os non utilisées";?></center><?
                    }
                    else {
                        ?><center><h4 class="text-warning">Aucune clef(s) trouver</h4></center><?
                    }
                }
                
                if(isset($_GET['action'])){
                    if($_GET['action']=="clef"){
                        
                        // Please specify your Mail Server - Example: mail.example.com.
                        ini_set("SMTP","ssl://smtp.gmail.com");
                        
                        // Please specify an SMTP Number 25 and 8889 are valid SMTP Ports.
                        ini_set("smtp_port","465");
                        ini_set("smtp_crypto","tls");

                        // Please specify the return address to use
                        ini_set('sendmail_from', 'lastennet.l@gmail.com');
                        
                        mail($_GET['email'], "Sujet", "Votre clef");
                        
                        update_key();
                    }
                }
            }
            
            else {
                if($_GET[danger] == "1"){
                    ?><div class="alert alert-danger">Veuillez réessayer l'authentification</div><?
                }
                else {?>
                    <h1>Bienvenue</h1>
                    <h3>Veuillez vous authentifier pour avoir accès au clé de Microsoft</h3<? 
                }
            }?>
    </div> <!-- /jumbotron -->
  </body>
  <footer>
      <p>© LLB 2013</p>
  </footer>
</html>
