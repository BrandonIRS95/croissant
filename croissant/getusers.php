<?php
//allow access to API
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: email, password');
require_once('classes/typeusers.php');
require_once('classes/user.php');
require_once('classes/catalogs.php');
$headers = getallheaders();

if(isset($_GET['email']) && isset($_GET['password']))
{
	
	try
    {
        $u = new User($_GET['email'],$_GET['password']);
		echo '{ "status" : 0, "message" : "User found",
			"id": '.$u->get_id().',
			"firstname": "'.$u->get_first_name().'",
			"lastname": "'.$u->get_last_name().'",
			"nickname": "'.$u->get_nickname().'",
            "image": "'.$u->get_image().'",
            "userstatus": '.$u->get_status().',
			"type": '.$u->get_type()->get_id().'				
			}';
	}
	catch (RecordNotFoundException $ex)
	{
		echo '{ "status" : 1, "error" : "'.$ex->get_message().'" }';
	}
	
}
else
{
	echo '{ "status" : 2, "errorMessage" : "Parameter not found lolas" }';
}

?>
