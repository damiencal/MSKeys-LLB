<?php

// To connect to the database
function connect(){
    $hote = "10.22.50.178";
    $utilisateur = "mskeys";
    $motdepasse = "mskeysAdmin";
  
    $connexion=mysql_connect($hote, $utilisateur, $motdepasse);
    $nombdd="mskeys";
    mysql_select_db($nombdd, $connexion) or die('Connection error');
}


// To select the key
function select_key($select){
    
    $select = "SELECT key FROM mskeys WHERE key='$key';";
    
    mysql_query($select,$connexion);
    return $select;
}


// To select the OS
function select_category($select){
    
    $select = "SELECT key FROM mskeys WHERE category='$category';";
    
    mysql_query($select,$connexion);
    return $select;
}


// To add a new key
function add_key($ajout){
    
    $ajout = "INSERT INTO mskeys (category,key,used) VALUES ('$category','$key',$used);";
    
    mysql_query($ajout,$connexion);
    return $ajout;
}


// To delete a key
function delete_key($suppr){
    
    $suppr = "DELETE FROM mskeys WHERE key='$key';";
    
    mysql_query($suppr,$connexion);
    return $suppr;
}


// To delete all rows
function delete_all($suppr){
    
    $suppr = "DELETE * FROM mskeys;";
    
    mysql_query($suppr,$connexion);
    return $suppr;
}


// To update an already existing key that has been used
function update_used($update){
    
     $update = "UPDATE mskeys SET used=0 WHERE key='$key';";
     
     mysql_query($update,$connexion);
     return $update;
}


// To update an already existing category
function update_category($update){
    
     $update = "UPDATE mskeys SET category='$new_category' WHERE category='$category';";
     
     mysql_query($update,$connexion);
     return $update;
}

?>
