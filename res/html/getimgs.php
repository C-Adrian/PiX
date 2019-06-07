<?php
	session_start();
	header('Content-type: application/json');
	$query_result = array();

	if (isset($_SESSION["username"]))
	{
		$newimg = new stdClass(); //image object declaration

		$newimg->name = "name 1";
		$newimg->tags = "tag1 tag2";
		array_push($query_result, $newimg);
		
		$newimg->name = "name 2";
		$newimg->tags = "tag1 tag2";
		array_push($query_result, $newimg);
	}

    echo json_encode($query_result);
?>