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
    $select ="SELECT * FROM articles WHERE nom = Jean-Damien";
    mysql_query($select,$connexion);
    return $select;
}
    
function ajout($ajout){
    $ajout = "INSERT INTO breve SET rubrique=''";
    mysql_query($ajout,$connexion);
    return $ajout;
}

function suppr($suppr){
    $suppr = "DELETE FROM auteur WHERE nom='Marie Dacquay'";
    mysql_query($suppr,$connexion);
    return $suppr;
}

function update($update){
     $update = "UPDATE auteur SET =''";
     mysql_query($update,$connexion);
     return $update;
}

?>
