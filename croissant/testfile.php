<?php
/*Creado por Dalia Pinto 21/03 */

//allow access to API
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: user, token');
require_once('classes/catalogs.php');
	require_once('classes/exceptions.php');
	require_once('classes/generatetoken.php');
	require_once('classes/answer.php');
	require_once('classes/conference.php');
	require_once('classes/user.php');
	// get headers
$headers = getallheaders();

	if(isset($_POST['id']))
	{
			$m = $_POST['id'];
			try
			{
				$json ='
				"id: '.$m.' 
				"totalCorrectPersons" : '.Catalogs::get_count_persons($m, 1).',
					"totalWrongPersons" : '.Catalogs::get_count_persons($m, 2);
				
				echo $json;
			}
			catch(RecordNotFoundException $ex)
			{
			  echo '{ "status" : 1, "error" : "'.$ex->get_message().'"}';
			}
	}		
	else
	{
		echo '{ "status" : 3, "errorMessage" : "Parameter not found" }';
	}


?>
