<?php

///*Creado por Dalia Pinto 20/03 */
//allow access to API
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: user, token');
require_once('classes/question.php');
require_once('classes/user.php');
require_once('classes/generatetoken.php');
$headers = getallheaders();

if(isset($_POST['txtid']))
{
		$m = new Question($_POST['txtid']);
		if($m->Deleted())
		echo '{ "status" : 0, "message" : "Question deleted successfully"
				}';
				else echo '{ "status" : 1, "errorMessage" : "Question no deleted" }';
				

}
else
{
	echo '{ "status" : 3, "errorMessage" : "Parameter not found" }';
}


?>