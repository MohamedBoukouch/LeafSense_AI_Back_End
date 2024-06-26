<?php
define('MB',1048576);
// include "Connection.php";

function filterRequest($requestname){
    return htmlspecialchars(strip_tags($_POST[$requestname]));
}
function imageUpload($imageRequest)
{
    if(isset($_FILES[$imageRequest])) {
        $images = $_FILES[$imageRequest];
        $file_names = is_array($_FILES[$imageRequest]["name"]) ? $_FILES[$imageRequest]["name"] : [];
        $allowExt = array("jpg", "png", "gif", "mp3", "pdf");
        
        $image_names = array(); // Initialize an array to store individual image names
        
        foreach ($file_names as $key => $val) {
            if(is_string($val)) {
                $strToarray = explode(".", $val);
                $ext = end($strToarray);
                $ext = strtolower($ext);
    
                $location = "upload/";
                $target_path = $location . $val;
    
                if (!empty($val) && in_array($ext, $allowExt)) {
                    move_uploaded_file($images["tmp_name"][$key], $target_path);
                    $image_names[] = $val; // Add individual image names to the array
                }
            }
        }
    
        return implode(",", $image_names);
    } else {
        return "No file uploaded.";
    }
}

  

function sendEmail($to,$title,$body)
{
    $header="From :boukouchmohamed7@gmail.com";
    mail($to,$title,$body,$header);
    return "Success";
}

function sendGCM($title, $message, $topic, $pageid, $pagename)
{


    $url = 'https://fcm.googleapis.com/fcm/send';

    $fields = array(
        "to" => '/topics/' . $topic,
        'priority' => 'high',
        'content_available' => true,

        'notification' => array(
            "body" =>  $message,
            "title" =>  $title,
            "click_action" => "FLUTTER_NOTIFICATION_CLICK",
            "sound" => "default"

        ),
        'data' => array(
            "pageid" => $pageid,
            "pagename" => $pagename
        )

    );


    $fields = json_encode($fields);
    $headers = array(
        'Authorization: key=' . "AAAASu-d5yk:APA91bED8Z2ZS4NW85cUyuigaOns_koAKhkprPunZtBYfcPMhujNZMdVeTlgfjzBhHxceQXCiimj1ej01NCUVvM2OU6CxVCBJ02aRShfqR_qG2QUNa318LF1Tm84xdIYEJYifp-W-7-8",
        'Content-Type: application/json'
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

    $result = curl_exec($ch);
    return $result;
    curl_close($ch);
}

function insertNotification($con, $titel,$body,$user_id,$topic,$pageid,$pagename,$image,$publication_id) {
    $stmt = $con->prepare("INSERT INTO `notifications` (`titel`, `body`, `user_id`,`image`,`id_publication`) VALUES (?,?,?,?,?)");
    $stmt->execute(array($titel, $body, $user_id,$image,$publication_id));
    sendGCM($titel, $body, $topic,$pageid,$pagename);
    $count = $stmt->rowCount(); 
    return $count; 
}


?>