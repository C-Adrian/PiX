<?php
	include_once "../database.php";
	session_start();
	//header('Content-type: application/json');
	$query_result = array();

	if (isset($_SESSION["username"]))
	{
		$newimg = new stdClass(); //image object declaration
		$connection = connectToDatabase();

		$query = $connection->prepare("SELECT i.id, i.localPath, ei.title, ei.tags,ei.creationDate ,ei.dimension
    FROM images i LEFT JOIN exifinfo info ON i.id = info.imageID");

		//$query->bind_param("i");
		$query->execute();

		$result = $query->get_result();

		echo $result;
	}

    echo json_encode($query_result);
?>
