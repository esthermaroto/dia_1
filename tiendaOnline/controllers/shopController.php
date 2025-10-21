<?php
require_once 'models/Producto.php';
require_once 'models/ProductoRepository.php';
require_once 'helpers/FileHelper.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Detectar si el usuario está logueado
$isLogged = isset($_SESSION['user']) && $_SESSION['user'] !== false;
$isAdmin = $isLogged && $_SESSION['user']->getRol() == 0; // Admin = 0

// AGREGAR NUEVO PRODUCTO (solo si está logueado)
if ($isLogged && isset($_POST['addProduct'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $stock = $_POST['stock'];
    $price = $_POST['price'];
    $filename = 'default_product.png';

    if (intval($stock) <= 0) {
        $message = "❌ No se puede agregar un producto sin stock.";
        require_once 'views/newProductView.phtml';
        exit;
    }

    // Subir imagen
    if (isset($_FILES['productPicture']) && $_FILES['productPicture']['error'] === UPLOAD_ERR_OK) {
        $originalName = $_FILES['productPicture']['name'];
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
        $uniqueFilename = uniqid('product_', true) . '.' . $extension;

        if (FileHelper::fileHandler($_FILES['productPicture']['tmp_name'], 'img/productos/' . $uniqueFilename)) {
            $filename = $uniqueFilename;
        }
    }

    if (ProductoRepository::createProduct($name, $description, $stock, $price, $filename)) {
        header('Location: index.php?c=shop&message=created');
        exit;
    } else {
        $message = "❌ No se ha podido crear el producto.";
        require_once 'views/newProductView.phtml';
        exit;
    }
}

// ELIMINAR PRODUCTO (solo si admin)
if ($isAdmin && isset($_GET['action']) && $_GET['action'] == 'deleteProduct' && isset($_GET['id'])) {
    $idProducto = intval($_GET['id']);
    if (ProductoRepository::deleteProduct($idProducto)) {
        header('Location: index.php?c=shop&message=deleted');
        exit;
    } else {
        echo "❌ No se pudo eliminar el producto.";
        exit;
    }
}

// FORMULARIO NUEVO PRODUCTO (solo si está logueado)
if ($isLogged && isset($_GET['action']) && $_GET['action'] == 'newProduct') {
    require_once 'views/newProductView.phtml';
    exit;
}

// EDITAR PRODUCTO (solo si admin)
if ($isAdmin && isset($_GET['action']) && $_GET['action'] == 'editProduct' && isset($_GET['id'])) {
    $idProducto = intval($_GET['id']);
    $producto = ProductoRepository::getProductById($idProducto);
    if ($producto) {
        require_once 'views/editProductView.phtml';
        exit;
    } else {
        echo "❌ Producto no encontrado.";
        exit;
    }
}

// CARGAR TODOS LOS PRODUCTOS (siempre)
$productos = ProductoRepository::getAllProducts();

// Cargar vista de la tienda
require_once 'views/shopView.phtml';
