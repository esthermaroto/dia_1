
<?php
//loging de un usuario con sesiones y array y comprobación de campos

class User{
    private $user;
    private $password;

    public function __construct($user, $password){
        $this->user = $user;
        $this->password = $password;
    }

    public function getUser(){
        return $this->user;
    }

    public function getPassword(){
        return $this->password;
    }
}
session_start();



if(isset($_GET['logout'])){
    session_destroy();
}

if(!isset($_SESSION['login'])){
    $_SESSION['login']=0;
}


$users["maria"] = new User("maria", "maria");
$users["luis"] = new User("luis", "luis");
$users["ana"] = new User("ana", "ana");

$error = 0;
$login = 0;

if(isset($_POST['login'])){
    if(!empty($_POST['user']) && !empty($_POST['password'])){
        if(isset($users[$_POST['user']]) ){
            if($_POST['password'] == $_POST['user']->getPassword()){
            $_SESSION['login']=1;
            $_SESSION['user']=$users[$_POST['user']];
        } else {
            $error="Error: Invalid username or password.";
        }
    } else {
        $error="Error: Please fill in all fields.";
    }
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
}
    if (!$_SESSION['login']) {
       
    ?>
    <h1> login </h1>
    
    <form action="loginObject.php" method="POST">
            <input type="text" name="user" placeholder="nombre de usuario" />
            <input type="password" name="password" placeholder="contraseña" />
            <input type="submit" name= "login" value="entrar" />
    </form>

    <br>
    <?php
    
    if($error) {
        echo "ERROR: " . $error;    

    }
    }else {
        echo "<h1>Bienvenido</h1> hola " . $_SESSION['user'];
        echo "<br><a href='loginObject.php?logout=1'>Cerrar sesión</a>";
    }
    ?>

    

</body>
</html>