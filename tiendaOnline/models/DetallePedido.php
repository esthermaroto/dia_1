<?php
class DetallePedido {
    private $id_detalle;
    private $id_pedido;
    private $id_producto;
    private $cantidad;
    private $precio_unitario;

    
    public function __construct($id_detalle = null, $id_pedido = null, $id_producto = null, $cantidad, $precio_unitario) {
        $this->id_detalle = $id_detalle;
        $this->id_pedido = $id_pedido;
        $this->id_producto = $id_producto;
        $this->cantidad = $cantidad;
        $this->precio_unitario = $precio_unitario;
    }


    public function getIdDetalle() { return $this->id_detalle; }
    public function getIdPedido() { return $this->id_pedido; }
    public function getIdProducto() { return $this->id_producto; }
    public function getCantidad() { return $this->cantidad; }
    public function getPrecioUnitario() { return $this->precio_unitario; }
}