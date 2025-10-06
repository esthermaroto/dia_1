<?php
class User{

    private $username;
    private $id;


    public function __construct($username, $id){
        $this->username = $username;
        $this->id = $id;
    }

    public function getUsername(){
        return $this->username;
    }


    public function getId(){
        return $this->id;
    }

}
?>