<?php 

    require 'includes/funciones.php';
    
    $auth = estaAutenticado();
    $rol = rolNormal();

    if($rol){
        incluirTemplate('header-registros-user');
    }else{
        incluirTemplate('header-registros');
    }

    if(!$auth){
        header('Location: /inventario_ayuntamiento/index.php');
    }

    //Validar URL por ID valido
    $id = $_GET['id'];
    $id = filter_var($id,FILTER_VALIDATE_INT);

    if(!$id){
        header('Location: /inventario_ayuntamiento/registros-inventario.php');
    }

    //base de datos
    require 'includes/config/database.php';
    $db = conectarDB();

    $consulta = "SELECT * FROM registroequipo 
    INNER JOIN personalsistemas 
    ON registroequipo.PersonalSistemas_idPersona = personalsistemas.idPersona where idDispositivo = ${id}";

    // echo $consulta;
    $resultado = mysqli_query($db,$consulta);
    $registro = mysqli_fetch_assoc($resultado);

    // echo "<pre>";
    // echo var_dump($registro);
    // echo "</pre>";

    //consultar para obtener el personal de sistemas
    $consulta1 = "SELECT * FROM personalsistemas";
    $resultado1 = mysqli_query($db,$consulta1);

    //Arreglo con mensaje de errores
    $errores = [];

    $numeroSerie = $registro['numeroSerie'];
    $nombreDispositivo = $registro['nombreDispositivo'];
    $estado = $registro['estado'];
    $fechaEntrega = $registro['fechaEntrega'];
    $nombreRecibio = $registro['nombreRecibio'];
    $dependencia = $registro['dependencia'];
    $dependencia2 = $registro['dependencia2'];
    $personalSistemasId = $registro['PersonalSistemas_idPersona'];
    $descripcion = $registro['descripcion'];

    
?>

    <main class="contenedor seccion contenido-centrado">
        <h1 class="tituloMargin">Ver registro</h1>

        <a href="<?php if($rol){echo "/inventario_ayuntamiento/registros-inventario-user.php";}else{echo "/inventario_ayuntamiento/registros-inventario.php";} ?>  " class="boton boton-rojo marginArriba">Volver</a> 
        
        <!--Para enviar informacion sensible su utiliza POST, para obtener datos de un servidor se utiliza GET  -->
        <form class="formulario" method="POST" enctype="multipart/form-data">
            <fieldset>
                <legend>Informacion del registro</legend>

                <label for="numeroSerie">Numero de serie:</label>
                <input type="text" id="numeroSerie" name="numeroSerie" placeholder="Ingrese el numero de serie" value="<?php echo $numeroSerie; ?>" disabled>

                <label for="nombreDispositivo">Objeto/Dispositivo entregado:</label>
                <input type="text" id="nombreDispositivo" name="nombreDispositivo" placeholder="Registre que objeto, dispositivo o material fué entregado" value="<?php echo $nombreDispositivo; ?>" disabled>

                <label for="estado">Estado del dispositivo:</label>
                <select name="estado" id="estado" disabled>
                <option value="">-- Seleccione el estado en el que se entregó --</option>
                    <option value="1" <?php echo $select = ($estado =='01')? 'selected' : ''; ?> >Funcional</option>
                    <option value="2" <?php echo $select = ($estado =='02')? 'selected' : ''; ?> >No funcional</option>
                </select>

                <label for="fechaEntrega">Fecha de entrega</label>
                <input type="date" id="fechaEntrega" name="fechaEntrega" value="<?php echo $fechaEntrega?>" disabled>

                <label for="nombreRecibio">Persona que recibió:</label>
                <input type="text" id="nombreRecibio" name="nombreRecibio" placeholder="Ingrese el nombre de la persona que recibió" value="<?php echo $nombreRecibio; ?>" disabled>

                <label for="dependencia">Departamento al que pertenece:</label>
                <input type="text" id="dependencia" name="dependencia" placeholder="Registre donde fué entregado" value="<?php echo $dependencia; ?>" disabled>

                <label for="dependencia2">Departamento al que se prestó:</label>
                <input type="text" id="dependencia2" name="dependencia2" placeholder="Registre donde fué entregado" value="<?php echo $dependencia2; ?>" disabled>

                <label for="personalSistemasId">Personal de sistemas:</label>
                <select name="personalSistemasId" disabled>
                    <option value="">-- Seleccione quien entregó --</option>
                    <?php while($persona = mysqli_fetch_assoc($resultado1)): ?>
                        <option <?php echo $personalSistemasId === $persona['idPersona'] ? 'selected' : ''; ?> value="<?php echo $persona['idPersona']; ?>"> <?php echo $persona['nombrePersona'] . " " . $persona['apellidos']; ?> </option>
                    <?php endwhile; ?>    
                </select>

                <label for="descripcion">Descripcion (Opcional):</label>
                <textarea id="descripcion" name="descripcion" disabled><?php echo $descripcion; ?></textarea>

            </fieldset>

            <!-- <input type="submit" value="Actualizar" class="boton boton-verde"> -->
        </form>

    </main>

<?php 
    incluirTemplate('footer-registros'); 
?>