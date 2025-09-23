<?php

require_once('models/Movie.php');

//cargar modelo
$db = Connection::connect();

/*
$q='SELECT * FROM peliculas';
$result = $db->query($q);
if($result){
    while($row = $result -> fetch_assoc)
    { 
        $movies[]= new Movie($row['title'],$row['poster'],$row['author'],$row['year'],$row['description'],$row['id']);
    }
}
*/


if(isset($_GET['id'])){
    $info=false;
    $q="SELECT * FROM peliculas WHERE id=".$_GET['id'];
    $result = $db->query($q);

    if($row = $result->fetch_assoc()){
        $movies[]= new Movie($row['title'],$row['poster'],$row['author'],$row['year'],$row['description'],$row['id']);
    }
    else {
        $info = "No existe la pelicula";
    }

    require_once 'views/moviesView.phtml';
}
else{

    $q="SELECT * FROM peliculas";
    $result = $db->query($q);
    while($row = $result -> fetch_assoc())
    { 
        $movies[]= new Movie($row['title'],$row['poster'],$row['author'],$row['year'],$row['description'],$row['id']);
    }
    require_once 'views/mainView.phtml';
}


//comprobar variables

//operar


/*
$movies[]= new Movie("El Padrino","foto.png","Francis Ford Coppola",1972,"La historia de la familia Corleone, una de las más poderosas familias mafiosas de Nueva York.",1);
$movies[]= new Movie("Pulp Fiction","foto.png","Quentin Tarantino",1994,"La historia de varios personajes interconectados en Los Ángeles, incluyendo a dos asesinos a sueldo, un boxeador y una pareja de ladrones.",2);
$movies[]= new Movie("Inception","foto.png","Christopher Nolan",2010,"Un ladrón que tiene la habilidad de entrar en los sueños de las personas y robar sus secretos más profundos es contratado para realizar un último trabajo: implantar una idea en la mente de un objetivo.",3);
*/

// cargar vista


/*
if(!isset($_GET['id'])){
           require_once 'views/mainView.phtml';
    }else{
            require_once 'views/moviesView.phtml';
    }
*/

?>
