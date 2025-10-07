<?php
class ComentRepository{
    //crear un comentario y añadirlo a la base de datos
    public static function createComent($content, $author, $post){
        $db = Connection::connect();
        $q = "INSERT INTO coment (content, author, post) VALUES ('$content', '$author', '$post')";
        if($db->query($q)){
            return $db->insert_id;
        }else{
            return false;
        }
    }

    //obtener todos los comentarios de un post de la base de datos
    public static function getComentByPost($idPost){
        $db = Connection::connect();
        $q = "SELECT * FROM coment WHERE post=" . intval($idPost);
        $result = $db->query($q);   
        $coments = array();
        while($row = $result->fetch_assoc()){
            $coments[] = new Coment($row['content'], $row['author'], $row['post'], $row['id']);
        }
        return $coments;
    }

    //borrar un comentario de la base de datos
    public static function deleteComent($idComent){
        $db = Connection::connect();
        $id = intval($idComent);
        $db->query("DELETE FROM coment WHERE id = $id");
        header('Location: index.php');
        exit;
    }

    //obtener todos los comentarios de la base de datos
    public static function getComentByID($idComent){
        $db = Connection::connect();
        $q = "SELECT * FROM coment WHERE id=" . intval($idComent);
        $result = $db->query($q);
        if($row = $result->fetch_assoc()){
            $coments[] = new Coment($row['content'], $row['author'], $row['post'], $row['id']);
            return $coments;
        }
        return null;
    }

    //obtener todos los comentarios de un autor de la base de datos
    public static function getComentByAuthor($idAuthor){
        $db = Connection::connect();
        $q = "SELECT * FROM coment WHERE author=" . intval($idAuthor);
        $result = $db->query($q);
        $coments = array();
        while($row = $result->fetch_assoc()){
            $coments[] = new Coment($row['content'], $row['author'], $row['post'], $row['id']);
        }
        return $coments;

}
}
