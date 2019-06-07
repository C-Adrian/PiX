<?php
	include_once "../database.php";
    include_once "getimgs.model.php";
    
	session_start();
	header('Content-type:application/json;charset=utf-8');

	if (isset($_SESSION["username"]))
		echo getQueryResponse();
?>
