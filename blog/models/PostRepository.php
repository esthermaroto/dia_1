<?php
class PostRepository{
    //crear un post y añadirlo a la base de datos
    public static function createPost($title, $text, $author){
        $db = Connection::connect();
        $q = "INSERT INTO posts (title, text, author) VALUES ('$title', '$text', '$author')";
        if($db->query($q)){
            return $db->insert_id;
        }else{
            return false;
        }
    }

    //borrar un post de la base de datos
    public static function deletePost($idPost){
        $db = Connection::connect();
        $id = intval($idPost);
        $db->query("DELETE FROM posts WHERE id = $id");
        header('Location: index.php');
        exit;
    }

    //obtener todos los posts de la base de datos
    public static function getPosts(){
        $db = Connection::connect();
        $q = "SELECT * FROM posts ORDER BY datetime DESC";
        $result = $db->query($q);
        $posts = array();
        while($row = $result->fetch_assoc()){
            $posts[] = new Post($row['title'], $row['text'], $row['author'], $row['datetime'], $row['id']);
        }
        return $posts;
    }

    public static function getPostByID($idPost){
        $db = Connection::connect();
        $q = "SELECT * FROM posts WHERE id=" . intval($idPost);
        $result = $db->query($q);   
        if($row = $result->fetch_assoc()){
            return new Post($row['title'], $row['text'], $row['author'], $row['datetime'], $row['id']);
        }
        return null;
    }

    
}
