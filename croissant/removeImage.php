<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: text/javascript; charset=UTF-8');
 	$img_file = $_POST['imgname'];
	if($img_file){
		unlink("/home/ubuntu/workspace/croissant-web/web/upload/$img_file");
        header("Refresh:0");
	}

?>
