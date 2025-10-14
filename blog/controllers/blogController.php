<?php
require_once('models/Post.php');
require_once('models/PostRepository.php');
require_once('models/Coment.php');
require_once('models/ComentRepository.php');

// Mostrar formulario para nuevo post
if (isset($_GET['action']) && $_GET['action'] === 'new') {
    require_once 'views/newPostView.phtml';
    exit;
}

//Crear post 
if (isset($_POST['title']) && isset($_POST['text'])) {
    $title = $_POST['title'];
    $text = $_POST['text'];
    $author = $_SESSION['user']->getId();
    $post = PostRepository::createPost($title, $text, $author);
    header('Location: index.php?c=blog');
    exit;
}

//Borrar post
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    if (!$_SESSION['user']) {
        header('Location: index.php');
        exit;
    }
    // Solo borra si el post existe y el autor es el usuario actual
    $post = PostRepository::getPostByID($_GET['id']);
    // El admin (rol 1) o el autor del post pueden borrar
    if($post && ($_SESSION['user']->getRol() == 0 || $post->getAuthor() == $_SESSION['user']->getId())){
        PostRepository::deletePost($_GET['id']);
    }
    header('Location: index.php?c=blog');
    exit;
}

//Crear comentario
if (isset($_GET['action']) && $_GET['action'] === 'coment' && isset($_POST['content']) && isset($_GET['id'])) {
    $content = $_POST['content'];
    $author = $_SESSION['user']->getId();
    $postId = $_GET['id'];
    ComentRepository::createComent($content, $author, $postId);
    header('Location: index.php?c=blog&id=' . $postId);
    exit;
}

//Borrar comentario
if (isset($_GET['action']) && $_GET['action'] === 'deleteComent' && isset($_GET['id'])) {
    if (!$_SESSION['user']){
        header('Location: index.php');
        exit;
    }
    $idComent = $_GET['id'];
    $coment = ComentRepository::getComentByID($idComent);

    // Solo borra si el comentario existe y el autor es el usuario actual
    // El admin (rol 1) o el autor del comentario pueden borrar
    if ($coment && ($_SESSION['user']->getRol() == 0 || $coment->getAuthor() == $_SESSION['user']->getId())) {
        ComentRepository::deleteComent($idComent);
        header('Location: index.php?c=blog&id=' . $coment->getPost());
        exit;
    }
}

if(isset($_GET['id'])){
    $post = PostRepository::getPostByID($_GET['id']);
    $coments = ComentRepository::getComentByPost($_GET['id']);
    require_once 'views/showPost.phtml';
    exit;
}

    $posts = PostRepository::getPosts();
    require_once 'views/blogView.phtml';
    exit;
