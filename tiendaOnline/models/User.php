<?php
class User{

    private $username;
    private $idUsuario;
    private $rol;
    private $profilePicture;

    public function __construct($username, $idUsuario, $rol, $profilePicture = null){
        $this->username = $username;
        $this->idUsuario = $idUsuario;
        $this->rol = $rol;
        $this->profilePicture = $profilePicture;
    }

    public function getUsername(){
        return $this->username;
    }


    public function getidUsuario(){
        return $this->idUsuario;
    }

    public function getRol(){
        return $this->rol;
    }

    public function getProfilePicture(){
        return $this->profilePicture;
    }

}
?>