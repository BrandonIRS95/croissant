<?php
//allow access to API
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: user, token');
require_once('classes/typeusers.php');
require_once('classes/events.php');
require_once('classes/generatetoken.php');
$headers = getallheaders();

if(isset($_POST['name']) && isset($_POST['description'])
	&& isset($_POST['idTheme']) && isset($_POST['filename']))
{
    $x = new Theme($_POST['idTheme']);
	$u = new Event();		
	$u->set_name_of_event($_POST['name']);
	$u->set_description($_POST['description']);
	$u->set_logo_of_event($_POST['filename']);	
	$u->set_theme($x);	
	
	
	
	if($u->Add())
	{
		echo '{ "status" : 0, "message" : "Event added successfully",
			"id": '.$u->get_id().',
			"name": "'.$u->get_name_of_event().'",
			"description": "'.$u->get_description().'",
			"logo": "'.$u->get_logo_of_event().'",
			"description": "'.$u->get_theme()->get_primary_color().'"
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
