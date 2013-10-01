<?php
function connect(){
    $hote = "10.22.50.178";
    $utilisateur = "mskeys";
    $motdepasse = "mskeysAdmin";
  
    $connexion=mysql_connect($hote, $utilisateur, $motdepasse);
    $nombdd="mskeys";
    mysql_select_db($nombdd, $connexion);
}

function select($select){
    mysql_query($select,$connexion);
    return $select;
}
    
function ajout($ajout){
    mysql_query($ajout,$connexion);
    return $ajout;
}

function suppr($suppr){
    mysql_query($suppr,$connexion);
    return $suppr;
}

function update($update){
     $update = "UPDATE";
     mysql_query($update,$connexion);
     return $update;
}

?>
