<?php
session_start();
include_once("edit.model.php");
if (isset($_GET["submit"])) {
    if ($_GET["submit"] == "filter") {
        applyFilter($_GET["filter"]);
        header("location: ../../EditAndViewPage.html");
    }
    if ($_GET["submit"] == "download") {
        download($_GET["download"]);
        header("location: ../../EditAndViewPage.html");
    }
    if ($_GET["submit"] == "resize") {
        if ($_GET["Width"] == "" or $_GET["Height"] == "") {
            setcookie("wrongDimension", 1, time() + 1, "/");
        } else {
            resize($_GET["Width"], $_GET["Height"]);
        }
        header("location: ../../EditAndViewPage.html");
    }
}
if (isset($_GET["direction"])) {
    if ($_GET["direction"] == "left") {
        rotate("left");
        header("location: ../../EditAndViewPage.html");
    }
    if ($_GET["direction"] == "right") {
        rotate("right");
        header("location: ../../EditAndViewPage.html");
    }
}
if (isset($_POST["submit"])) {
    if ($_POST["submit"] == "delete") {
        deleteImage($_COOKIE["imageId"]);
        header("location: ../../home.html");
    }
}
