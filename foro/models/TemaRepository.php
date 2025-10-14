<?php
class TemaRepository{
    //crear un tema y añadirlo a la base de datos
    public static function createTema($title, $text, $author){
        $db = Connection::connect();
        $q = "INSERT INTO tema (title, text, author) VALUES ('$title', '$text', '$author')";
        if($db->query($q)){
            return $db->insert_id;
        }else{
            return false;
        }
    }

    //borrar un tema de la base de datos 
    public static function deleteTema($idTema){
        $db = Connection::connect();
        $id = intval($idTema);
        $db->query("DELETE FROM tema WHERE id = $id");
        header('Location: index.php');
        exit;
    }

    //obtener todos los temas de la base de datos
    public static function getTemas(){
        $db = Connection::connect();
        $q = "SELECT t.*, u.username as author_username FROM tema t JOIN users u ON t.author = u.id ORDER BY t.datetime DESC";
        $result = $db->query($q);
        $temas = array();
        while($row = $result->fetch_assoc()){
            $temas[] = new Tema($row['id'], $row['title'], $row['text'], $row['author'], $row['datetime'], $row['author_username']);
        }
        return $temas;
    }

    //obtener todos los comentarios de un tema 
    public static function getCommentByTema($idTema){
        $db = Connection::connect();
        $id = intval($idTema);
        $q = "SELECT * FROM comments WHERE tema = $id";
        $result = $db->query($q);
        $coments = array();
        while($row = $result->fetch_assoc()){
            $coments[] = new Coment($row['content'], $row['author'], $row['tema'], $row['id']);
        }
        return $coments;
    }

    public static function getTemaByID($idTema){
        $db = Connection::connect();
        $id = intval($idTema);
        $q = "SELECT t.*, u.username as author_username FROM tema t JOIN users u ON t.author = u.id WHERE t.id = " . $id;
        $result = $db->query($q);
        if($row = $result->fetch_assoc()){
            return new Tema($row['id'], $row['title'], $row['text'], $row['author'], $row['datetime'], $row['author_username']);
        }
        return null;
    }
}