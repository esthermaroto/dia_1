<?php
class User{

    private $username;
    private $id;
    private $rol;


    public function __construct($username, $id, $rol = 1){
        $this->username = $username;
        $this->id = $id;
        $this->rol = $rol;
    }

    public function getUsername(){
        return $this->username;
    }


    public function getId(){
        return $this->id;
    }

    public function getRol(){
        return $this->rol;
    }

}
?>