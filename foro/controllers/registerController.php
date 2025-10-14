<?php
$db = Connection::connect();
require_once('models/User.php');
require_once('models/UserRepository.php');

//logout
if(isset($_GET['logout'])){
    $_SESSION['user']=false;
    header('Location: index.php');
}
//iniciar sesión
if(!isset($_SESSION['user'])){
    $_SESSION['user']=false;
}

//login
if (isset($_POST['username']) && isset($_POST['password']) && !isset($_POST['register'])) {
    $user = UserRepository::logUser($username, $password);
}

//registro
if(isset($_POST['register'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $user = UserRepository::registerUser($username, $password);
    exit;
}

//vista registro
if(isset($_GET['register'])){
    require_once 'views/newUserView.phtml';
    exit;
}

//vista por defecto
if(!$_SESSION['user']){
    require_once 'views/userView.phtml';
    exit;
}

