<?php

class Pedido {
    private $idPedido;
    private $product;
    private $cuantity;
    private $total;

    public function __construct($idPedido, $product, $cuantity, $total) {
        $this->idPedido = $idPedido;
        $this->product = $product;
        $this->cuantity = $cuantity;
        $this->total = $total;
    }

    public function getIdPedido() {
        return $this->idPedido;
    }

    public function getProduct() {
        return $this->product;
    }
    
    public function getCuantity() {
        return $this->cuantity;
    }

    public function getTotal() {
        return $this->total;
    }
}