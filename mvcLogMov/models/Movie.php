<?php
class Movie{
    private $title;
    private $author;
    private $year;
    private $description;
    private $poster;
    private $id;

    public function __construct($title,$poster,$author,$year,$description,$id){
        $this->title = $title;
        $this->description = $description;
        $this->author = $author;
        $this->year = $year;
        $this->poster = $poster;
        $this->id = $id;
    }

    public function getTitle(){
        return $this->title;
    }

    public function getDescription(){
        return $this->description;
    }
    public function getAuthor(){
        return $this->author;
    }
    public function getYear(){
        return $this->year;
    }
    public function getPoster(){
        return $this->poster;
    }
    public function getId(){
        return $this->id;
    }

}
?>