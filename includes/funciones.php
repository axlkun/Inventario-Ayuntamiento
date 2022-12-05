<?php

require 'app.php';

function incluirTemplate(string $nombre, bool $inicio = false ){
    include TEMPLATES_URL . "/${nombre}.php";
}

function estaAutenticado() : bool{
    session_start();

    $auth = $_SESSION['login'];

    if($auth){
        return true;
    }
    return false;
}

function rolNormal() : bool{
    // session_start();

    $auth = $_SESSION['login'];
    $auth2 = $_SESSION['rol'];

    if($auth){
        if($auth2 == 2){
            return true;
        }
        
    }
    return false;
}


