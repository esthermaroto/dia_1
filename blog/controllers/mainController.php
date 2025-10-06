<?php
require_once('models/User.php');

session_start();

if (!isset($_SESSION['user'])) {
    $_SESSION['user'] = false;
}

if(isset($_GET['c'])){
    require_once('controllers/'.$_GET['c'].'Controller.php');
} else {
    if(!$_SESSION['user']){
        require_once('controllers/registerController.php');
    } else {
       require_once('controllers/blogController.php');
    }
}


    

