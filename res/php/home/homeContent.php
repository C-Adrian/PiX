<?php
include_once "../php/database.php";

function getAllImages()
{
    $images = array();
    $connection = connectToDatabase();
    $stm = $connection->prepare("SELECT id, localPath FROM images");
    $stm->execute();
    $dbResult = $stm->get_result();
    while ($row = $dbResult->fetch_assoc()) {
        $stm = $connection->prepare("SELECT title FROM exifinfo WHERE imageID = ?");
        $stm->bind_param("s", $row["id"]);
        $stm->execute();
        $dbResultTitle = $stm->get_result();
        $title=$dbResultTitle->fetch_assoc();
        $image=array();
        array_push($image,$row["localPath"]);
        array_push($image,$title["title"]);
        $images[$row["id"]]=$image;
    }
    return $images;
}
