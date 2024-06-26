<?php
include "Connection.php";

$imagepath = filterRequest("imagepath");
$resultat = filterRequest("resultat");

$stmt=$con->prepare("UPDATE  planetes SET `resultat`=?  WHERE `image`=?");

$stmt->execute(array($resultat,$imagepath));

$count=$stmt->rowcount();

if($count>0){
    echo json_encode(array("status"=>"success")); 
}else{
    echo json_encode(array("status"=>"error"));
}

?>