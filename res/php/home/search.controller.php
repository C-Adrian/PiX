<?php
session_start();
include_once "search.model.php";

$resultOK = 0;
if ($_GET["search"] == "advSearch") {
    $result = advSearch($_GET["tags_list"], $_GET["sDate"], $_GET["eDate"], $_GET["minwidth"], $_GET["maxwidth"], $_GET["minheight"], $_GET["maxheight"], $_GET["size"]);
    header('location: ../../html/home.php');
}

if ($_GET["simple_search_btn"] == "simpleSearch") {
    header('location: ../../html/home.php');
}
