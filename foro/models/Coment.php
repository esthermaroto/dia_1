<?php
class Coment{
    private $content;
    private $author;
    private $tema;
    private $id;

    public function __construct($content, $author, $tema, $id = null){
        $this->content = $content;
        $this->author = $author;
        $this->tema = $tema;
        $this->id = $id;
    }

    public function getContent(){
        return $this->content;
    }

    public function getAuthor(){
        return $this->author;
    }
    
    public function getTema(){
        return $this->tema;
    }
    
    public function getId(){
        return $this->id;
    }
}
?>
