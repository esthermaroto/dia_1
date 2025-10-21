<?php
require_once 'db.php';

class DPRepository {
    public static function createDetalle($id_pedido, $id_producto, $cantidad, $precio_unitario) {
       $db = Connection::connect();
       $q = "INSERT INTO detalle_pedido (id_pedido, id_producto, cantidad, precio_unitario) VALUES ('".intval($id_pedido)."','".intval($id_producto)."','".intval($cantidad)."','".floatval($precio_unitario)."')";
       
       if ($db->query($q)) {
           return $db->insert_id;
       } else {
           error_log("Error al insertar detalle pedido: " . $db->error);
           return false;
       }
    }

    //calcular total de un pedido
    public static function calculateTotal($idPedido) {
        $db = Connection::connect();
        $q = "SELECT SUM(dp.precio_unitario * dp.cantidad) AS total
              FROM detalle_pedido dp
              WHERE dp.id_pedido = ".intval($idPedido);
        $result = $db->query($q);
        if ($row = $result->fetch_assoc()) {
            return $row['total'];
        }
        return 0;
    }
}