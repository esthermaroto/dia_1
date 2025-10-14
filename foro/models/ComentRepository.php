<?php
class ComentRepository{
    //crear un comentario y añadirlo a la base de datos
    public static function createComent($content, $author, $tema){
        $db = Connection::connect();
        $q = "INSERT INTO comments (content, author, tema) VALUES ('$content', '$author', '$tema')";
        if($db->query($q)){
            return $db->insert_id;
        }else{
            return false;
        }
    }

    //borrar un comentario de la base de datos
    public static function deleteComent($idComent){
        $db = Connection::connect();
        $id = intval($idComent); // Prevenir inyección SQL básica
        return $db->query("DELETE FROM comments WHERE id = $id");
    }

    //obtener todos los comentarios de la base de datos
    public static function getComentByID($idComent){
        $db = Connection::connect();
        $q = "SELECT * FROM comments WHERE id=" . intval($idComent);
        $result = $db->query($q);
        if($row = $result->fetch_assoc()){
            return new Coment($row['content'], $row['author'], $row['tema'], $row['id']);
        }
        return null;
    }
}
