<?php

require 'includes/funciones.php';
require 'includes/config/database.php';

if(isset($_GET['id'])){
    $id=$_GET['id'];
}

$db = conectarDB();
 
$query = "DELETE FROM recordatorios WHERE idrecordatorios = '$id'";

$result = mysqli_query($db,$query);
 
 if($result){
     header('Location: /inventario_ayuntamiento/registros-recordatorios.php?m=1');
 }

?>