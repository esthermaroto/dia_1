<?php
class Coment{
    private $content;
    private $author;
    private $tema;
    private $id;
    private $authorUsername;
    private $authorProfilePicture;

    public function __construct($content, $author, $tema, $id = null, $authorUsername = null, $authorProfilePicture = null){
        $this->content = $content;
        $this->author = $author;
        $this->tema = $tema;
        $this->id = $id;
        $this->authorUsername = $authorUsername;
        $this->authorProfilePicture = $authorProfilePicture;
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

    public function getAuthorUsername(){
        return $this->authorUsername;
    }

    public function getAuthorProfilePicture(){
        return $this->authorProfilePicture;
    }
}
?>
