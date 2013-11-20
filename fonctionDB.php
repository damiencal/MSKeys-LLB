<?php

// Connect to the database
function connect(){
    $hote = "10.22.50.188";
    $utilisateur = "mskeys";
    $motdepasse = "mskeysAdmin";
  
    $connexion=mysql_connect($hote, $utilisateur, $motdepasse);
    $nombdd="MSKeys";
    mysql_select_db($nombdd, $connexion) or die('Connection error');
}



/* Tableau des clées
 * 
 * 
 */
function tab_key(){
    
    $os = $_POST['OS4'];// valeurs du select option pour l'affichage des clées dans le tableau
    $select_tab_key = "SELECT `idKey`, `key`, `utilisee`, `name` FROM `Keys` INNER JOIN Product ON Keys.idProduct = Product.idProduct WHERE Product.name LIKE '$os%'";
    $result_tab_key = mysql_query($select_tab_key) or die("Erreur SQL Select_Tableau");
    
    echo "<div class='panel panel-default'>
          <!-- Default panel contents -->
          <div class='panel-heading'>Base de données</div>
            <!-- Table -->
            <table class='table'>
                <th>idKey</th> <th>Key</th> <th>Utilisee</th> <th>Name</th> <th></th> <td><a class='btn btn-default btn-lg' href='formulaire.php?action=ajout'><span class='glyphicon glyphicon-plus'></span></a></td>";

                while ($row = mysql_fetch_array($result_tab_key))
                    {
                        list($idKey, $key, $utilisee, $name) = $row;
                        echo "<tr>
                                <td>$idKey</td>
                                <td>$key</td>
                                <td>$utilisee</td>
                                <td>$name</td>
                                <td><a class='btn btn-default btn-lg' href='importations.php?idKey=$idKey&action=suppr'><span class='glyphicon glyphicon-trash'></span></a></td>
                                <td><a class='btn btn-default btn-lg' href='formulaire.php?idKey=$idKey&action=modif'><span class='glyphicon glyphicon-pencil'></span></a></td>
                            </tr>"; 
                    }
            "</table>
        </div>";
}


/* Execution des actions los du clic sur le bouton associer
 * 
 * 
 */
function action(){
        
    if($_POST['submit_ajout']){
        extract($_POST);
        add_key($name,$key);
    }

    elseif($_POST['submit_modif']){
        extract($_POST);
        update_key($name,$key,$utilisee,$old_key);
    }

    elseif($_GET['action']=="suppr"){
        delete_key();
    }
}


/* To select the key
 * 
 * Parameters : $produit is the name of the product
 * Affichage des clées dans la page index.php
 */
function select_key(){
    
    $os = $_POST['OS3'];// valeurs du select option pour l'affichage des clées
    $select_key = "SELECT `key` FROM `Keys` INNER JOIN Product ON Keys.idProduct = Product.idProduct WHERE Product.name LIKE '$os%' AND utilisee = 0  LIMIT 0,6";
    $result_key = mysql_query($select_key) or die("Erreur SQL Select");
    return $result_key;
}

function select_key_product($os){
    $result_key = mysql_query("SELECT * FROM `Keys` INNER JOIN Product ON Keys.idProduct = Product.idProduct WHERE Product.name LIKE '$os%' AND utilisee = '0'  LIMIT 0,6");
    return $result_key;
}

function select_key_limit($select_product, $os){
    $nbclef = mysql_query("SELECT * FROM `Keys` INNER JOIN Product ON Keys.idProduct = Product.idProduct WHERE Product.name LIKE '$os%' AND utilisee = '0'");
    return $nbclef;
}

function select_key_formulaire($extractKey){
    $select = mysql_query("SELECT `idKey`, `key`, `utilisee`, `name` FROM `Keys` INNER JOIN Product ON Keys.idProduct = Product.idProduct WHERE idKey=$extractKey");
    return $select;
}


/* To insert the key
 * 
 * Parameters : $produit is the name of the product, $cle is the key to insert
 */
function add_key($os,$insertion){
    $add_key = "INSERT INTO `Keys` (`key`, `utilisee`, `idProduct`) VALUES ('$insertion', 0, (SELECT `idProduct` FROM `Product` WHERE `name` = '$os'))";
    mysql_query($add_key) or die("Erreur SQL Insert");
}


