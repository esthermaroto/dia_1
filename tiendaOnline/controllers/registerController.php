<?php
$db = Connection::connect();
$message = '';
require_once('models/User.php');
require_once('models/UserRepository.php');
require_once('helpers/FileHelper.php');

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
    // 1. Establecer el nombre de archivo por defecto.
    $filename = 'default_picture.png';
    
    // 2. Comprobar si se ha subido un archivo sin errores.
    if (isset($_FILES['profilePicture']) && $_FILES['profilePicture']['error'] === UPLOAD_ERR_OK) {
        $originalName = $_FILES['profilePicture']['name'];
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
        // 3. Generar un nombre único para evitar sobreescribir archivos.
        $uniqueFilename = uniqid('user_', true) . '.' . $extension;
        
        // 4. Mover el archivo y, si tiene éxito, usar el nuevo nombre.
        if (FileHelper::fileHandler($_FILES['profilePicture']['tmp_name'], 'img/' . $uniqueFilename)) {
            $filename = $uniqueFilename;
        }
    }

    if(!UserRepository::registerUser($username, $password, $filename)){
        $message = "❌ El usuario ya existe o los datos son inválidos.";
    }
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
