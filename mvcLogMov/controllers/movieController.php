<?php
$db = Connection::connect();

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
