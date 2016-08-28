<?php
//allow access to API
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: user, token');
require_once('classes/typeusers.php');
require_once('classes/user.php');
require_once('classes/generatetoken.php');
$headers = getallheaders();

if(isset($_POST['txtnickname']) && isset($_POST['txtpassword'])
 && isset($_POST['txtemail']) && isset($_POST['txttype']))
{
	$u = new User();		
	$u->set_nickname($_POST['txtnickname']);
	$u->set_password($_POST['txtpassword']);
	
	if($_POST['txtname']!=null && $_POST['txtlastname']!=null){
	$u->set_first_name($_POST['txtname']);	
	$u->set_last_name($_POST['txtlastname']);
	}else {
		$u->set_first_name("");	
		$u->set_last_name("");
	}
	
	
	
	$u->set_email($_POST['txtemail']);
	$ut = new Type($_POST['txttype']);
	$u->set_type($ut);
	
	
	if($u->Add())
	{
		echo '{ "status" : 0, "message" : "User added successfully",
			"id": '.$u->get_id().',
			"firstname": "'.$u->get_first_name().'",
			"lastname": "'.$u->get_last_name().'",
			"nickname": "'.$u->get_nickname().'",
			"email": "'.$u->get_email().'",
			"type": '.$ut->get_id().'				
			}';
	}
	else 
	{
		echo '{ "status" : 1, "errorMessage" : "email already used" }';
	}	
}
else
{
	echo '{ "status" : 3, "errorMessage" : "Parameter not found" }';
}


?>