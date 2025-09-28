<?php
//cargar modelo
//comprobar variables
//operar
// cargar vista

//--------NACHO--------
require_once('models/User.php');
require_once('models/Movie.php');

session_start();





if(isset($_GET['c'])){
    require_once('controllers/'.$_GET['c'].'Controller.php');
}
else{
    if(!($_SESSION['user'])){
        require_once('controllers/registerController.php');
    }
    else{
        require_once('controllers/movieController.php');
    }
}



    

