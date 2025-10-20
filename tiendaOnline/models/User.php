<?php
class User{

    private $username;
    private $id;
    private $rol;
    private $profilePicture;


    public function __construct($username, $id, $rol, $profilePicture = null){
        $this->username = $username;
        $this->id = $id;
        $this->rol = $rol;
        $this->profilePicture = $profilePicture;
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

    public function getProfilePicture(){
        return $this->profilePicture;
    }
}
?>