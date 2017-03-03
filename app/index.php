<?php
require 'Model/Init.php';
require 'includes/require.php';

if($userType == 'Admin'){
    Header('Location: admin/manage-trip');
}else{
    Header('Location: client/trips');
}