<?php
//allow access to API
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: user, token');
require_once('classes/typeusers.php');
require_once('classes/theme.php');
require_once('classes/generatetoken.php');
$headers = getallheaders();

if(isset($_POST['dark']) && isset($_POST['primary'])
	&& isset($_POST['light']) && isset($_POST['ascent']) && isset($_POST['text']) && isset($_POST['id']))
{
	$u = new Theme($_POST['id']);		
	$u->set_primary_dark_color($_POST['dark']);
	$u->set_primary_light_color($_POST['light']);
	$u->set_accent_color($_POST['ascent']);	
	$u->set_icons_color($_POST['text']);	
	$u->set_primary_color($_POST['primary']);
	
	
	
	if($u->Update())
	{
		echo '{ "status" : 0, "message" : "Theme updated successfully",
			"id": '.$u->get_id().',
			"primary": "'.$u->get_primary_color().'",
			"dark": "'.$u->get_primary_dark_color().'",
			"light": "'.$u->get_primary_light_color().'",
			"ascent": "'.$u->get_accent_color().'",
			"text": "'.$u->get_icons_color().'"
			}';
	}
	else 
	{
		echo '{ "status" : 1, "errorMessage" : "User no added" }';
	}	
}
else
{
	echo '{ "status" : 3, "errorMessage" : "Parameter not found" }';
}


?>