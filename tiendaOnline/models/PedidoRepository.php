<?php
class PedidoRepository {
    public static function createPedido($fecha_pedido, $estado, $total) {
        $db = Connection::connect();
        $stmt = $db->prepare("INSERT INTO pedidos (fecha_pedido, estado, total) VALUES (:fecha_pedido, :estado, :total)");
        $stmt->bindParam(':fecha_pedido', $fecha_pedido);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':total', $total);
        return $stmt->execute();
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
