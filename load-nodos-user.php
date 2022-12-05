<?php

//require 'includes/funciones.php';
//incluirTemplate('header-registros');
require 'includes/config/database.php';
$db = conectarDB();

$columns = ['idnodos','dependencia','red','informacionNodo'];
$table = "nodos";

$campo = isset($_POST['camponodo']) ? mysqli_real_escape_string($db, $_POST['camponodo']) : null; 

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
ORDER BY idnodos DESC";
$resultado = mysqli_query($db,$sql);
$num_rows = $resultado->num_rows;

$html = '';

if($num_rows > 0){
    // while($row = $resultado->fetch_assoc()){
        while($row = mysqli_fetch_assoc($resultado)){
        
        $html .= '<tr>';
        $html .= '<td data-titulo="Dependencia">'.$row['dependencia'].'</td>';
        $html .= '<td data-titulo="Red">' .$row['red'].'</td>';
        $html .= '<td data-titulo="Información"> <div class="wrap">'.$row['informacionNodo'].'</div> </td>';
        $html .= '</tr>';
    }
}else{
    $html .= '<tr>';
    $html .= '<td colspan="7">Sin resultados</td>';
    $html .= '</tr>';
}

echo json_encode($html,JSON_UNESCAPED_UNICODE);