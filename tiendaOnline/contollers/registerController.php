<?php
$db = Connection::connect();
$message = '';
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
    if(!UserRepository::logUser($_POST['username'], $_POST['password'])){
        $message = "❌ Usuario o contraseña incorrectos.";
    }
    
}

//registro
if(isset($_POST['register'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    if(UserRepository::registerUser($username, $password)){
        $message = "✅ Usuario registrado correctamente.";
    } else {
        $message = "❌ El usuario ya existe.";
    }
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
