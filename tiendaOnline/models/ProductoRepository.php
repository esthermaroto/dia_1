<?php
require_once 'db.php';

class ProductoRepository {

    // Crear producto solo si hay stock
    public static function createProduct($name, $description, $stock, $price, $imagen) {
        $db = Connection::connect();

        if ($stock <= 0) return false;

        $stock = intval($stock);
        $price = floatval($price);

        $sql = "INSERT INTO producto (name, description, stock, price, imagen) 
                VALUES ('$name', '$description', $stock, $price, '$imagen')";
        return $db->query($sql);
    }

    // Obtener todos los productos
    public static function getAllProducts() {
        $db = Connection::connect();
        $result = $db->query("SELECT * FROM producto");

        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = new Producto(
                $row['idProducto'],
                $row['name'],
                $row['description'],
                $row['stock'],
                $row['price'],
                $row['imagen']
            );
        }

        return $products;
    }

    // Obtener un producto por su ID
    public static function getProductById($idProducto) {
        $db = Connection::connect();
        $id = intval($idProducto);
        $result = $db->query("SELECT * FROM producto WHERE idProducto=$id");

        if ($row = $result->fetch_assoc()) {
            return new Producto(
                $row['idProducto'],
                $row['name'],
                $row['description'],
                $row['stock'],
                $row['price'],
                $row['imagen']
            );
        }
        return null;
    }

    // Eliminar producto
    public static function deleteProduct($idProducto) {
        $db = Connection::connect();
        $id = intval($idProducto);
        return $db->query("DELETE FROM producto WHERE idProducto=$id");
    }

    // Actualizar producto
    public static function updateProduct($idProducto, $name, $description, $stock, $price, $imagen = null) {
    $db = Connection::connect();
    $id = intval($idProducto);
    $stock = intval($stock);
    $price = floatval($price);

    // Si no se ha enviado nueva imagen, no actualizar la columna 'imagen'
    if ($imagen === null) {
        $sql = "UPDATE producto 
                SET name='$name', description='$description', stock=$stock, price=$price 
                WHERE idProducto=$id";
    } else {
        $sql = "UPDATE producto 
                SET name='$name', description='$description', stock=$stock, price=$price, imagen='$imagen' 
                WHERE idProducto=$id";
    }

    return $db->query($sql);
}

    // Reducir stock de un producto
    public static function reduceStock($idProducto, $cantidad) {
        $db = Connection::connect();
        $id = intval($idProducto);
        $cantidad = intval($cantidad);
        
        // Primero verificar que hay suficiente stock
        $product = self::getProductById($id);
        if (!$product || $product->getStock() < $cantidad) {
            return false;
        }
        
        // Reducir el stock
        $sql = "UPDATE producto SET stock = stock - $cantidad WHERE idProducto = $id";
        return $db->query($sql);
    }

    // Verificar si hay suficiente stock
    public static function hasEnoughStock($idProducto, $cantidad) {
        $product = self::getProductById($idProducto);
        if (!$product) {
            return false;
        }
        return $product->getStock() >= $cantidad;
    }

    // Obtener stock actual de un producto
    public static function getCurrentStock($idProducto) {
        $product = self::getProductById($idProducto);
        return $product ? $product->getStock() : 0;
    }
}
