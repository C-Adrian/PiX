<?php
	include_once "database.php";
	session_start();
	//header('Content-type: application/json');
	$query_result = array();

	if (isset($_SESSION["username"]))
	{
		$newimg = new stdClass(); //image object declaration
		$connection = connectToDatabase();

		$query = $connection->prepare("SELECT i.id, i.localPath, info.title, info.tags, info.creationDate, info.dimension
    FROM images i LEFT JOIN exifinfo info ON i.id = info.imageID");

		$query->execute();
		$result = $query->get_result();

		while ($singleRes = $result->fetch_assoc()) {
        $component = array();
        array_push($component, $singleRes["id"]);
        array_push($component, $singleRes["title"]);
        array_push($component, $singleRes["tags"]);
        array_push($component, $singleRes["creationDate"]);
        array_push($component, $singleRes["dimension"]);
        array_push($component, $singleRes["localPath"]);
        array_push($images, $component);
    }

		echo $result;
	}

    echo json_encode($query_result);
?>
