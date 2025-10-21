<?php
class Tema {
    private $id;
    private $title;
    private $text;
    private $author;
    private $datetime;
    private $authorUsername;
    private $authorProfilePicture;
    private $comments;

    public function __construct($id, $title, $text, $author, $datetime, $authorUsername = null, $authorProfilePicture = null) {
        $this->id = $id;
        $this->title = $title;
        $this->text = $text;
        $this->author = $author;
        $this->datetime = $datetime;
        $this->authorUsername = $authorUsername;
        $this->authorProfilePicture = $authorProfilePicture;
        $this->comments = array();
    }

    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getText() {
        return $this->text;
    }

    public function getAuthor() {
        return $this->author;
    }

    public function getDatetime() {
        return $this->datetime;
    }

    public function getAuthorUsername() {
        return $this->authorUsername;
    }

    public function getAuthorProfilePicture() {
        return $this->authorProfilePicture;
    }

    public function getComments() {
        return $this->comments;
    }
}
?>
