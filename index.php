<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
</head>
<body>
    <h1>Hola Mundo</h1>
    <a href="?section=noticias">Noticias</a>
    <a href="?section=galería">Galería</a>
    <a href="?section=contacto">Contacto</a>
    <br>

    <?php
   if (isSet($_GET["section"])) {
        $section = $_GET["section"];
        echo "Has seleccionado la sección: " . $section . "<br>";
    
    switch ($section) {
        case 'noticias':
            echo "Aquí están las noticias más recientes.<br>";
            break;
        case 'galería':
            echo '<img src="foto.png" alt="Mi imagen" width="200"><br>';
            break;
        case 'contacto':
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
    <br>
    

</body>
</html>