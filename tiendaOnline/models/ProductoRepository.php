<?php
class ProductoRepository {
    // Crear un nuevo producto
    public static function createProduct($name, $description, $stock, $price, $imagen) {
        $db = Connection::connect();
        $q = "INSERT INTO producto (name, description, stock, price, imagen) VALUES('" . $name . "','" . $description . "','" . $stock . "','" . $price . "','" . $imagen . "')";
        $db->query($q);
    }

    //Eliminar un producto por su ID
    public static function deleteProduct($idProducto) {
        $db = Connection::connect();
        $q = "DELETE FROM producto WHERE idProducto=".intval($idProducto);
        $db->query($q);
    }

    
    // Obtener un producto por su ID
    public static function getProductById($idProducto) {
        $db = Connection::connect();
        $q = "SELECT * FROM producto WHERE idProducto=".intval($idProducto);
        $result = $db->query($q);
        if ($row = $result->fetch_assoc()) {
            return new Producto($row['idProducto'], $row['name'], $row['description'], $row['stock'], $row['price'], $row['imagen']);
        }
        return null;
    }


    // Obtener todos los productos de la base de datos
    public static function getAllProducts() {
        $db = Connection::connect();
        $q = "SELECT * FROM producto";
        $result = $db->query($q);
        $products = array();
        while ($row = $result->fetch_assoc()) {
            $products[] = new Producto($row['idProducto'], $row['name'], $row['description'], $row['stock'], $row['price'], $row['imagen'], $row['disponibilidad']);
            }
        return $products;
    }
}
