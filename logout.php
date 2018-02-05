<?php 
session_start();
unset($_SESSION["uname"]);
unset($_SESSION["password"]);
$url = "index.php";
header("Location:$url");
?>