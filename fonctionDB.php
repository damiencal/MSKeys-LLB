<?php

// Connect to the database
function connect(){
    $hote = "localhost";
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
function select_key($produit){
    
    $select_key = "SELECT key FROM Keys INNER JOIN Product ON Keys.idProduct = Product.idProduct WHERE Product.name='$produit' AND utilisee=false;";
    $result_key = mysql_query($select_key);
    $row = mysql_fetch_array($result_key);
    $key = $row['key'];
    return $key;
}

/* To insert the key
 * 
 * Parameters : $produit is the name of the product, $cle is the key to insert
 */
function add_key($produit, $cle){
    
    $select_produit = "SELECT idProduct FROM Product WHERE name='$produit';";
    $result_produit = mysql_query($select_produit);
    $row = mysql_fetch_array($result_produit);
    $idProduit = $row['idProduct'];
    
    $add_key = "INSERT INTO Keys (key,idProduct,utilisee) VALUES ('$cle',$idProduit,false);";
    $result_key = mysql_query($select_key);
    $row = mysql_fetch_array($result_key);
}

/* To update the key
 * 
 * Parameters : $idProduit is id of the product, $cle is the key to insert
 *              $utilisee is a bolean for know key that use, $key is the key to search
 */
function update_key($cle, $idProduit, $utilisee, $key){
    
    $select_key = "SELECT * FROM Keys WHERE key='$key';";
    $result_key = mysql_query($select_key);
    $row = mysql_fetch_array($result_key);
    $key = $row['key'];
    return $key;
    
    $update_key = "UPDATE Keys SET key='$cle',idProduct='$idProduit',utilisee=$utilisee WHERE key='$key';";
    
}

/* To delete the key
 * 
 * Parameters : $idProduit is the id of the product, $cle is the key to search
 */
function delete_key($cle, $idProduit){
    $delete_key = "DELETE * FROM keys WHERE key='$key';";
    mysql_query($delete_key);
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
    $os = $_POST['OS'];

    // Insertion dans la base de données
    switch ($derniereBalise) {
        case "KEY":// Indique le texte à prendre dans la balise "ex : <Key>texte à prendre</key>"
            $sql= "INSERT INTO `Keys`(`key`, `idProduct`) VALUES ('$texte', (SELECT `idProduct` FROM `Product` WHERE name LIKE '$os%'))";
            mysql_query($sql) or die();
            break;
    }
}

function sessionConnexion(){
    
    $login = $_POST['Login'];
    $mdp = $_POST['Password'];
    
    $select_session = "SELECT id FROM Users WHERE login='$login' AND password='".md5($mdp)."'";
    $result = mysql_query($select_session) or die("Erreur SQL");
    
    if (mysql_num_rows($result) == "0")
    {
        echo "Erreur de connexion.";
    }
    else
    {
        $_SESSION['Login'] = $login;
        $_SESSION['Password'] = $mdp;
        
        header("Location:index.php");
    }
}
?>