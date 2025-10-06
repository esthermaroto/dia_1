<?php
$db = Connection::connect();
require_once('models/MovieRepository.php');
require_once('helpers/fileHelper.php');



// Borrar película
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
   $movie = MovieRepository::deleteMovie($_GET['id']);
   exit;
}

// Crear película
if (isset($_POST['title']) && isset($_POST['author']) && isset($_POST['year']) && isset($_POST['description'])) {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $year = $_POST['year'];
    $description = $_POST['description'];
    $poster = '';
    $filename = $_SESSION['user']->getId().$_FILES['poster']['name'];


    // Manejar subida de imagen
    if(!FileHelper::fileHandler($_FILES['poster']['tmp_name'], 'posters/img/'.$filename)){
        $filename='';
    }

    if(MovieRepository::addMovie($title, $author, $year, $description, $filename)){
    }    
}

if (isset($_GET['action']) && $_GET['action'] === 'new') {
    require_once('views/newMovie.phtml');
    exit;
}

if(isset($_GET['id'])){
    $movie= MovieRepository::getMovieByID($_GET['id']);
    require_once 'views/moviesView.phtml';
    exit;
}

    $movies = MovieRepository::getMovies();
    require_once 'views/mainView.phtml';
    exit;

