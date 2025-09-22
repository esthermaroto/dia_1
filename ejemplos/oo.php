<?php

class Car{
    private $marca;
    private $modelo;
    private $color;

    public function __construct($marca,$modelo,$color){
        $this->marca=$marca;
        $this->modelo=$modelo;
        $this->color=$color;
    }
    public function getMarca(){
        return $this->marca;
    }
    public function getModelo(){
        return $this->modelo;
    }   
    public function getColor(){
        return $this->color;
    }
    public function setMarca($marca){
        $this->marca=$marca;
    }
    public function setModelo($modelo){
        $this->modelo=$modelo;
    }
    public function setColor($color){
        $this->color=$color;
    }
}

$cars[]= new Car("seat","leon","rojo");
$cars[]= new Car("ferrari","chulo", "negro");
$cars[]= new Car("seat","panda","azul");

if(isset($_GET["delete"])){
    foreach ($cars as $car){
        if($car->getColor() == $_GET["delete"]){
            $car->setColor("borrado");
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documento</title>
</head>
<body>
    <?php
    
    foreach($cars as $car){
        echo "color: ".$car->getColor()." marca: ".$car->getMarca()." modelo: ".$car->getModelo()."
        <a href='oo.php?delete=".$car->getColor()."'>borrar</a> <br>" ;
    }
    
    ?>
</body>
</html>