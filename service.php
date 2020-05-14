<?php
include_once("config.php");
include_once("receive.php");
include_once("Class/db.sqlite.class.php");


//FUNCTIONS




    function write_message_to_file($filename,$message)
    {
        
        $fh = fopen($filename, 'a') or die("can't open file");
        @fwrite($fh, $message);
        @fclose($fh);
    }

function debugging($text){

    //Debugging
 if(config_debugging_on == 1){

//debugging text
if(config_debugging_mode == 1){
    write_message_to_file("debugging.txt","text: " . $text . "\n");
}elseif(config_debugging_mode == 2){
    echo "text" .  $text . ";\n";
}elseif(config_debugging_mode == 3){
    write_message_to_file("debugging.txt","text: " . $text . "\n");
    echo "text" .  $text . ";\n";
}


  

 }



}



function send_admin_an_email($message){

    foreach(config_admin_email as $single_email_adress) {
        $temp_message =  "message: " . $message . "\n";
        mail($single_email_adress, 'SmSHub received an message for the admin', $temp_message);
    }


}



function error_message($error="Error",$error_message="You are not allowed to do this. Bad boy.",$http_response_code="500"){

    $json_string = json_encode(array('error' => $error, 'errormessage' => $error_message,'http_response' => $http_response_code));

    //Inform admin
if(config_admin_email_if_error == 1){
    send_admin_an_email($json_string);
}

    //Show message
    echo $json_string;
}


function secure_db(){
try {
    $fn = './main.db';
    chmod($fn, 0600);
} catch (Exception $e) {
    echo 'Exception abgefangen: ',  $e->getMessage(), "\n";
    send_admin_an_email("WARNING: The program was not able to secure the db. Set main.db unreadable, see chmod!");
}
}


function secure_debugging_file(){
    try {
        $fn = './debugging.txt';
        chmod($fn, 0600);
    } catch (Exception $e) {
        echo 'Exception abgefangen: ',  $e->getMessage(), "\n";
        send_admin_an_email("WARNING: The program was not able to secure the db. Set debugging.txt unreadable, see chmod!");
    }
    }



function create_db(){
    try {
$db = new SQLiteDatabase("main.db");
                                
                            // create the database structure
                            $query = 'CREATE TABLE IF NOT EXISTS "sms_to_send" (
                            "Id" INTEGER PRIMARY KEY AUTOINCREMENT,
                            "message" TEXT,
                            "number" TEXT,
                            "messageId" TEXT,
                            "sms_status" TEXT
                                );';
                            $db->query( $query );  

                        } catch (Exception $e) {
                            echo 'Exception abgefangen: ',  $e->getMessage(), "\n";
                            send_admin_an_email("WARNING: The program was not able to secure the db. Set main.db unreadable, see chmod!");
                        }
                        }



 // RUNNING LOGIC
//MAIN PROGRAMM

 



 






create_db();
secure_db();
secure_debugging_file();

//Start processing -- Gets the messages(SMSs) sent by SMSHUB as a POST or GET request.

$error = NULL;

