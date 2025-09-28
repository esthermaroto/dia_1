<?php

$db = Connection::connect();

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
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $q = 'SELECT * FROM users WHERE username="'.$username.'" AND password="'.$password.'"';
    $result = $db->query($q);

    if ($row = $result->fetch_assoc()) {
        $_SESSION['user'] = new User($row['id'], $row['username']);
        header('Location: index.php');
        exit;
    } else {
        $message = "❌ Usuario o contraseña incorrectos.";
    }
}

//registro
if(isset($_POST['register'])){
    if(!empty($_POST['username']) && !empty($_POST['password'])){
        $q='SELECT * FROM users WHERE username="'.$_POST['username'].'"';
        $result = $db->query($q);
        if($row = $result->fetch_assoc()){
            $message = "❌ Ese usuario ya existe.";
            
        }
        else{
                $q = 'INSERT INTO users (username, password) VALUES("'.$_POST['username'].'","'.md5($_POST['password']).'")';            if($db->query($q)){
                $id= $db->insert_id;
                $_SESSION['user'] = new User($id,$_POST['username']);
                require_once 'views/userView.phtml';
                exit;
            }
        }
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

