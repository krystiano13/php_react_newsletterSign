<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");


if ($_POST['email']) {
    require_once 'addMail.php';

    $mail = new Mail($_POST['email']);

    if ($mail->send()) {
        echo json_encode(["msg" => "success"]);
    } else {
        if (!$mail->free) {
            echo json_encode(["msg" => "free"]);
        } else {
            echo json_encode(["msg" => "failure"]);
        }
    }
}