//POST

        if (isset($_POST['deviceId']))
        {
            $deviceId = $_POST['deviceId'];
            
        }
        else
        {
            $error .= 'POSTThe deviceId variable was not set';
        }

        if (isset($_POST['action']))
        {
            $action = $_POST['action'];
        }
        else
        {
            $error .= 'POSTThe action variable was not set';
        }


        if (isset($_POST['messageId']))
        {
            $messageId = $_POST['messageId'];
        }
        else
        {
            $error .= 'POSTThe messageId variable was not set';
        }


        if (isset($_POST['status']))
        {
            $status = $_POST['status'];
        }
        else
        {
            $error .= 'POSTThe status variable was not set';
        }




        if (isset($_POST['message']))
        {
            $message = $_POST['message'];
        }
        else
        {
            $error .= 'POSTThe messageId variable was not set';
        }
        


        if (isset($_POST['number']))
        {
            $number = $_POST['number'];
        }
        else
        {
            $error .= 'POSTThe number variable was not set';
        }

     //GET
     if (isset($_GET['deviceId']))
     {
         $deviceId = $_GET['deviceId'];
     }
     else
     {
         $error .= 'GETThe deviceId variable was not set';
     }

     if (isset($_GET['action']))
     {
         $action = $_GET['action'];
     }
     else
     {
         $error .= 'GETThe action variable was not set';
     }


     if (isset($_GET['messageId']))
     {
         $messageId = $_GET['messageId'];
     }
     else
     {
         $error .= 'GETThe messageId variable was not set';
     }


     if (isset($_GET['status']))
     {
         $status = $_GET['status'];
     }
     else
     {
         $error .= 'GETThe status variable was not set';
     }




     if (isset($_GET['message']))
     {
         $message = $_GET['message'];
     }
     else
     {
         $error .= 'GETThe messageId variable was not set';
     }
     


     if (isset($_GET['number']))
     {
         $number = $_GET['number'];
     }
     else
     {
         $error .= 'GETThe number variable was not set';
     }







 //Debugging
 if(config_debugging_on == 1){
    foreach ($_POST as $key => $value) {
        if(config_debugging_mode == 1){
            write_message_to_file("debugging.txt","POST: key: " . $key . " - value:" . $value . ";\n");
        }elseif(config_debugging_mode == 2){
            echo "POST: key: " . $key . " - value:" . $value . ";\n";
        }elseif(config_debugging_mode == 3){
            write_message_to_file("debugging.txt","POST: key: " . $key . " - value:" . $value . ";\n");
            echo "POST: key: " . $key . " - value:" . $value . ";\n";
        }
    }
    
    foreach ($_GET as $key => $value) {
        if(config_debugging_mode == 1){
            write_message_to_file("debugging.txt","GET: key: " . $key . " - value:" . $value . ";\n");
        }elseif(config_debugging_mode == 2){
            echo "POST: key: " . $key . " - value:" . $value . ";\n";
        }elseif(config_debugging_mode == 3){
            write_message_to_file("debugging.txt","GET: key: " . $key . " - value:" . $value . ";\n");
            echo "POST: key: " . $key . " - value:" . $value . ";\n";
        }
    }
 
//Get all error messages
if(config_debugging_mode == 1){
write_message_to_file("debugging.txt","Error Var: " . $error . "\n");
}elseif(config_debugging_mode == 2){
echo "Error Var: " . $error . "\n";
}elseif(config_debugging_mode == 3){
write_message_to_file("debugging.txt","Error: " . $error . "\n");
echo "Error Var: " . $error . "\n";
}
}






































//SMSHub Callback, checks if there are SmSs to send

