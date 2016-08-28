<?php
//allow access to API
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: user, token');
require_once('classes/typeusers.php');
require_once('classes/conference.php');
require_once('classes/generatetoken.php');
require_once('classes/catalogs.php');
$headers = getallheaders();


if(isset($_POST['title']) && isset($_POST['type'])
	&& isset($_POST['description']) && isset($_POST['date']) && isset($_POST['time']) && isset($_POST['place']) && isset($_POST['room']) && isset($_POST['idevent']))
{
	$u = new Conference();		
	$u->set_title($_POST['title']);
	$u->set_description($_POST['description']);
	$u->set_type($_POST['type']);	
	$u->set_date($_POST['date']);	
	$u->set_time($_POST['time']);	
	$u->set_place($_POST['place']);	
	$u->set_room($_POST['room']);	
	$u->set_id_event($_POST['idevent']);	
	
	
	
	if($u->Add())
	{
        
        Catalogs::conferenceAndSpeaker(7,$u->get_id());
        
		echo '{ "status" : 0, "message" : "Conference added successfully",
			"id": '.$u->get_id().',
			"title": "'.$u->get_title().'",
			"description": "'.$u->get_description().'",
			"type": "'.$u->get_type().'",
			"date": "'.$u->get_date().'",
			"time": "'.$u->get_time().'",
			"place": "'.$u->get_place().'",
			"room": "'.$u->get_room().'"
			}';
	}
	else 
	{
		echo '{ "status" : 1, "errorMessage" : "Conference no added" }';
	}	
}
else
{
	echo '{ "status" : 3, "errorMessage" : "Parameter not found" }';
}


?>
