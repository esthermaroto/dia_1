<?php
require_once 'models/Producto.php';
require_once 'models/ProductoRepository.php';
require_once 'helpers/FileHelper.php';




//agregar nuevo producto
if(isset($_POST['addProduct'])){
    $name = $_POST['name'];
    $description = $_POST['description'];
    $stock = $_POST['stock'];
    $price = $_POST['price'];
    $filename = 'default_product.png'; // Nombre por defecto

    //no añadir productos sin stock
    if (intval($stock) <= 0) {
        $message = "❌ No se puede agregar un producto sin stock.";
        require_once 'views/newProductView.phtml';
        exit;
    }

    //comprobar si se ha subido una imagen
    if (isset($_FILES['productPicture']) && $_FILES['productPicture']['error'] === UPLOAD_ERR_OK) {
        $originalName = $_FILES['productPicture']['name'];
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
        // Generar un nombre único para evitar sobreescribir archivos.
        $uniqueFilename = uniqid('product_', true) . '.' . $extension;
        
        // Mover el archivo y, si tiene éxito, usar el nuevo nombre.
        if (FileHelper::fileHandler($_FILES['productPicture']['tmp_name'], 'img/productos/' . $uniqueFilename)) {
            $filename = $uniqueFilename;
        }
    }

    if(ProductoRepository::createProduct($name, $description, $stock, $price, $filename)){
        // Redirigir para evitar reenvío del formulario con F5
        header('Location: index.php?c=shop&message=created');
        exit;
    } else {
        $message = "❌ No se ha podido crear el producto.";
        // Si falla, volvemos a mostrar el formulario con el mensaje de error
        require_once 'views/newProductView.phtml';
        exit;
    }
}

// Gestión de vistas por GET
if(isset($_GET['action']) && $_GET['action'] == 'newProduct'){
    require_once 'views/newProductView.phtml';
    exit;
} elseif(isset($_GET['action']) && $_GET['action'] == 'viewCart'){
    require_once 'views/cartView.phtml';
    exit;
}

//vista de la tienda (default)
$productos = ProductoRepository::getAllProducts();
require_once 'views/shopView.phtml';
