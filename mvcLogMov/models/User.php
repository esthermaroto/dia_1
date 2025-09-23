<?php
class User{

    private $username;
    //private $password;
    private $id;


    public function __construct($username, $id){
        $this->username = $username;
        //$this->password = $password;
        $this->id = $id;
    }

    public function getUsername(){
        return $this->username;
    }

    //public function getPassword(){
    //    return $this->password;
    //}
    public function getId(){
        return $this->id;
    }

}
?>