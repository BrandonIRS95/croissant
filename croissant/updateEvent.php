<?php
//allow access to API
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: user, token');
require_once('classes/typeusers.php');
require_once('classes/events.php');
require_once('classes/generatetoken.php');
$headers = getallheaders();

if(isset($_POST['adminid']) && isset($_POST['eventid']) && isset($_POST['name']) && isset($_POST['description'])
	&& isset($_POST['idTheme']) && isset($_POST['filename']))
{
    $x = new Theme($_POST['idTheme']);
	$u = new Event();
    $u->set_id($_POST['eventid']);
	$u->set_name_of_event($_POST['name']);
	$u->set_description($_POST['description']);
	$u->set_logo_of_event($_POST['filename']);	
	$u->set_admin_id($_POST['adminid']);
	$u->set_theme($x);	
	
	
	
	if($u->Update())
	{
		$json = '{ "status" : 0, "message" : "Event updated successfully",
			"id": '.$u->get_id().',
			"name": "'.$u->get_name_of_event().'",
			"description": "'.$u->get_description().'",
			"logo": "'.$u->get_logo_of_event().'",';
        $json .= '"theme": {
						"id" : '.$u->get_theme()->get_id().',
						"primary" : "'.$u->get_theme()->get_primary_color().'",
						"primary_dark" : "'.$u->get_theme()->get_primary_dark_color().'",
						"primary_light" : "'.$u->get_theme()->get_primary_light_color().'",
						"ascent" : "'.$u->get_theme()->get_accent_color().'",
						"icons" : "'.$u->get_theme()->get_icons_color().'"
						}}';
        echo $json;
	}
	else 
	{
		echo '{ "status" : 1, "errorMessage" : "Event no updated" }';
	}	
}
else
{
	echo '{ "status" : 3, "errorMessage" : "Parameter not found" }';
}


?>