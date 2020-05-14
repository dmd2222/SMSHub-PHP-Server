<?php
include_once("config.php");

function receive_sms($deviceID,$number,$message){

   

    //Here you can write code what will happen if the server receives a sms
    send_admin_an_email("deviceID: " . $deviceID . "\n" . "number: " . $number . "\n" . "message: " . $message);
   


}


?>