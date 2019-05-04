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
function filter($filter, $path, $ext)
{
    if ($ext == "jpg") {
        $img = imagecreatefromjpeg($path);
        imagefilter($img, $filter);
        imagejpeg($img, $path);
        imagedestroy($img);
    }
    if ($ext == "bmp") {
        $img = imagecreatefrombmp($path);
        imagefilter($img, $filter);
        imagebmp($img, $path);
        imagedestroy($img);
    }
    if ($ext == "png") {
        $img = imagecreatefrompng($path);
        imagefilter($img, $filter);
        imagepng($img, $path);
        imagedestroy($img);
    }
}
function applyFilter($filter)
{
    
    $path = "../../Images/temp/" . $_SESSION["username"];
    if (!file_exists($path)) {
        mkdir($path);
    }

    $imagePath = getImagePath($_COOKIE["imageId"]);
    $ext = pathinfo($imagePath, PATHINFO_EXTENSION);
    copy("../" . $imagePath, $path . "/temp" . $_COOKIE["imageId"] . "." . $ext);
    //filter($filter, $path . "/temp." . $ext, $ext);

    setcookie("filteredImg", $ext, time() + 3600, "/");
    if ($filter == "IMG_FILTER_NEGATE") {
        filter(IMG_FILTER_NEGATE, $path . "/temp" . $_COOKIE["imageId"] . "." . $ext, $ext);
    }
    if ($filter == "IMG_FILTER_GRAYSCALE") {
        filter(IMG_FILTER_GRAYSCALE, $path . "/temp" . $_COOKIE["imageId"] . "." . $ext, $ext);
    }
    if ($filter == "IMG_FILTER_EMBOSS") {
        filter(IMG_FILTER_EMBOSS, $path . "/temp" . $_COOKIE["imageId"] . "." . $ext, $ext);
    }
    if ($filter == "IMG_FILTER_MEAN_REMOVAL") {
        filter(IMG_FILTER_MEAN_REMOVAL, $path . "/temp" . $_COOKIE["imageId"] . "." . $ext, $ext);
    }
    if ($filter == "no_filter") {
        $imagePath = getImagePath($_COOKIE["imageId"]);
        copy("../" . $imagePath, $path . "/temp" . $_COOKIE["imageId"] . "." . $ext);
        setcookie("filteredImg", 1, time(), "/");
    }
}
function download($extension)
{
    $imagePath = getImagePath($_COOKIE["imageId"]);
    if (!isset($_COOKIE["filteredImg"])) {
        if ($extension == "png") {
            imagepng(imagecreatefromstring(file_get_contents("../" . $imagePath)), "D:\PiX_Downloads\downloaded_image.png");
        }
        if ($extension == "jpeg") {
            imagejpeg(imagecreatefromstring(file_get_contents("../" . $imagePath)), "D:\PiX_Downloads\downloaded_image.jpg");
        }
        if ($extension == "bmp") {
            imagebmp(imagecreatefromstring(file_get_contents("../" . $imagePath)), "D:\PiX_Downloads\downloaded_image.bmp");
        }
    } else {
        $ext = pathinfo($imagePath, PATHINFO_EXTENSION);
        echo "../../Images/temp/" . $_SESSION["username"] . "/temp" . $_COOKIE["imageId"] . "." . $ext;
        //imagepng(imagecreatefromstring(file_get_contents("../../Images/temp/temp".$_COOKIE["imageId"]."." . $ext)), "output.png");
        if ($extension == "png") {
            imagepng(imagecreatefromstring(file_get_contents("../../Images/temp/" . $_SESSION["username"] . "/temp" . $_COOKIE["imageId"] . "." . $ext)), "D:\PiX_Downloads\downloaded_image.png");
        }
        if ($extension == "jpeg") {
            imagejpeg(imagecreatefromstring(file_get_contents("../../Images/temp/" . $_SESSION["username"] . "/temp" . $_COOKIE["imageId"] . "." . $ext)), "D:\PiX_Downloads\downloaded_image.jpg");
        }
        if ($extension == "bmp") {
            imagebmp(imagecreatefromstring(file_get_contents("../../Images/temp/" . $_SESSION["username"] . "/temp" . $_COOKIE["imageId"] . "." . $ext)), "D:\PiX_Downloads\downloaded_image.bmp");
        }
    }
}
