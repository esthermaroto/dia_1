<?php
$db = Connection::connect();
require_once('models/MovieRepository.php');



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

    // Manejar subida de imagen
    if (isset($_FILES['poster']) && $_FILES['poster']['error'] === UPLOAD_ERR_OK) {
        $poster = $_SESSION['user']->getId().$_FILES['poster']['name'];
        move_uploaded_file($_FILES['poster']['tmp_name'], 'posters/img/'.$_SESSION['user']->getId().$_FILES['poster']['name']);
    }

    // Inserta la película en la base de datos
    $q = "INSERT INTO peliculas (title, author, year, description, poster) VALUES ('$title', '$author', '$year', '$description', '$poster')";
    $db->query($q);

    // Redirige a la lista principal
    header('Location: index.php');
    exit;
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

