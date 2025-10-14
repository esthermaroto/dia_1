<?php
class Post{
    private $title;
    private $text;
    private $author;
    private $datetime;
    private $id;


    public function __construct($title, $text, $author, $datetime, $id = null){
        $this->title = $title;
        $this->text = $text;
        $this->author = $author;
        $this->datetime = $datetime;
        $this->id = $id;
    }

    public function getTitle(){
        return $this->title;
    }

    public function getDateTime(){
        return $this->datetime;
    }

    public function getText(){
        return $this->text;
    }

    public function getAuthor(){
        return $this->author;
    }

    public function getId(){
        return $this->id;
    }
}
?>