/* To update the key
 * 
 * Parameters : $idProduit is id of the product, $cle is the key to insert
 *              $utilisee is a bolean for know key that use, $key is the key to search
 */
function update_key($os, $insertion, $modif, $ancienne_cle){
    $update_key = "UPDATE `Keys` SET `key` = '$insertion', `utilisee` = $modif, `idProduct` = (SELECT `idProduct` FROM `Product` WHERE `name` = '$os') WHERE `Keys`.`idKey` = $ancienne_cle";
    echo $update_key;
    mysql_query($update_key) or die("Erreur SQL Update");
    // Met à jour la base de donnée si le bouton est cliquer, la clé est utilisee et ne sera plus jamais afficher
}


/* To delete the key
 * 
 * Parameters : $idProduit is the id of the product, $cle is the key to search
 */
function delete_key(){
    $idKey = $_GET['idKey'];
    
    $delete_key = "DELETE FROM `Keys` WHERE `idKey` = $idKey";
    mysql_query($delete_key) or die("Erreur SQL Delete");;
}




////  FONCTION UTILISER POUR LE PARSAGE  ////

/* Traitement de la balises ouvrantes
 * 
 * Appelée par le "parseur" 
 * Two Parameters: l'identifiant du parseur, le nom de la balise ouvrante rencontrée.
 */
function baliseOuvrante($parseur, $nomBalise){
    global $derniereBalise;
    $derniereBalise = $nomBalise;
}

/* Traitement de la balises fermantes
 *
 * Appelée par le "parseur" 
 * Two Parameters: l'identifiant du parseur, le nom de la balise fermante rencontrée.
 */
function baliseFermante($parseur, $nomBalise){
    global $derniereBalise;
    $derniereBalise = "";
}

/* Traitement du texte parser
 * 
 * Two Parameters: l'identifiant du parseur, le texte qu'il renvoit
 */
function affichageTexte($parseur, $texte){
    global $derniereBalise;
    $os = $_POST['OS1'];// valeurs du select option de l'importation d'un fichier XML

    // Insertion dans la base de données
    switch ($derniereBalise) {
        case "KEY":// Indique le texte à prendre dans la balise "ex : <Key>texte à prendre</key>"
            $sql= "INSERT INTO `Keys` (`key`, `idProduct`, `utilisee`) VALUES ('$texte', (SELECT `idProduct` FROM `Product` WHERE name LIKE '$os%'), 0)";
            mysql_query($sql) or die("Erreur SQL Parsing");
            break;
    }
}

/* Fonction PARSAGE XML, qui fait appel au prècédente fonction
 * 
 * 
 */
function parsingXML(){
    $fichier = $_FILES['file']['tmp_name'];
            
    baliseOuvrante($parseur, $nomBalise);
    baliseFermante($parseur, $nomBalise);
    affichageTexte($parseur, $texte);

    $parseurXML = xml_parser_create();// Création du parseur XML
    xml_set_element_handler($parseurXML, "baliseOuvrante", "baliseFermante");// Indique la balise de début et de fin du fichier XML
    xml_set_character_data_handler($parseurXML, "affichageTexte");// Indique le texte à récupérer entre les balises

    $open = fopen($fichier, "r");// Ouverture du fichier en lecture
    if (!$open){ header('Location: importations.php?danger=1'); }
    
    else {

        while ( $ligneXML = fgets($open, 1024)){
            xml_parse($parseurXML, $ligneXML) or die(header('Location: importations.php?danger=2'));// Analyse le document XML ligne par ligne
        }

        xml_parser_free($parseurXML);// Met fin à l'analyse
        fclose($open);// Fermeture du fichier
        header('Location: importations.php?success=1');
    }
}

////  FIN  ////




/* Authentification MySQL
 * 
 * 
 */
function sessionConnexion(){
    
    $login = $_POST['login'];// input texte du login de connexion
    $mdp = $_POST['password'];// input texte du mot de passe de connexion
    
    if ($_POST['submit_session']){

        $select_session = "SELECT `id` FROM Admin WHERE login = '$login' AND password = MD5('$mdp')";
        $result = mysql_query($select_session) or die("Erreur SQL");

        if (mysql_num_rows($result) == "0"){
            header("Location:index.php?danger=1");
        }
        else {
            $_SESSION['login'] = $login;
            $_SESSION['password'] = $mdp;

            header("Location:index.php");
        }
    }
}
?>