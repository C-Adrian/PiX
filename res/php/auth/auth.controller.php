<?php
session_start();
include_once "auth.model.php";

$resultOK = 0;
if ($_POST["submit"] == "login") {
    $resultOK = login($_POST["username"], $_POST["password"]);
    if ($resultOK) {
        header("location: ../../html/home.php");
    } else {
        header("location: ../../html/Login.php");
    }
} 
if($_POST["submit"] == "register")
{
    $resultOK = register($_POST["username"], $_POST["password"], $_POST["repassword"]);
    if ($resultOK) {
        header("location: ../../html/home.php");
    } else {
        header("location: ../../html/Register.php");
    }
}
if($_POST["submit"] == "logout")
{
    logout();
    header('location: ../../html/Login.php');
}

if($_POST["logout_btn"] == "logout")
{
    logout();
    header('location: ../../html/Login.php');
}
?>


