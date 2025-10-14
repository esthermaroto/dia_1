<?php
require_once('models/Tema.php');
require_once('models/TemaRepository.php');
require_once('models/Coment.php');
require_once('models/UserRepository.php');
require_once('models/ComentRepository.php');

// Mostrar formulario para nuevo tema
if (isset($_GET['action']) && $_GET['action'] === 'new') {
    require_once 'views/newTema.phtml';
    exit;
}

//Crear tema
if (isset($_POST['title']) && isset($_POST['text'])) {
    $title = $_POST['title'];
    $text = $_POST['text'];
    $author = $_SESSION['user']->getId();
    $tema = TemaRepository::createTema($title, $text, $author);
    header('Location: index.php?c=foro');
    exit;
}

//Borrar tema
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    if (!$_SESSION['user']) {
        header('Location: index.php');
        exit;
    }
    // Solo borra si el tema existe y el autor es el usuario actual
    $tema = TemaRepository::getTemaByID($_GET['id']);
    // El admin (rol 1) o el autor del tema pueden borrar
    if($tema && ($_SESSION['user']->getRol() == 0 || $tema->getAuthor() == $_SESSION['user']->getId())){
        TemaRepository::deleteTema($_GET['id']);
    }
    header('Location: index.php?c=foro');
    exit;
}

//Crear comentario
if (isset($_GET['action']) && $_GET['action'] === 'coment' && isset($_POST['content']) && isset($_GET['id'])) {
    $content = $_POST['content'];
    $author = $_SESSION['user']->getId();
    $temaId = $_GET['id'];
    ComentRepository::createComent($content, $author, $temaId);
    header('Location: index.php?c=foro&id=' . $temaId);
    exit;
}

//Borrar comentario
if (isset($_GET['action']) && $_GET['action'] === 'deleteComent' && isset($_GET['id'])) {
    if (!$_SESSION['user']) {
        header('Location: index.php');
        exit;
    }
    $idComent = $_GET['id'];
    $coment = ComentRepository::getComentByID($idComent);

    // El admin (rol 1) o el autor del comentario pueden borrar
    if ($coment && ($_SESSION['user']->getRol() == 0 || $coment->getAuthor() == $_SESSION['user']->getId())) {
        ComentRepository::deleteComent($idComent);
        header('Location: index.php?c=foro&id=' . $coment->getTema());
        exit;
    }
}

// --- ACCIÓN POR DEFECTO ---
// Si se pide un tema específico, mostrarlo con sus comentarios
if (isset($_GET['id'])) {
    $tema = TemaRepository::getTemaByID($_GET['id']);
    $coments = TemaRepository::getCommentByTema($_GET['id']);
    require_once('views/temaView.phtml');
} else {
    // Si no, mostrar todos los temas
    $temas = TemaRepository::getTemas();
    require_once('views/foroView.phtml');
}
