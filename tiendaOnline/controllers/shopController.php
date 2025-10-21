<?php
$db = Connection::connect();
require_once 'models/Producto.php';

//nuevo producto (solo admin)
if(isset($_GET['action']) && $_GET['action'] == 'newProduct'){
    require_once 'views/newProductView.phtml';
    exit;
}

//ver carrito
if(isset($_GET['action']) && $_GET['action'] == 'viewCart'){
    require_once 'views/cartView.phtml';
    exit;
}


//vista de la tienda (default)
require_once 'models/ProductoRepository.php';
require_once 'views/shopView.phtml';
exit;

//agregar nuevo producto
if(isset($_POST['addProduct'])){
    $name = $_POST['name'];
    $description = $_POST['description'];
    $stock = $_POST['stock'];
    $price = $_POST['price'];
    $imagen = 'default_product.png';
    //comprobar si se ha subido una imagen
    if (isset($_FILES['productPicture']) && $_FILES['productPicture']['error'] === UPLOAD_ERR_OK) {
        $originalName = $_FILES['productPicture']['name'];
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
        // 3. Generar un nombre único para evitar sobreescribir archivos.
        $uniqueFilename = uniqid('user_', true) . '.' . $extension;
        
        // 4. Mover el archivo y, si tiene éxito, usar el nuevo nombre.
        if (FileHelper::fileHandler($_FILES['productPicture']['tmp_name'], 'img/productos/' . $uniqueFilename)) {
            $filename = $uniqueFilename;
        }
    }
    if(!ProductoRepository::createProduct($name, $description, $stock, $price, $imagen)){
        $message = "❌ No se ha podido crear el producto.";
    } else {
        // Redirigir a la tienda para ver el nuevo producto
        header('Location: index.php?c=shop&add=success');
        exit;
    }
}

//nuevo producto (solo admin)
if(isset($_GET['action']) && $_GET['action'] == 'newProduct'){
    require_once 'views/newProductView.phtml';
    exit;
}

//vista de la tienda (default)
$productos = ProductoRepository::getAllProducts();
require_once 'views/shopView.phtml';
