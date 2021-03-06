<?php
    function getUserId($username, $connection)
    {
        $query_text = "SELECT id FROM users WHERE username = '" . $username . "'";
        $query = $connection->prepare($query_text);
        $query->execute();
        $result = $query->get_result();

        return $result->fetch_assoc()["id"];
    }

    function buildQuery($connection)
	{
		$query_text = "SELECT img.id, img.localPath, info.title, info.tags, info.creationDate, info.dimension, img.userID FROM images img LEFT JOIN exifinfo info ON img.id = info.imageID WHERE";

    	if (isset($_GET['search']))
			$text_to_search = $_GET['search'];
		else
			$text_to_search = "";

    	$query_text .= " info.title LIKE '%" . $text_to_search . "%' AND";

    	if (isset($_GET['tags']))
    	{
			$tags = explode(" ", $_GET['tags']);
			foreach ($tags as $tag)
				$query_text .= " info.tags LIKE '%" . $tag . "%' AND";
    	}

    	if (isset($_GET['date_bgn']))
    	{
    		$date_string = $_GET['date_bgn'];
    		if (strtotime($date_string)) //yyyy-mm-dd as input by default
    		{
    			$date = strtotime($date_string);
    			$date_string = date("Y-m-d", $date);
    			$query_text .= " STR_TO_DATE(SUBSTR(info.creationDate, 5, 12), '%d %M %Y') >= '" . $date_string . "' AND";
    		}
    	}

    	if (isset($_GET['date_end']))
    	{
    		$date_string = $_GET['date_end'];
    		if (strtotime($date_string)) //yyyy-mm-dd as input by default
    		{
    			$date = strtotime($date_string);
    			$date_string = date("Y-m-d", $date);
    			$query_text .= " STR_TO_DATE(SUBSTR(info.creationDate, 5, 12), '%d %M %Y') <= '" . $date_string . "' AND";
    		}
    	}

    	if (isset($_GET['min_size']))
    	{
    		$lower_size_limit = $_GET['min_size'];
    		$query_text .= " info.size >= " . $lower_size_limit . " AND";
    	}

    	if (isset($_GET['max_size']))
    	{
    		$lower_size_limit = $_GET['max_size'];
    		$query_text .= " info.size <= " . $lower_size_limit . " AND";
    	}

    	if (isset($_GET['min_width']))
    	{
    		$min_width = $_GET['min_width'];
    		$query_text .= " SUBSTRING_INDEX(info.dimension, 'x', 1) >= " . $min_width . " AND";
    	}

    	if (isset($_GET['max_width']))
    	{
    		$max_width = $_GET['max_width'];
    		$query_text .= " SUBSTRING_INDEX(info.dimension, 'x', 1) <= " . $max_width . " AND";
    	}

    	if (isset($_GET['min_height']))
    	{
    		$min_height = $_GET['min_height'];
    		$query_text .= " SUBSTRING_INDEX(info.dimension, 'x', -1) >= " . $min_height . " AND";
    	}

    	if (isset($_GET['max_height']))
    	{
    		$max_height = $_GET['max_height'];
    		$query_text .= " SUBSTRING_INDEX(info.dimension, 'x', -1) <= " . $max_height . " AND";
    	}

    	if (isset($_GET['user']))
    	{
    		$username = $_GET['user'];
            $user_id = getUserId($username, $connection);
            if ($user_id)
                $query_text .= " img.userID = " . $user_id . " AND";
    	}

    	if (substr_compare($query_text, " AND", -4) === 0)
    		$query_text = substr($query_text, 0, -4); //remove trailing " AND" from query


        if (isset($_GET['limit']) and isset($_GET['offset']))
        {
            $results_limit = $_GET['limit'];
            $results_offset = $_GET['offset'];
            $query_text .= " LIMIT ".$results_limit." OFFSET ".$results_offset;
        }

        if (isset($_GET['limit']) and !isset($_GET['offset']))
        {
            $results_limit = $_GET['limit'];
            $query_text .= " LIMIT ".$results_limit;
        }

    	return $query_text;
	}

	function getQueryResponse()
	{
		$query_result = array();
		$connection = connectToDatabase();

		$query_text = buildQuery($connection);
    	//echo $query_text . "\n";

		$query = $connection->prepare($query_text);
		$query->execute();
		$result = $query->get_result();

        disconnectFromDatabase($connection);

		while ($img_db_entry = $result->fetch_assoc()) 
		{
	        $img_data = new stdClass(); //image object declaration
	        $img_data->id=$img_db_entry["id"];
            $img_data->title=$img_db_entry["title"];
            $img_data->tags=$img_db_entry["tags"];
            $img_data->creationDate=$img_db_entry["creationDate"];
            $img_data->dimension=$img_db_entry["dimension"];
            $img_data->localPath=$img_db_entry["localPath"];
            $img_data->userID=$img_db_entry["userID"];

	        array_push($query_result, $img_data);
   		}

   		echo json_encode($query_result);
	}
?>