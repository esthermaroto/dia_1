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
    public static function updateProduct($idProducto, $name, $description, $stock, $price, $imagen) {
        $db = Connection::connect();
        $id = intval($idProducto);
        $stock = intval($stock);
        $price = floatval($price);

        $sql = "UPDATE producto 
                SET name='$name', description='$description', stock=$stock, price=$price, imagen='$imagen' 
                WHERE idProducto=$id";
        return $db->query($sql);
    }
}
