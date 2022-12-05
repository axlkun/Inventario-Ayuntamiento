<?php

//require 'includes/funciones.php';
//incluirTemplate('header-registros');
require 'includes/config/database.php';
$db = conectarDB();

$columns = ['idrecordatorios','asunto','texto'];
$table = "recordatorios";

$campo = isset($_POST['camporecordatorio']) ? mysqli_real_escape_string($db, $_POST['camporecordatorio']) : null; 

// $campo = mysqli_real_escape_string($db, $_POST['campo']) ?? null; es lo mismo que la linea de arriba

/* Filtrado */
$where = '';

if ($campo != null) {
    $where = "WHERE (";

    $cont = count($columns);
    for ($i = 0; $i < $cont; $i++) {
        $where .= $columns[$i] . " LIKE '%" . $campo . "%' OR ";
    }
    $where = substr_replace($where, "", -3); //elimina el ultimo OR del $where
    $where .= ")";
}

$sql = "SELECT " . implode(", ",$columns) . "
FROM $table
$where
ORDER BY idrecordatorios DESC";
$resultado = mysqli_query($db,$sql);
$num_rows = $resultado->num_rows;

$html = '';

if($num_rows > 0){
    // while($row = $resultado->fetch_assoc()){
        while($row = mysqli_fetch_assoc($resultado)){
        
        $html .= '<tr>';
        $html .= '<td data-titulo="Asunto">'.$row['asunto'].'</td>';
        $html .= '<td data-titulo="Texto"> <div class="wrap">'.$row['texto'].'</div> </td>';
        $html .= '</tr>';
    }
}else{
    $html .= '<tr>';
    $html .= '<td colspan="7">Sin resultados</td>';
    $html .= '</tr>';
}

echo json_encode($html,JSON_UNESCAPED_UNICODE);