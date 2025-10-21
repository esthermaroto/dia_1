<?php
class PedidoRepository {
    public static function createPedido($idUsuario, $total) {
        $db = Connection::connect();
        // El estado por defecto será 'Pendiente'. La fecha se inserta automáticamente con current_timestamp().
        $estado = 'Pendiente';
        $sql = "INSERT INTO pedido (idUsuario, estado, total) VALUES (?, ?, ?)";
        $stmt = $db->prepare($sql);
        if (!$stmt) die("Error: " . $db->error);
        $stmt->bind_param("isd", $idUsuario, $estado, $total);
        if ($stmt->execute()) {
            return $db->insert_id; // Devolvemos el ID del pedido creado.
        }
        return false; // Devolvemos false si falla.
    }

    public static function getAllPedidos() {
        $db = Connection::connect();
        $stmt = $db->query("SELECT * FROM pedidos");
        $pedidos = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $pedidos[] = new Pedido($row['idPedido'], $row['fecha_pedido'], $row['estado'], $row['total']);
        }
        return $pedidos;
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
