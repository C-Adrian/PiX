<?php
session_start();
if (isset($_SESSION["username"])) {
    header("location: ../../html/home.php");
} else {
    header("location: ../../html/Login.php");
}
?>