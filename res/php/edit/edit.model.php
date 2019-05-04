<?php

include_once "../database.php";
//include_once "displayDinamicContent.php";

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

function filter($filter,$path)
{
    if($filter=="IMG_FILTER_NEGATE")
    {
        $img=imagecreatefromjpeg($path);
        imagefilter($img,IMG_FILTER_NEGATE);
        imagejpeg($img,$path);
        imagedestroy($img);
    }
    if($filter=="IMG_FILTER_GRAYSCALE")
    {
        $img=imagecreatefromjpeg($path);
        imagefilter($img,IMG_FILTER_GRAYSCALE);
        imagejpeg($img,$path);
        imagedestroy($img);
    }
    if($filter=="IMG_FILTER_EMBOSS")
    {
        $img=imagecreatefromjpeg($path);
        imagefilter($img,IMG_FILTER_EMBOSS);
        imagejpeg($img,$path);
        imagedestroy($img);
    }
    if($filter=="IMG_FILTER_GAUSSIAN_BLUR")
    {
        $img=imagecreatefromjpeg($path);
        imagefilter($img,IMG_FILTER_GAUSSIAN_BLUR);
        imagejpeg($img,$path);
        imagedestroy($img);
    }
    if($filter=="no_filter")
    {
        $imagePath = getImagePath($_COOKIE["imageId"]);
        copy("../" . $imagePath, $path);
    }
}

function applyFilter($filter)
{
    $path = "../../Images/temp/" . $_SESSION["username"];
    if (!file_exists($path . "/temp.jpg")) {
        mkdir($path);
        $imagePath = getImagePath($_COOKIE["imageId"]);
        copy("../" . $imagePath, $path . "/temp.jpg");
        filter($filter,$path . "/temp.jpg");
    }
    else{
        filter($filter,$path . "/temp.jpg");
    }
    
    setcookie("filteredImg", 1, time() + 3600, "/");
}
