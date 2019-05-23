<?php
session_start();
include_once "search.model.php";

$resultOK = 0;
if ($_POST["search"] == "advSearch") {
   $result=advSearch();
   header('location: ../../html/home.php');
   
} 