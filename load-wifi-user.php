<?php

//require 'includes/funciones.php';
//incluirTemplate('header-registros');
require 'includes/config/database.php';
$db = conectarDB();

$columns = ['idwifi','nombrewifi','contraseña','pertenece'];
$table = "wifi";

$campo = isset($_POST['campowifi']) ? mysqli_real_escape_string($db, $_POST['campowifi']) : null; 

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
ORDER BY idwifi DESC";
$resultado = mysqli_query($db,$sql);
$num_rows = $resultado->num_rows;

$html = '';

if($num_rows > 0){
    // while($row = $resultado->fetch_assoc()){
        while($row = mysqli_fetch_assoc($resultado)){
        
        $html .= '<tr>';
        $html .= '<td data-titulo="SSID">'.$row['nombrewifi'].'</td>';
        $html .= '<td data-titulo="Contraseña">'.$row['contraseña'].'</td>';
        $html .= '<td data-titulo="Ubicación" class="formatoLetra">'.$row['pertenece'].'</td>';
        $html .= 
        '<td>'.
            '<div class="botonesTabla">' .
                '<div class="botonSeparacion">' .
                    '<a href="/inventario_ayuntamiento/ver-wifi.php?id='. $row['idwifi'] . '" class="boton-verde-tabla">'.
                        '<img class="icono" src="/inventario_ayuntamiento/src/img/icono3.svg" alt="ver">' .
                    '</a>' .
                '</div>' .

            '</div>' .
        '</td>';
        $html .= '</tr>';
    }
}else{
    $html .= '<tr>';
    $html .= '<td colspan="7">Sin resultados</td>';
    $html .= '</tr>';
}

echo json_encode($html,JSON_UNESCAPED_UNICODE);