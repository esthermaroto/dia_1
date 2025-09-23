<?php
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
if(isset($_POST['username']) && isset($_POST['password'])){
    $q='SELECT * FROM users WHERE username="'.$_POST['username'].'" AND password="'.md5($_POST['password']).'"';
    $result = $db->query($q);
    if($row = $result->fetch_assoc()){
        $_SESSION['user']= new User($row['id'],$row['username']);
        header('Location: index.php');
    }

}
//vista por defecto
if(!$_SESSION['user']){
    require_once 'views/userView.phtml';
    exit;
}

