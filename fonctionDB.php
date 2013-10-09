<?php

// To connect to the database
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
function select_key($produit){
    
    $select_key = "SELECT key FROM Keys INNER JOIN Product ON Keys.idProduct = Product.idProduct WHERE Product.name='$produit' AND utilisee=false;";
    $result_key = mysql_query($select_key);
    $row = mysql_fetch_array($result_key);
    $key = $row['key'];
    return $key;
}

/* To delete the key
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

/*
 * 
 * 
 */
function update_key($cle, $idProduit, $utilisee, $key){
    
    $select_key = "SELECT * FROM Keys WHERE key='$key';";
    $result_key = mysql_query($select_key);
    $row = mysql_fetch_array($result_key);
    $key = $row['key'];
    return $key;
    
    $update_key = "UPDATE Keys SET key='$cle',idProduct='$idProduit',utilisee=$utilisee WHERE key='$key';";
    
}

/*
 * 
 * 
 */
function delete_key($cle, $idProduit){
    $delete_key = "DELETE * FROM keys WHERE key='$key';";
    mysql_query($delete_key);
}

?>