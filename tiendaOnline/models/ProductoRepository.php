<?php
class ProductoRepository {
<<<<<<< HEAD
    // Crear un nuevo producto
    public static function createProduct($name, $description, $stock, $price, $imagen) {
    $db = Connection::connect();
    $sql = "INSERT INTO producto (name, description, stock, price, imagen) VALUES (?, ?, ?, ?, ?)";
    $stmt = $db->prepare($sql);
    if (!$stmt) die("Error: " . $db->error);
    $stmt->bind_param("ssids", $name, $description, $stock, $price, $imagen);
    if ($stmt->execute()) {
        $stmt->close();
        return true;
    }
    return false;
}


    //Eliminar un producto por su ID
    public static function deleteProduct($idProducto) {
=======

    // Crear producto solo si hay stock
    public static function createProduct($name, $description, $stock, $price, $imagen) {
>>>>>>> 349d67df1e84e5f28d835527c53510eb80567520
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
<<<<<<< HEAD
        $q = "SELECT * FROM producto";
        $result = $db->query($q);
        $products = array();
        while ($row = $result->fetch_assoc()) {
            $products[] = new Producto($row['idProducto'], $row['name'], $row['description'], $row['stock'], $row['price'], $row['imagen']);
            }
        return $products;
=======
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
>>>>>>> 349d67df1e84e5f28d835527c53510eb80567520
    }
}
