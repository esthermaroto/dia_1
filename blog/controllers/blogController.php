<?php
require_once('models/Post.php');
require_once('models/PostRepository.php');

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
    $post = PostRepository::deletePost($_GET['id']);
    exit;
}

if(isset($_GET['id'])){
    $post = PostRepository::getPostByID($_GET['id']);
    require_once 'views/postView.phtml';
    exit;
}

    $posts = PostRepository::getPosts();
    require_once 'views/blogView.phtml';
    exit;



