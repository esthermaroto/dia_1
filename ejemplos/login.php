
<?php
//loging de un usuario con sesiones y array y comprobación de campos

session_start();

class User{

    private $username;
    private $password;

    public function __construct($username, $password){
        $this->username = $username;
        $this->password = $password;
    }

    public function getUsername(){
        return $this->username;
    }

    public function getPassword(){
        return $this->password;
    }


}

if(isset($_GET['logout'])){
    $_SESSION['login']=false;
}

if(!isset($_SESSION['login'])){
    $_SESSION['login']=false;
}


$users["pepe"]= new User("pepe","pepe");
$users["maria"]= new User("maria","maria");
$users["juan"]= new User("juan","juan");
$users["nami"]= new User("nami","nami");

$error = 0;

if(isset($_POST['login'])){
    if(!empty($_POST['user']) && !empty($_POST['password'])){
        if(isset($users[$_POST['user']]) ){
            if($_POST['password'] == $users[$_POST['user']]->getPassword()){
            $_SESSION['login']=1;
            $_SESSION['user']=$users[$_POST['user']];
            } 
            else $error="contraseña incorrecta";
        }
        else $error="usuario desconocido";
    }
    else $error="no hay user o pass";
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
</head>
<body>
    <?php

    if (!$_SESSION['login']) {
       
    ?>
    <h1> login </h1>
    
    <form action="login.php" method="POST">
            <input type="text" name="user" placeholder="nombre de usuario" />
            <input type="password" name="password" placeholder="contraseña" />
            <input type="submit" name= "login" value="entrar" />
    </form>

    <br>
    <?php
    
        if($error) {
            echo "ERROR: " . $error;    
        }
    }
    else {
        echo "<br><a href='login.php?logout=1'>Cerrar sesión</a>";
        echo "<h1>Bienvenido</h1> hola " . $_SESSION['user']->getUsername();
    }
    ?>

    

</body>
</html>