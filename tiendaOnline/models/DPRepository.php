<?php
class DPRepository {
    public static function createDetalle($id_pedido, $id_producto, $cantidad, $precio_unitario) {
       $db = Connection::connect();
       $q = "INSERT INTO detalle_pedido (id_pedido, id_producto, cantidad, precio_unitario) VALUES ('".intval($id_pedido)."','".intval($id_producto)."','".intval($cantidad)."','".intval($precio_unitario)."')";
       $db->query($q);
         return $db->insert_id;
         
    }

    //calcular total de un pedido
    public static function calculateTotal($idPedido) {
        $db = Connection::connect();
        $q = "SELECT SUM(p.precio * cp.cantidad) AS total
              FROM carrito_productos cp
              JOIN productos p ON cp.idProducto = p.idProducto
              WHERE cp.idPedido = ".intval($idPedido);
        $result = $db->query($q);
        if ($row = $result->fetch_assoc()) {
            return $row['total'];
        }
        return 0;
    }
}