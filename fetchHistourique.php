<?php
include "Connection.php";

// $id_user = filterRequest("id_user");

$stmt=$con->prepare("SELECT * FROM `planetes` " );

$stmt->execute();

$count=$stmt->fetchAll(PDO::FETCH_ASSOC);

if($count>0){
    echo json_encode(array("status"=>"success","data"=>$count));
}else{
    echo json_encode(array("status"=>"error"));
}
?>