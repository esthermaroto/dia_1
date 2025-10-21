<?php

class Pedido {
    private $idPedido;
    private $fecha_pedido;
    private $estado;
    private $total;

    public function __construct($idPedido, $fecha_pedido, $estado, $total) {
        $this->idPedido = $idPedido;
        $this->frecha_pedido = $fecha_pedido;
        $this->estado = $estado;
        $this->total = $total;
    }

    public function getIdPedido() {
        return $this->idPedido;
    }

    public function getFechaPedido() {
        return $this->fecha_pedido;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function getTotal() {
        return $this->total;
    }
}