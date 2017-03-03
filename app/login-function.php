<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require 'Model/Init.php';
require 'includes/require.php';

$userTable = new Users();

// check to see if login
if (isset($_POST['data'])) {
// take security precautions: filter all incoming data!
    $user_name 		= (isset($_POST['data']['user_name'])) 		? strip_tags($_POST['data']['user_name']) 		: '';
    $password 	= (isset($_POST['data']['password'])) 	? strip_tags($_POST['data']['password']) 	: '';
    if ($user_name && $password) {
        $result = $userTable->loginByName($user_name, $password);
        if ($result) {
// store user info in session
            if(isset($_SESSION['currentPage'])){
                $location = $_SESSION['currentPage'];
            }else{
                $location = 'index';
            }
            $_SESSION['user_name'] = $result;
            $_SESSION['login'] = TRUE;
            Header('Location: ' . $location . '');
// redirect back home
        } else {
            $_SESSION['login'] = FALSE;
            Header('Location: login?msg=Login failed');

        }

        exit;
    }
}



?>