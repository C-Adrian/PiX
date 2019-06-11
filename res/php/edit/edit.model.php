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
    $ext = $_COOKIE["filteredImg"];
    $fullFilePath = "../../Images/temp/" . $_SESSION["username"] . "/temp" . $_COOKIE["imageId"] . "." . $ext;
    if ($filter == "IMG_FILTER_NEGATE") {
        filter(IMG_FILTER_NEGATE, $fullFilePath, $ext);
    }
    if ($filter == "IMG_FILTER_GRAYSCALE") {
        filter(IMG_FILTER_GRAYSCALE, $fullFilePath, $ext);
    }
    if ($filter == "IMG_FILTER_EMBOSS") {
        filter(IMG_FILTER_EMBOSS, $fullFilePath, $ext);
    }
    if ($filter == "IMG_FILTER_MEAN_REMOVAL") {
        filter(IMG_FILTER_MEAN_REMOVAL, $fullFilePath, $ext);
    }
    if ($filter == "no_filter") {
        $imagePath = getImagePath($_COOKIE["imageId"]);
        copy("../" . $imagePath, $fullFilePath);
    }
}
function download($extension)
{
    $ext = $_COOKIE["filteredImg"];
    $newImagePath = "../../Images/temp/" . $_SESSION["username"] . "/temp" . $_COOKIE["imageId"] . "." . $ext;
    if ($extension == "png") {
        imagepng(imagecreatefromstring(file_get_contents($newImagePath)), "../../Images/temp/output.png");
        header("Content-Type: image/png");
        header('Content-Disposition: attachment; filename=download.png');
        readfile("../../Images/temp/output.png");
        unlink("../../Images/temp/output.png");
    }
    if ($extension == "jpeg") {
        imagejpeg(imagecreatefromstring(file_get_contents($newImagePath)), "../../Images/temp/output.jpg");
        header("Content-Type: image/jpeg");
        header('Content-Disposition: attachment; filename=download.jpg');
        readfile("../../Images/temp/output.jpg");
        unlink("../../Images/temp/output.jpg");
    }
    if ($extension == "bmp") {
        imagebmp(imagecreatefromstring(file_get_contents($newImagePath)), "../../Images/temp/output.bmp");
        header("Content-Type: image/bmp");
        header('Content-Disposition: attachment; filename=download.bmp');
        readfile("../../Images/temp/output.bmp");
        unlink("../../Images/temp/output.bmp");
    }
}
function rotate($direction)
{
    $degrees = 90;
    $ext = $_COOKIE["filteredImg"];
    $newImagePath = "../../Images/temp/" . $_SESSION["username"] . "/temp" . $_COOKIE["imageId"] . "." . $ext;

    $img = imagecreatefromstring(file_get_contents($newImagePath));
    if ($direction == "right") {
        $degrees = -$degrees;
    }
    $rotateImg = imagerotate($img, $degrees, 0);
    switch ($ext): case "jpg":
            imagejpeg($rotateImg, $newImagePath);
            break;

        case "png":
            imagepng($rotateImg, $newImagePath);

            break;

        case "bmp":
            imagebmp($rotateImg, $newImagePath);

            break;
    endswitch;
}
function resize($width, $height)
{
    $ext = $_COOKIE["filteredImg"];
    $newImagePath = "../../Images/temp/" . $_SESSION["username"] . "/temp" . $_COOKIE["imageId"] . "." . $ext;

    $img = imagecreatefromstring(file_get_contents($newImagePath));
    $dst = imagescale($img, $width, $height);
    switch ($ext): case "jpg":
            imagejpeg($dst, $newImagePath);
            break;

        case "png":
            imagepng($dst, $newImagePath);

            break;

        case "bmp":
            imagebmp($dst, $newImagePath);

            break;
    endswitch;
}
function deleteImage($imgId)
{
    $connection = connectToDatabase();
    $deleteStm = $connection->prepare("DELETE FROM exifinfo WHERE imageID = ?");
    $deleteStm->bind_param("i", $imgId);
    $deleteStm->execute();
    $deleteStm->close();

    $getPathStm = $connection->prepare("SELECT localPath FROM images WHERE id = ?");
    echo $connection->error;
    $getPathStm->bind_param("i", $imgId);

    $getPathStm->execute();
    $dbResult = $getPathStm->get_result();
    $pathToBeDelete = $dbResult->fetch_assoc();
    $localPath = $pathToBeDelete["localPath"];
    unlink("../" . $localPath);

    $getPathStm->close();

    $deleteStm = $connection->prepare("DELETE FROM images WHERE id = ?");
    $deleteStm->bind_param("i", $imgId);
    $deleteStm->execute();
    $deleteStm->close();
}
