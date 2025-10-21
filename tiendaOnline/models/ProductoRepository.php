<?php
class ProductoRepository {
    // Crear un nuevo producto
<<<<<<< HEAD
    public static function registerProduct($name, $description, $stock, $price, $productPicture = null) {
    $db = Connection::connect();

    // Verificar que los datos mínimos estén presentes
    if (!empty($name) && !empty($price)) {

        // Comprobar si ya existe un producto con el mismo nombre
        $query = 'SELECT * FROM productos WHERE nombre="' . $name . '"';
        $result = $db->query($query);

        if ($result && $result->fetch_assoc()) {
            $message = "❌ Ese producto ya existe.";
        } else {
            // Procesar la imagen si se subió una
            $imagePath = null;
            if (!empty($_FILES['productPicture']['name'])) {
                $uploadDir = "uploads/";
                $imagePath = $uploadDir . basename($_FILES['productPicture']['name']);
                move_uploaded_file($_FILES["productPicture"]["tmp_name"], $imagePath);
            } elseif ($productPicture !== null) {
                $imagePath = $productPicture;
            }

            // Crear el nuevo registro en la base de datos
            $insert = 'INSERT INTO productos (nombre, descripcion, stock, precio, imagen_url)
                       VALUES ("' . $name . '", "' . $description . '", ' . (int)$stock . ', ' . (float)$price . ', "' . $imagePath . '")';

            if ($db->query($insert)) {
                $idProducto = $db->insert_id;
                $message = "✅ Producto creado correctamente (ID: $idProducto).";

                // Si quieres, aquí se puede cargar una vista o redirigir
                // require_once 'views/productView.phtml';
                // exit;
            } else {
                $message = "❌ Error al registrar el producto: " . $db->error;
            }
        }
    } else {
        $message = "⚠️ Faltan campos obligatorios (nombre o precio).";
=======
    public static function createProduct($name, $description, $stock, $price, $imagen) {
    $db = Connection::connect();
    $sql = "INSERT INTO producto (name, description, stock, price, imagen) VALUES (?, ?, ?, ?, ?)";
    $stmt = $db->prepare($sql);
    if (!$stmt) die("Error: " . $db->error);
    $stmt->bind_param("ssids", $name, $description, $stock, $price, $imagen);
    if ($stmt->execute()) {
        $stmt->close();
        return true;
>>>>>>> 6e29906b5040cc1ea421ef9e543bd906c45805a8
    }
    return false;
}



    echo $message;
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
