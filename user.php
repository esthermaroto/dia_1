<?php
if (isSet ($_POST["username"])) {
    $nombre = $_POST["username"];
    $password = $_POST["password"];
}
else {
    echo "No eres admin <br>";
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
    <form action="" method="POST">
            <input type="text" name="username" placeholder="Nombre de usuario" />

            <input type="password" name="password" placeholder="Contraseña" />
            <input type="submit" value="Enviar" />
    </form>
    <br>
    <?php
    if (isset($_POST["username"]) && isset($_POST["password"])) {
        if ($nombre == "admin") {
            if ($password == "admin") {
                echo "Hola admin <br>";
           }
            
        }
    }
    ?>
    














</body>
</html>