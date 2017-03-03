<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ob_start();
session_start();
define('DB_USER', 'root');
define('DB_PWD', '');
define('DB_NAME', 'trip_crms');
define('DB_HOST', 'localhost');
define('DB_DSN', 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME .'');
DEFINE('ROOT', 'dev.tripcrms.local/');
DEFINE('SERVER_ROOT', $_SERVER['DOCUMENT_ROOT']);
DEFINE('PATH', '');



if (isset($_SESSION['login']) && $_SESSION['login']){
    $isLogin = 1;
    $loginLink = '../logout';
    $loginText = 'Logout';
    $userType = $_SESSION['user_name']['userType'];
    $uid = $_SESSION['user_name']['uid'];
    $userEmail = $_SESSION['user_name']['email'];
    if($userType == 'Admin'){
        $user_full_name = 'School';
    }else{
        $user_full_name = $_SESSION['user_name']['firstName'] . ' ' . $_SESSION['user_name']['middleName'] . ' ' . $_SESSION['user_name']['lastName'];
    }
}else{
    $isLogin = 0;
    $loginLink = '../login';
    $loginText = 'Login';
    $userType = 'client';
    $userEmail = null;
    $uid = 0;
    $user_full_name = "Guest";
}
