<?php

//require 'includes/funciones.php';
//incluirTemplate('header-registros');
require 'includes/config/database.php';
$db = conectarDB();

$columns = ['idDispositivo','numeroSerie','nombreDispositivo','dependencia','dependencia2','fechaEntrega','nombreRecibio'];
$table = "registroequipo";

$campo = isset($_POST['campo']) ? mysqli_real_escape_string($db, $_POST['campo']) : null; 

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
ORDER BY fechaEntrega DESC";
$resultado = mysqli_query($db,$sql);
$num_rows = $resultado->num_rows;

$html = '';

if($num_rows > 0){
    // while($row = $resultado->fetch_assoc()){
        while($row = mysqli_fetch_assoc($resultado)){
        $fecha = date("d/m/Y", strtotime($row['fechaEntrega']));
        $html .= '<tr>';
        $html .= '<td data-titulo="Numero de serie">'.$row['numeroSerie'].'</td>';
        $html .= '<td data-titulo="Dispositivo">'.$row['nombreDispositivo'].'</td>';
        $html .= '<td data-titulo="Pertenece">'.$row['dependencia'].'</td>';
        $html .= '<td data-titulo="Se prestó">'.$row['dependencia2'].'</td>';
        $html .= '<td data-titulo="Fecha de entrega">'. $fecha .'</td>';
        // $html .= '<td class="ocultar">'.$row['nombreRecibio'].'</td>';
        $html .= 
        '<td>'.
            '<div class="botonesTabla2">' .
                '<div class="botonSeparacion2">' .
                    '<a href="/inventario_ayuntamiento/ver-inventario.php?id='. $row['idDispositivo'] . '" class="boton-verde-tabla">'.
                        '<img class="icono2" src="/inventario_ayuntamiento/src/img/icono3.svg" alt="ver">' .
                    '</a>' .
                '</div>' .

                
                '<div class="botonSeparacion2" style="display: <?php if($rol){echo \'none\';} else{echo \'block\';} ?> ;">' .
                    '<a href="/inventario_ayuntamiento/actualizar-inventario.php?id='. $row['idDispositivo'] . '" class="boton-amarillo-tabla">' .
                        '<img class="icono2" src="/inventario_ayuntamiento/src/img/icono4.svg" alt="actualizar">' . 
                    '</a>' .
                '</div>' .  
                
                '<div class="botonSeparacion2" style="display: <?php if($rol){echo \'none\';} else{echo \'block\';} ?> ;">' .
                    '<a href="delete-inventario.php?id='. $row['idDispositivo'] . '" class=\'boton-rojo-tabla del-btn\'>'.
                    //'<a href=" " class=\'del-btn boton-rojo-tabla\'>'.
                        '<img class="icono2" src="/inventario_ayuntamiento/src/img/icono1.svg" alt="eliminar">' . 
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