<?php

class Pedido {
    private $idProducto;
    private $name;
    private $description;
    private $stock;
    private $price;
    private $imagen;
    private $disponibilidad;

    public function __construct($idProducto, $name, $description, $stock, $price, $imagen, $disponibilidad) {
        $this->idProducto = $idProducto;
        $this->name = $name;
        $this->description = $description;
        $this->stock = $stock;
        $this->price = $price;
        $this->imagen = $imagen;
        $this->disponibilidad = $disponibilidad;
    }

    public function getIdProducto() {
        return $this->idProducto;
    }

    public function getName() {
        return $this->name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getStock() {
        return $this->stock;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getImagen() {
        return $this->imagen;
    }

    public function getDisponibilidad() {
        return $this->disponibilidad;
    }
}