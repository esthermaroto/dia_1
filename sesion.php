<?php
$users = [
    ["user" => "admin", "password" => "admin"],
    ["user" => "esther", "password" => "1234"],
    ["user" => "pepe", "password" => "queso"]
];
$error = 0;
$login = 0;

if (isSet ($_POST["login"])) {
    if (!empty($_POST["username"]) && !empty($_POST["password"])) {
        if(isset($users[$_POST['user']])){
            if($_POST['password'] == $users($_POST['user']) {
                $login = 1;
            }
            else {
                $error = "Contraseña incorrecta";
            }
        } else {
            $error = "El usuario no existe";
        }
    } else {
        $error = "No hay user o pass";
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
    if (!$login) {
       
    ?>
    <hi> login </h1>
    
    <form action="index.php" method="POST">
            <input type="text" name="user" placeholder="nombre de usuario" />
            <input type="password" name="password" placeholder="contraseña" />
            <input type="submit" name= "login" value="entrar" />
    </form>

    <br>
    <?php
    }
    if($error) {
        echo "ERROR: " .$error;    

    }
    else {
        echo "<h1>Bienvenido<h1> hola " . $_POST['user'];
    }
    ?>

    

</body>
</html>