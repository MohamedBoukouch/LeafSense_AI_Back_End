<?php
include "Connection.php";

$maladie = filterRequest("maladie");

$stmt = $con->prepare("SELECT * FROM `maladie` WHERE `maladie` = ?");

$stmt->execute([$maladie]);

$count = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($count) {
    echo json_encode(array("status" => "success", "data" => $count));
} else {
    echo json_encode(array("status" => "error"));
}
?>
