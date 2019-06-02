<?php
include_once "../database.php";

function isInputValid($size)
{
    if (!is_numeric($size)) {
        setcookie("invalidSearch", 1, time() + 1, "/");
    } else {
        if ($size < 0) {
            setcookie("invalidSearch", 1, time() + 1, "/");
            return false;
        } else {
            setcookie("searchResult", 1, time() + 1, "/");
            return true;
        }
    }
}

function getImgBySize($size)
{
    $images = array();
    $connection = connectToDatabase();
    $stm = $connection->prepare("SELECT i.id, i.localPath, ei.title, ei.tags,ei.creationDate ,ei.dimension
    FROM images i LEFT JOIN exifinfo ei ON i.id=ei.imageID WHERE size < ? ");
    $stm->bind_param("i", $size);
    $stm->execute();
    $result = $stm->get_result();
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
    return $images;
}

function getImgByDimension($images, $minWidth, $maxWidth, $minHeight, $maxHeight)
{
    $newImages = array();
    foreach ($images as $component) {
        list($wi, $he) = explode("x", $component[4], 2);
        if ($minWidth <= $wi and $minHeight <= $he and $maxWidth >= $wi and $maxHeight >= $he) {
            array_push($newImages, $component);
        }
    }
    return $newImages;
}

function getImgByDate($images, $sDate, $eDate)
{
    $newImages = array();
    foreach ($images as $component) {
        $time = strtotime($component[3]);
        $inputFormat = date("Y-m-d", $time);
        if ($sDate <= $inputFormat && $eDate >= $inputFormat) {
            array_push($newImages, $component);
        }
    }
    return $newImages;
}

function getImgByTags($images, $tagsList)
{
    $newImages = array();
    foreach ($images as $component) {
        $tags = explode(" ", $tagsList);
        $ok = 0;
        foreach ($tags as $tag) {
            if (strpos($component[2], $tag) !== false) {
                $ok = 1;
                break;
            }
        }
        if ($ok == 1) {
            array_push($newImages, $component);
        }
    }
    return $newImages;
}

function dumpImages($images)
{
    $json = json_encode($images);
    $fd = fopen("../../tempFiles/advSearchResults.json", "w");
    fwrite($fd, $json);
    fclose($fd);
}

function advSearch($tagsList, $sDate, $eDate, $minWidth, $maxWidth, $minHeight, $maxHeight, $size)
{

    if (isInputValid($size)) {
        $images = getImgBySize($size * 1048576);
        if ($minWidth != "" and $minHeight != "" and $maxWidth != "" and $maxHeight != "") {
            $images = getImgByDimension($images, $minWidth, $maxWidth, $minHeight, $maxHeight);
        }
        if ($sDate != "" and $eDate != "") {
            $images = getImgByDate($images, $sDate, $eDate);
        }
        if ($tagsList != "") {
            $images = getImgByTags($images, $tagsList);
        }
        print_r($images);
        dumpImages($images);
        return true;
    } else {
        return false;
    }
}
