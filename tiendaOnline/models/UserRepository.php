<?php
class UserRepository{
    public static function logUser($username, $password){
        $db = Connection::connect();
        $username = $_POST['username'];
        $password = md5($_POST['password']);
        $q = 'SELECT * FROM users WHERE username="'.$username.'" AND password="'.$password.'"';
        $result = $db->query($q);

        if ($row = $result->fetch_assoc()) {
            // Añadir la foto de perfil al objeto User en la sesión
            $_SESSION['user'] = new User($row['username'], $row['idUsuario'], $row['rol'], $row['profilePicture']);
            header('Location: index.php');
            exit;
        } else {
            $message = "❌ Usuario o contraseña incorrectos.";
        }
    }
 
    public static function registerUser($username, $password, $profilePicture = null){
        $db = Connection::connect();
            if(!empty($_POST['username']) && !empty($_POST['password'])){
            $q='SELECT * FROM users WHERE username="'.$_POST['username'].'"';
            $result = $db->query($q);
            if($row = $result->fetch_assoc()){
                $message = "❌ Ese usuario ya existe."; 
            }
            else{
                // CORRECCIÓN: Se añaden las columnas 'profilePicture' y 'rol' a la consulta.
                $rol = 1; // Rol de usuario por defecto.
                $q = 'INSERT INTO users (username, password, profilePicture, rol) VALUES("'.$_POST['username'].'","'.md5($_POST['password']).'","'.$profilePicture.'",'.$rol.')';
                if($db->query($q)){
                $idUsuario = $db->insert_idUsuario;
                $_SESSION['user'] = new User($_POST['username'], $idUsuario, 1); // Asignar rol de usuario normal (1)
                require_once 'views/userView.phtml';
                exit;
                }
            }
        }
    }

    public static function getUserById($idUsuario){
        $db = Connection::connect();
        $q = "SELECT * FROM users WHERE idUsuario=" . intval($idUsuario);
        $result = $db->query($q);
        if($row = $result->fetch_assoc()){
            // Se añade la foto de perfil para que la información del usuario esté completa.
            return new User($row['username'], $row['idUsuario'], $row['rol'], $row['profilePicture']);
        }
        return null;
    }
}
