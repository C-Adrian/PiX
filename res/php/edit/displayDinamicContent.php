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
        $path = "../Images/temp/" . $_SESSION["username"] . "/temp" . $_COOKIE["imageId"] . "." . $_COOKIE["filteredImg"];
        array_push($result, $path);
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
    $stm->bind_param("s", $_SESSION["username"]);
    $stm->execute();
    $dbResult = $stm->get_result();
    $userId = $dbResult->fetch_assoc();
    $stm = $connection->prepare("SELECT * FROM images WHERE userID = ? AND id = ?");
    $stm->bind_param("ii", $userId["id"], $_COOKIE["imageId"]);
    $stm->execute();
    $dbResult = $stm->get_result();
    if (mysqli_num_rows($dbResult) > 0) {
        return true;
    } else {
        return false;
    }
}


function createTempFilteredImg($ext, $path)
{
    if ($ext == "jpg") {
        $negateF = "../Images/temp/" . $_SESSION["username"] . "/negative" . $_COOKIE["imageId"] . "." . $ext;
        $img = imagecreatefromjpeg($path);
        imagefilter($img, IMG_FILTER_NEGATE);
        imagejpeg($img, $negateF);
        imagedestroy($img);
        $grayscaleF = "../Images/temp/" . $_SESSION["username"] . "/grayscale" . $_COOKIE["imageId"] . "." . $ext;
        $img = imagecreatefromjpeg($path);
        imagefilter($img, IMG_FILTER_GRAYSCALE);
        imagejpeg($img, $grayscaleF);
        imagedestroy($img);
        $embossF = "../Images/temp/" . $_SESSION["username"] . "/emboss" . $_COOKIE["imageId"] . "." . $ext;
        $img = imagecreatefromjpeg($path);
        imagefilter($img, IMG_FILTER_EMBOSS);
        imagejpeg($img, $embossF);
        imagedestroy($img);
        $meanF = "../Images/temp/" . $_SESSION["username"] . "/mean" . $_COOKIE["imageId"] . "." . $ext;
        $img = imagecreatefromjpeg($path);
        imagefilter($img, IMG_FILTER_MEAN_REMOVAL);
        imagejpeg($img, $meanF);
        imagedestroy($img);
    }
    if ($ext == "bmp") {
        $negateF = "../Images/temp/" . $_SESSION["username"] . "/negative" . $_COOKIE["imageId"] . "." . $ext;
        $img = imagecreatefrombmp($path);
        imagefilter($img, IMG_FILTER_NEGATE);
        imagebmp($img, $negateF);
        imagedestroy($img);
        $grayscaleF = "../Images/temp/" . $_SESSION["username"] . "/grayscale" . $_COOKIE["imageId"] . "." . $ext;
        $img = imagecreatefrombmp($path);
        imagefilter($img, IMG_FILTER_GRAYSCALE);
        imagebmp($img, $grayscaleF);
        imagedestroy($img);
        $embossF = "../Images/temp/" . $_SESSION["username"] . "/emboss" . $_COOKIE["imageId"] . "." . $ext;
        $img = imagecreatefrombmp($path);
        imagefilter($img, IMG_FILTER_EMBOSS);
        imagebmp($img, $embossF);
        imagedestroy($img);
        $meanF = "../Images/temp/" . $_SESSION["username"] . "/mean" . $_COOKIE["imageId"] . "." . $ext;
        $img = imagecreatefrombmp($path);
        imagefilter($img, IMG_FILTER_MEAN_REMOVAL);
        imagebmp($img, $meanF);
        imagedestroy($img);
    }
    if ($ext == "png") {
        $negateF = "../Images/temp/" . $_SESSION["username"] . "/negative" . $_COOKIE["imageId"] . "." . $ext;
        $img = imagecreatefrompng($path);
        imagefilter($img, IMG_FILTER_NEGATE);
        imagepng($img, $negateF);
        imagedestroy($img);
        $grayscaleF = "../Images/temp/" . $_SESSION["username"] . "/grayscale" . $_COOKIE["imageId"] . "." . $ext;
        $img = imagecreatefrompng($path);
        imagefilter($img, IMG_FILTER_GRAYSCALE);
        imagepng($img, $grayscaleF);
        imagedestroy($img);
        $embossF = "../Images/temp/" . $_SESSION["username"] . "/emboss" . $_COOKIE["imageId"] . "." . $ext;
        $img = imagecreatefrompng($path);
        imagefilter($img, IMG_FILTER_EMBOSS);
        imagepng($img, $embossF);
        imagedestroy($img);
        $meanF = "../Images/temp/" . $_SESSION["username"] . "/mean" . $_COOKIE["imageId"] . "." . $ext;
        $img = imagecreatefrompng($path);
        imagefilter($img, IMG_FILTER_MEAN_REMOVAL);
        imagepng($img, $meanF);
        imagedestroy($img);
    }
}

function editInit()
{
    $path = "../Images/temp/" . $_SESSION["username"];
    if (!file_exists($path)) {
        mkdir($path);
    }
    $imagePath = getImagePath($_COOKIE["imageId"]);
    $ext = pathinfo($imagePath, PATHINFO_EXTENSION);
    $fullImagePath = $path . "/temp" . $_COOKIE["imageId"] . "." . $ext;
    copy($imagePath, $fullImagePath);
    setcookie("filteredImg", $ext, 0, "/");
    setcookie("init", 0, time(), "/");

    createTempFilteredImg($ext,$fullImagePath);
}
