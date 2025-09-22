<?php
//lista de peliculas enlazadas a la descripción de cada una
$db= new mysqli("localhost","root","","test",3306);
var_dump($db);

class Movie{
    private $title;
    private $author;
    private $year;
    private $description;
    private $poster;
    private $id;

    public function __construct($title,$poster,$author,$year,$description,$id){
        $this->title = $title;
        $this->description = $description;
        $this->author = $author;
        $this->year = $year;
        $this->poster = $poster;
        $this->id = $id;
    }

    public function getTitle(){
        return $this->title;
    }

    public function getDescription(){
        return $this->description;
    }
    public function getAuthor(){
        return $this->author;
    }
    public function getYear(){
        return $this->year;
    }
    public function getPoster(){
        return $this->poster;
    }
    public function getId(){
        return $this->id;
    }

}

$movies[]= new Movie("El Padrino","foto.png","Francis Ford Coppola",1972,"La historia de la familia Corleone, una de las más poderosas familias mafiosas de Nueva York.",1);
$movies[]= new Movie("Pulp Fiction","foto.png","Quentin Tarantino",1994,"La historia de varios personajes interconectados en Los Ángeles, incluyendo a dos asesinos a sueldo, un boxeador y una pareja de ladrones.",2);
$movies[]= new Movie("Inception","foto.png","Christopher Nolan",2010,"Un ladrón que tiene la habilidad de entrar en los sueños de las personas y robar sus secretos más profundos es contratado para realizar un último trabajo: implantar una idea en la mente de un objetivo.",3);




?>

<!DOCTYPE html>
<html lang="en">        
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movies</title>
</head>
<body>
    <h1>Películas</h1>
    <?php
    if(!isset($_GET['id'])){
            foreach($movies as $movie){
                echo "<a href='index.php?id=".$movie->getId()."'>" . $movie->getTitle() . "</a><br>";
            }
    }else{
            foreach ($movies as $movie) {
                if ($movie->getId() == $_GET['id']) {
                    echo "<h2>" . $movie->getTitle() . "</h2>";
                    echo "<p><strong>Director:</strong> " . $movie->getAuthor() . "</p>";
                    echo "<p><strong>Año:</strong> " . $movie->getYear() . "</p>";
                    echo "<p><strong>Descripción:</strong> " . $movie->getDescription() . "</p>";
                    echo "<img src='posters/" . $movie->getPoster() . "' alt='" . $movie->getTitle() . " Poster' style='width:200px;'><br>";
                    echo "<br><a href='index.php'>Volver a la lista de películas</a>";
                }
            }
    }
    
       
    ?>
</body>
</html>