if (isset($deviceId) == true && isset($action) == true){
        //Variables set


        //config_device_id_secret  correct?
$found_an_maching_device_id_secret = 0;
foreach(config_device_id_secret as $singel_device_id_secret) {
    //echo "singel_device_id_secret: " .  $singel_device_id_secret ."\n";
    if($singel_device_id_secret  == $deviceId){
        $found_an_maching_device_id_secret = 1;
    }
}
//echo "found_an_maching_device_id_secret: " .  $found_an_maching_device_id_secret ."\n";
    if($found_an_maching_device_id_secret == 1){
        //Correct
        
        
        
        
        
        //choose action
        switch ($action) {
            case "SEND":
               //SmSHub checks, if there are SmSs to send
                
                    //check if variables are set
                    if (isset($deviceId) == true ){

                        try {
   
                            $db = new SQLiteDatabase("main.db");
                            // query example, one row
                            $sms_db_info = $db->queryRow( sprintf( "SELECT * FROM sms_to_send WHERE sms_status = 'NOTSEND' LIMIT 1" ) );
                            //echo  var_dump($sms_db_info);
            
                            //check result
                            if (isset($sms_db_info)){
                                //Read sms
                                $send_sms_messageId = ""; 
                                $send_sms_message = ""; 
                                $send_sms_number = ""; 
                                
            
                                $send_sms_messageId = $sms_db_info["messageId"]; 
                                $send_sms_message = $sms_db_info["message"]; 
                                $send_sms_number = $sms_db_info["number"]; 
                                
                                //Send SmS in the way to give out json
                                if ($send_sms_number == NULL){
                                    //No SmS to send
                                    $json_string = json_encode(array());
                                }else{
                                    $json_string = json_encode(array('message' => $send_sms_message, 'number' => $send_sms_number,'messageId' => $send_sms_messageId));
                                }
                                
                                echo  $json_string;
                            }
            
                        } catch (Exception $e) {
                            error_message('Exception', $e->getMessage(),'500');
                        } 
                    



                  
                    }else{
                        error_message('Error action:SEND','Well deviceId or messageId  var is not set, in action RECEIVE','500');
                    }


        
        
                break;
            case "RECEIVE":
                //SmSHub(the App on your phone) got an SmS an send it to this scipt.
                // now we work with it
        
             

                //check if variables are set
                if (isset($deviceId) == true && isset($number) == true && isset($message) == true){

                    // Call the receive function in the receive.php file
                    receive_sms($deviceID,$number,$message);
                     //Message back
                     $json_string = json_encode(array('Info' => 'Well, I did it. I started receive.', 'deviceID' => $deviceID, 'number' => $number, 'message' => $message,'http_response' => '200'));
                     echo $json_string;
                }else{
                    error_message('Error action:RECEIVE','Well deviceId,number or message var is not set, in action RECEIVE','500');
                }
        
        
                break;
            case "STATUS":
                //Check Status of SmS


                  //check if variables are set
                  if (isset($deviceId) == true && isset($messageId) == true  && isset($status) == true){


                    try {
                        $db = new SQLiteDatabase("main.db");
                        
                        // insert some data to the database
                        $db->query("UPDATE sms_to_send SET sms_status = '" . $status . "'  WHERE messageId = '" . $messageId . "';");
    
                        //Message back
                        $json_string = json_encode(array('Info' => 'Well, I did it. I updated the status.', 'sms_status' => $status,'http_response' => '200'));
                        echo $json_string;
                    } catch (Exception $e) {
                        error_message('Exception', $e->getMessage(),'500');
                    }   



                  
                }else{
                    error_message('Error action:STATUS','Well deviceId,status or messageId var is not set, in action RECEIVE','500');
                }
                
        


        
                break;



                case "SMS_SEND_API":
                    //Here the API takes the SmS to send


                          //check if variables are set
                    if (isset($deviceId) == true && isset($number) == true && isset($message) == true && $deviceId <> "" && $number <> "" && $message <> ""){


                        try {
                            $db = new SQLiteDatabase("main.db");
                        
   
                            
                            //$messageId create if empty
                            if ($messageId ==null || $messageId =="" || isset($messageId)==false){
                                $messageId =  date("Ymdhisa");
                            }

                            
                            // insert some data to the database
                            $db->query("INSERT INTO sms_to_send VALUES(NULL,'" . strval($message) . "','" . strval($number) . "','" . strval($messageId) . "','NOTSEND');");
    
                            //Message back
                            $json_string = json_encode(array('Info' => 'Well, I did it. I took the message and will try to send it by sms', 'message' => $message, 'number' => $number, 'messageId' => $messageId,'http_response' => '200'));
                            echo $json_string;
                        } catch (Exception $e) {
                            error_message('Exception', $e->getMessage(),'500');
                        } 

                  
                    }else{
                        error_message('Error action:SMS_SEND_API','Well deviceId,number or message var is not set, in action RECEIVE','500');
                    }

   
                
             
                     break;
             default:
                error_message('','Sorry, but I dont know this action command.','500');
                     die;
                    break;
        }//switch close


        }else{
            //config_device_id_secret is not correct
            error_message('401config_device_id_secret','You are not allowed to use this. Bad guy.','401');
            die;

        }



}else{
            //config_device_id_secret is not correct
          //  error_message('500','Hey, no deviceId and action set. That can not be right.','500');
            echo "Err 401 - Tip: Try action=help as POST or GET";
        }

 if($action == "help"){
    $file = 'help.txt';

if (file_exists($file)) {
    echo "\n\n\n";
    echo readfile($file);
    exit;
}else{
    echo "Helpfile not available.";
}
}




?>