<?php
    session_start();
    include_once('_db/connexionDB.php');

    include_once ('_class/register.php');
    $_Register = new Register;

    include_once ('_class/login.php');
    $_Login = new Login;

    error_reporting(E_ALL);
    ini_set('display_errors', '1');
?>