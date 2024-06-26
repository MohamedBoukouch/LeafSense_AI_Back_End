<?php
include "Connection.php";
$image = imageUpload("image");

if ($image !== null) {
    $stmt = $con->prepare("INSERT INTO planetes (`image`) VALUES (?)");
    $stmt->execute(array($image));

    $count = $stmt->rowCount();
    if ($count > 0) {
        echo json_encode(array("status" => "success"));
    } else {
        echo json_encode(array("status" => "Error"));
    }
} else {
    echo json_encode(array("status" => "Error", "message" => "Image upload failed."));
}
?>