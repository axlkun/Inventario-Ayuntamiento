<?php

//importar la conexion
require 'includes/config/database.php';
$db = conectarDB();

//crear email y password
$email = "user2@sistemas.com";
$password = "inv2022";
$rol = 2;

$passwordHash = password_hash($password,PASSWORD_BCRYPT);

//query para crear el usuario
$query = "INSERT INTO usuarios (email,password,rol) VALUES ('${email}', '${passwordHash}', '$rol')";
// echo $query;
// exit;

//agregarlo a la base de datos
// mysqli_query($db,$query);