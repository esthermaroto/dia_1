<?php
class Coment{
    private $content;
    private $author;
    private $post;
    private $id;

    public function __construct($content, $author, $post, $id = null){
        $this->content = $content;
        $this->author = $author;
        $this->post = $post;
        $this->id = $id;
    }

    public function getContent(){
        return $this->content;
    }

    public function getAuthor(){
        return $this->author;
    }
    
    public function getPost(){
        return $this->post;
    }
    
    public function getId(){
        return $this->id;
    }
}
?>
