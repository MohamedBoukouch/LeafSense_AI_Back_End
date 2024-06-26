<?php
include "Connection.php";

$email=filterRequest("email");


$stmt=$con->prepare("
INSERT INTO `users` (`email`)
VALUES(?)
");

$stmt->execute(array($email));


$count=$stmt->rowcount();
if($count>0){
        echo json_encode(array("status"=>"success","email"=>"email send Success"));
}else{
    echo json_encode(array("status"=>"error"));
}
?>