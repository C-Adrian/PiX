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
        $stm = $connection->prepare("SELECT title,tags FROM exifinfo WHERE imageID = ?");
        $stm->bind_param("s", $row["id"]);
        $stm->execute();
        $dbResultTitle = $stm->get_result();
        $title = $dbResultTitle->fetch_assoc();
        $image = array();
        array_push($image, $row["localPath"]);
        array_push($image, $title["title"]);
        array_push($image, $title["tags"]);
        $images[$row["id"]] = $image;
    }
    return $images;
}
function getMyImages()
{
    $images = array();
    $connection = connectToDatabase();
    $stm = $connection->prepare("SELECT id FROM users WHERE username = ?");
    $stm->bind_param("s",$_SESSION["username"]);
    $stm->execute();
    $dbResult=$stm->get_result();
    $userId=$dbResult->fetch_assoc();
    $stm = $connection->prepare("SELECT id, localPath FROM images WHERE userID = ?");
    $stm->bind_param("s",$userId["id"]);
    $stm->execute();
    $dbResult = $stm->get_result();
    while ($row = $dbResult->fetch_assoc()) {
        $stm = $connection->prepare("SELECT title,tags FROM exifinfo WHERE imageID = ?");
        $stm->bind_param("s", $row["id"]);
        $stm->execute();
        $dbResultTitle = $stm->get_result();
        $title = $dbResultTitle->fetch_assoc();
        $image = array();
        array_push($image, $row["localPath"]);
        array_push($image, $title["title"]);
        array_push($image, $title["tags"]);
        $images[$row["id"]] = $image;
    }
    return $images;
}
function deleteTempImage()
{
    $folder = "../Images/temp/" . $_SESSION["username"];
    if (file_exists($folder)) {
        foreach (glob($folder . '/*') as $file) {
            if (is_dir($file))
                rrmdir($file);
            else
                unlink($file);
        }
        rmdir($folder);
    }
}
