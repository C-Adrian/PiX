<?php
include_once "../php/database.php";

function getImageTitle($imageID)
{
    $connection = connectToDatabase();
    $stm = $connection->prepare("SELECT title FROM exifinfo WHERE imageID = ?");
    $stm->bind_param("i", $imageID);
    $stm->execute();
    $dbResult = $stm->get_result();
    $title = $dbResult->fetch_assoc();
    $title = $title["title"];
    return $title;
}
function getImageDescription($imageID)
{
    $connection = connectToDatabase();
    $stm = $connection->prepare("SELECT description FROM exifinfo WHERE imageID = ?");
    $stm->bind_param("i", $imageID);
    $stm->execute();
    $dbResult = $stm->get_result();
    $description = $dbResult->fetch_assoc();
    $description = $description["description"];
    return $description;
}
function getImagePath($imageID)
{
    $connection = connectToDatabase();
    $stm = $connection->prepare("SELECT localPath FROM images WHERE id = ?");
    $stm->bind_param("i", $imageID);
    $stm->execute();
    $dbResult = $stm->get_result();
    $localPath = $dbResult->fetch_assoc();
    $localPath = $localPath["localPath"];
    return $localPath;
}
function getImageTags($imageID)
{
    $connection = connectToDatabase();
    $stm = $connection->prepare("SELECT tags FROM exifinfo WHERE imageID= ?");
    $stm->bind_param("i", $imageID);
    $stm->execute();
    $dbResult = $stm->get_result();
    $tags = $dbResult->fetch_assoc();
    $tags = $tags["tags"];
    //return $tags;
    $arrTags = explode(" ", $tags);
    return $arrTags;
}
function getImage($imageID)
{
    $result = array();
    array_push($result, getImageTitle($imageID));
    array_push($result, getImageDescription($imageID));
    if (isset($_COOKIE["filteredImg"])) {
        $path="../Images/temp/".$_SESSION["username"]."/temp".$_COOKIE["imageId"].".".$_COOKIE["filteredImg"];
        array_push($result,$path);
    } else {
        array_push($result, getImagePath($imageID));
    }
    array_push($result, getImageTags($imageID));
    return $result;
}
function checkDelBtn()
{
    $connection = connectToDatabase();
    $stm = $connection->prepare("SELECT id FROM users WHERE username = ?");
    $stm->bind_param("s",$_SESSION["username"]);
    $stm->execute();
    $dbResult = $stm->get_result();
    $userId=$dbResult->fetch_assoc();
    $stm = $connection->prepare("SELECT * FROM images WHERE userID = ? AND id = ?");
    $stm->bind_param("ii", $userId["id"],$_COOKIE["imageId"]);
    $stm->execute();
    $dbResult = $stm->get_result();
    if(mysqli_num_rows($dbResult)>0)
    {
        return true;
    }
    else{
        return false;
    }
}
?>