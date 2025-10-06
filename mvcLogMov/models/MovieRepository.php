<?php

class MovieRepository{
    public static function getMovieByID($idMovie){
        $db = Connection::connect();
        $q = "SELECT * FROM peliculas WHERE id=" . intval($idMovie);
        $result = $db->query($q);
        if($row = $result->fetch_assoc()){
            return new Movie($row['title'], $row['poster'], $row['author'], $row['year'], $row['description'], $row['id']);
        }
        return null;        
    }

    public static function getMovies(){
        $db = Connection::connect();
        $q = "SELECT * FROM peliculas";
        $result = $db->query($q);
        $movies = array();
        while($row = $result->fetch_assoc()){ 
            $movies[] = new Movie($row['title'], $row['poster'], $row['author'], $row['year'], $row['description'], $row['id']);
        }
        return $movies;
    }

    public static function deleteMovie($idMovie){
        $db = Connection::connect();
        $id = intval($idMovie);
        $db->query("DELETE FROM peliculas WHERE id = $id");
        header('Location: index.php');
        exit;
    }

    // Inserta la película en la base de datos
    public static function addMovie($title, $author, $year, $description, $poster){
        $db = Connection::connect();
        $q = "INSERT INTO peliculas (title, author, year, description, poster) VALUES ('$title', '$author', '$year', '$description', '$poster')";
       if($result = $db->query($q)) {
        return $db->insert_id;
       } else {
        return false;
       }

    }
}

