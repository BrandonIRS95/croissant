<?php
//allow access to API
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: email, password');
require_once('classes/typeusers.php');
require_once('classes/events.php');
require_once('classes/user.php');
require_once('classes/catalogs.php');
$headers = getallheaders();


	
	try
    {
        $json = '{ "status" : 0, "events" : [';
		$first = true;
		foreach(Catalogs::getAllEvents() as $c)
		{
            
			if($first) $first=false; else $json .= ',';
				$json .= ' { 
						"id" : '.$c->get_id().',
						"name" : "'.$c->get_name_of_event().'",
						"description" : "'.$c->get_description().'",
						"logo" : "'.$c->get_logo_of_event().'",
						"theme" : {
                            "id": '.$c->get_theme()->get_id().',
                            "primary": "'.$c->get_theme()->get_primary_color().'",
                            "dark": "'.$c->get_theme()->get_primary_dark_color().'",
                            "light": "'.$c->get_theme()->get_primary_light_color().'",
                            "ascent": "'.$c->get_theme()->get_accent_color().'",
                            "text": "'.$c->get_theme()->get_icons_color().'"
                        }}';
		}	
        $json .= ']}';
        echo $json;
	}
	catch (RecordNotFoundException $ex)
	{
		echo '{ "status" : 1, "error" : "'.$ex->get_message().'" }';
	}
	


?>
