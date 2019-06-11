<?php
session_start();
if (isset($_SESSION["username"])) {
    header("location: home.html");
} else {
    header("location: Login.html");
}
?>