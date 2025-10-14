<?php
class UserRepository{
    public static function logUser($username, $password){
        $db = Connection::connect();
        $username = $_POST['username'];
        $password = md5($_POST['password']);
        $q = 'SELECT * FROM users WHERE username="'.$username.'" AND password="'.$password.'"';
        $result = $db->query($q);

        if ($row = $result->fetch_assoc()) {
            $_SESSION['user'] = new User($row['username'], $row['id'], $row['rol']);
            header('Location: index.php');
            exit;
        } else {
            $message = "❌ Usuario o contraseña incorrectos.";
        }
    }

    public static function registerUser($username, $password){
        $db = Connection::connect();
            if(!empty($_POST['username']) && !empty($_POST['password'])){
            $q='SELECT * FROM users WHERE username="'.$_POST['username'].'"';
            $result = $db->query($q);
            if($row = $result->fetch_assoc()){
                $message = "❌ Ese usuario ya existe.";
                
            }
            else{
                    $q = 'INSERT INTO users (username, password) VALUES("'.$_POST['username'].'","'.md5($_POST['password']).'")';            
                    if($db->query($q)){
                    $id = $db->insert_id;
                    $_SESSION['user'] = new User($_POST['username'], $id, 1); // Asignar rol de usuario normal (1)
                    require_once 'views/userView.phtml';
                    exit;
                }
            }
        }
    }

    public static function getUserById($id){
        $db = Connection::connect();
        $q = "SELECT * FROM users WHERE id=" . intval($id);
        $result = $db->query($q);
        if($row = $result->fetch_assoc()){
            return new User($row['username'], $row['id'], $row['rol']);
        }
        return null;
    }
}