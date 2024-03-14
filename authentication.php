<?php
session_start();

if(!isset($_SESSION['authenticated']))
{
    $_SESSION['status'] = "Please Login to access Dashboard";
    header('Location: login.php');
    exit(0);
}

?>