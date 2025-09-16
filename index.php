<?php
if (isSet ($_POST["username"])) {
    $nombre = $_POST["username"];
    $password = $_POST["password"];
}
else {
    echo $error=1;
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
    <h1>Hola Mundo</h1>
    <a href="?section=news">Noticias</a>
    <a href="?section=photos">Galería</a>
    <a href="?section=contact">Contacto</a>

    <br>

    <?php
   if (isSet($_GET["section"])) {
        $section = $_GET["section"];
        echo "Has seleccionado la sección: " . $section . "<br>";
    
        switch ($section) {
            case 'news':
                echo "Aquí están las noticias más recientes.<br>";
                break;
            case 'photos':
                echo '<img src="foto.png" alt="Mi imagen" width="200"><br>';
                break;
            case 'contact':
                echo "Correo: esther.maroto@gmail.com<br>";
                break;
                
        }
    }



    $var = "hola";

    if ($var) {
        echo "ha dicho hola <br>";
    }

    $i = 5;
    while ($i) {
        echo $i--;
    }

    echo "<br>";

    for ($i = 0; $i < 5; $i++) {
        echo $i;
    }

    echo "<br>";

    $array = ["a", "b", "c"];
    $array[3] = "d";

    echo "<br><h2>lista</h2><ul>";
    foreach ($array as $key => $value) {
        echo "<li>$key.$value</li>";
    }
    echo "</ul>";

    foreach ($array as $element) {
        echo $element;
    }
    echo "<br>";
    
    echo '<img src="foto.png" alt="Mi imagen" width="200">';

    ?>
    <form action="" method="POST">
            <input type="text" name="username" placeholder="Nombre de usuario" />
            <br>
            <input type="password" name="password" placeholder="Contraseña" />
            <input type="submit" value="Enviar" />
    </form>
    <br>
    
    <?php
    $login = false;
    if (isset($_POST["username"])) {
        if ($nombre == "admin") {
            $login = true;          
        }
    }
    if (isset($_POST["password"])) {
        if ($password != "admin") {
            $login = false;          
        }
    }
    if ($login) {
        echo "Hola admin <br>";
    }
    else {
        if (isSet($error)) {
            echo "Regístrate <br>";
        }
    }
    ?>
    

</body>
</html>