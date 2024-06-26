<?php
include "Connection.php";

$id_planete = filterRequest("id_planete");


$stmt=$con->prepare("DELETE FROM  `planetes` WHERE id=?");

$stmt->execute(array($id_planete));

$count=$stmt->rowcount();
if($count>0){
    echo json_encode(array("status"=>"success"));
}else{
    echo json_encode(array("status"=>"error"));
}
?>

