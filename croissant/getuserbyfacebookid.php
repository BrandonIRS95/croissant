<?php
//allow access to API
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: user, token');
require_once('classes/typeusers.php');
require_once('classes/user.php');
require_once('classes/catalogs.php');
require_once('classes/generatetoken.php');
$headers = getallheaders();

if(isset($_POST['facebookId']))
{
	$u = new User();
	$u = Catalogs::get_user_by_facebook_id($_POST['facebookId']);
	if($u->get_id() != '')
	{
		echo '{ "status" : 0, "message" : "User found",
			"id": '.$u->get_id().',
			"firstname": "'.$u->get_first_name().'",
			"lastname": "'.$u->get_last_name().'",
			"nickname": "'.$u->get_nickname().'",
			"facebookId": "'.$u->get_facebook_id().'",
			"type": '.$u->get_type()->get_id().'				
			}';
	}
	else
	{
		echo '{ "status" : 1, "errorMessage" : "User doesn'."'".'t exist" }';
	}
	
}
else
{
	echo '{ "status" : 2, "errorMessage" : "Parameter not found" }';
}


?>