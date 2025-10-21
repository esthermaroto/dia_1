<?php
require_once 'models/User.php';
session_start();

// Inicializar sesión si no existe
if(!isset($_SESSION['user'])){
    $_SESSION['user'] = false;
}

// Detectar qué controlador cargar
if(isset($_GET['c'])){
    require_once('controllers/'.$_GET['c'].'Controller.php');
} else {
    // Siempre mostrar la tienda
    require_once('controllers/shopController.php');
}
