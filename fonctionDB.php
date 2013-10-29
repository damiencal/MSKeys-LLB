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


/* To select the key
 * 
 * Parameters : $produit is the name of the product
 */
function select_key(){
    
    $os = $_POST['OS3'];// valeurs du select option pour l'affichage des clefs
    $select_key = "SELECT `key` FROM `Keys` INNER JOIN Product ON Keys.idProduct = Product.idProduct WHERE Product.name LIKE '$os%' AND utilisee = 0  LIMIT 0,6";
    $result_key = mysql_query($select_key) or die("Erreur SQL Select");
    return $result_key;
}

/* To insert the key
 * 
 * Parameters : $produit is the name of the product, $cle is the key to insert
 */
function add_key(){
    $os = $_POST['OS2'];// valeurs du select option de l'importation manuelle
    $insertion = $_POST['insertion'];// input texte de l'ajout manuelle d'une clé
    
    $select_produit = "SELECT idProduct FROM Product WHERE name='$os';";
    $result_produit = mysql_query($select_produit);
    $row = mysql_fetch_array($result_produit);
    $idProduit = $row['idProduct'];
    
    $add_key = "INSERT INTO Keys (key,idProduct,utilisee) VALUES ('$insertion',$idProduit,false);";
    $result_key = mysql_query($select_key) or die("Erreur SQL Insert");;
    $row = mysql_fetch_array($result_key);
}

/* To update the key
 * 
 * Parameters : $idProduit is id of the product, $cle is the key to insert
 *              $utilisee is a bolean for know key that use, $key is the key to search
 */
function update_key(){
    $idKey = $_GET['idKey'];

    $update_key = "UPDATE `Keys` SET `utilisee` = '1' WHERE `Keys`.`idKey` = '$idKey'";
    mysql_query($update_key) or die("Erreur SQL Update");
    // Met à jour la base de donnée si le bouton est cliquer, la clé est utilisee et ne sera plus jamais afficher
}

/* To delete the key
 * 
 * Parameters : $idProduit is the id of the product, $cle is the key to search
 */
function delete_key($cle, $idProduit){
    $delete_key = "DELETE * FROM keys WHERE key='$key';";
    mysql_query($delete_key) or die("Erreur SQL Delete");;
}

/* Traitement de la balises ouvrantes
 * 
 * Appelée par le "parseur" 
 * Deux Parameters: l'identifiant du parseur, le nom de la balise ouvrante rencontrée.
 */
function baliseOuvrante($parseur, $nomBalise){
    global $derniereBalise;
    $derniereBalise = $nomBalise;
}

/* Traitement de la balises fermantes
 *
 * Appelée par le "parseur" 
 * Deux Parameters: l'identifiant du parseur, le nom de la balise fermante rencontrée.
 */
function baliseFermante($parseur, $nomBalise){
    global $derniereBalise;
    $derniereBalise = "";
}

/* Traitement du texte
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