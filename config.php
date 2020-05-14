<?php


// device_id set in the app, is used for a singel login password. To get more security, you can set a white or blacklisting
define('config_device_id_secret', array("4321","1234"));


//Admin email adresses
define('config_admin_email', array("email@email.com"));
//Notification to Admin, if error ocures
define('config_admin_email_if_error', '1');

//Attention: If debugging is on, secret key will be accessible by everyone!!!!
define('config_debugging_on', '1');
//1= only textfile, 2=only echo, 3=both
define('config_debugging_mode', '1');

//Black and Whitelisting numbers
//Not made yet !!!!!!!!
//define('config_send_number_whitelisting', array(""));
//define('config_send_number_blacklisting', array(""));
?>