<?php
require SERVER_ROOT . '/app/Model/Security.php';
require SERVER_ROOT . '/app/Model/Common.php';
require SERVER_ROOT . '/app/Model/School.php';
require SERVER_ROOT . '/app/Model/Users.php';
require SERVER_ROOT . '/app/View/View.php';

$schoolClass = new School();
$userClass = new Users();
$commonClass = new Common();
$view = new View();