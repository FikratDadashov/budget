<?php

if($_SERVER['REQUEST_METHOD'] === 'POST') {
	
	/*echo "<pre>";
	print_r($_POST);
	echo "</pre>";*/

	sleep(3);
	$a = 1;
	echo  false;
	if($a) {
		http_response_code(200);
		echo "http://money/";
	} else {
		http_response_code(400);
		echo "sehv";
	}

	die();
}



?>