<?php
    session_start();
    include_once("edit.model.php");
    
    if($_GET["submit"]=="filter")
    {
        applyFilter($_GET["filter"]);
        header("location: ../../html/EditAndViewPage.php");
    }
    if($_GET["submit"]=="download")
    {
        download($_GET["download"]);
        header("location: ../../html/EditAndViewPage.php");
    }
?>