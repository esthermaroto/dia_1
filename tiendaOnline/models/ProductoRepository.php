<?php
class ProductoRepository {
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
