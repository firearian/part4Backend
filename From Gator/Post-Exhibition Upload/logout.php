<?php
session_start();
date_default_timezone_set('Pacific/Auckland');

$_SESSION['loggedin'] = false;
unset($_SESSION["username"]);
header("Location: index.html");
?>