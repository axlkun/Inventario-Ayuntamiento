<?php 
    require 'includes/funciones.php';
    incluirTemplate('header-registros');

    $auth = estaAutenticado();

    if(!$auth){
        header('Location: /inventario_ayuntamiento/index.php');
    }

    $rol = rolNormal();
    if($rol === true){
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

    //Ejecuta el codigo despues de que el usuario envia el formulario (da clic en el boton)
    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        // echo "<pre>";
        // var_dump($_POST);
        // echo "</pre>";
        // exit; 

        $numeroSerie = mysqli_real_escape_string($db,$_POST['numeroSerie']);
        $nombreDispositivo = mysqli_real_escape_string($db,$_POST['nombreDispositivo']);
        $estado = mysqli_real_escape_string($db,$_POST['estado']);
        $fechaEntrega = mysqli_real_escape_string($db,$_POST['fechaEntrega']);
        $nombreRecibio = mysqli_real_escape_string($db,$_POST['nombreRecibio']);
        $dependencia = mysqli_real_escape_string($db,$_POST['dependencia']);
        $dependencia2 = mysqli_real_escape_string($db,$_POST['dependencia2']);
        $personalSistemasId = mysqli_real_escape_string($db,$_POST['personalSistemasId']);
        $descripcion = mysqli_real_escape_string($db,$_POST['descripcion']);
    
        if(!$numeroSerie){
            $errores[] = "Debes añadir el numero de serie";
        }

        if(!$nombreDispositivo){
            $errores[] = "Debes añadir que dispositivo fué entregado";
        }

        if(!$estado){
            $errores[] = "Debes añadir en que estado se encuentra el dispositivo";
        }

        if(!$fechaEntrega){
            $errores[] = "Debes añadir la fecha en la que se entregó";
        }

        if(!$nombreRecibio){
            $errores[] = "Debes añadir el nombre de quien recibió";
        }


        if(!$dependencia){
            $errores[] = "Debes añadir la dependencia a la que pertenece";
        }

        if(!$personalSistemasId){
            $errores[] = "Debes añadir quien lo entregó";
        }

        //revisar que el arreglo de errores esté vacío
        if(empty($errores)){

            //Insertar en la base de datos

            $query3 = "UPDATE registroequipo SET numeroSerie = '${numeroSerie}', nombreDispositivo = '${nombreDispositivo}', estado = ${estado}, fechaEntrega = '${fechaEntrega}', nombreRecibio = '${nombreRecibio}', descripcion = '${descripcion}', dependencia = '${dependencia}', dependencia2 = '${dependencia2}', PersonalSistemas_idPersona = ${personalSistemasId} WHERE idDispositivo = ${id} ";


            // echo $query3; //para ver si si jala correctamente los valores a las variables para posteriormente hacer la insercion
            // exit;

            $resultado3 = mysqli_query($db,$query3); //se le pasa la conexion a la BDD y el query a ejecutar

            if($resultado3){
                echo '<script>
                swal("Buen trabajo!", "Registro actualizado!", "success")
                .then(function() {
             window.location = "/inventario_ayuntamiento/registros-inventario.php";
          });
                    </script>';
            }
        }
        
    }

     //al momento de entrar en ejecucion la variable se vuelve true, o sea cada que se abra el index.php
    //include "includes/templates/header.php"
    
?>

    <main class="contenedor seccion contenido-centrado">
        <h1 class="tituloMargin">Actualizar registro</h1>

        <a href="/inventario_ayuntamiento/registros-inventario.php" class="boton boton-rojo marginArriba">Volver</a> 

        <!-- Mensaje de error validacion. for each se ejecuta al menos una vez por cada elemento en el arreglo, si no hay nada, no se ejecuta -->
        <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>    

        <!--Para enviar informacion sensible su utiliza POST, para obtener datos de un servidor se utiliza GET  -->
        <form class="formulario" method="POST" enctype="multipart/form-data">
            <fieldset>
                <legend>Informacion del registro</legend>

                <label for="numeroSerie">Numero de serie:</label>
                <input type="text" id="numeroSerie" name="numeroSerie" placeholder="Ingrese el numero de serie" value="<?php echo $numeroSerie; ?>">

                <label for="nombreDispositivo">Objeto/Dispositivo entregado:</label>
                <input type="text" id="nombreDispositivo" name="nombreDispositivo" placeholder="Registre que objeto, dispositivo o material fué entregado" value="<?php echo $nombreDispositivo; ?>">

                <label for="estado">Estado del dispositivo:</label>
                <select name="estado" id="estado">
                <option value="">-- Seleccione el estado en el que se entregó --</option>
                    <option value="1" <?php echo $select = ($estado =='01')? 'selected' : ''; ?> >Funcional</option>
                    <option value="2" <?php echo $select = ($estado =='02')? 'selected' : ''; ?> >No funcional</option>
                </select>

                <label for="fechaEntrega">Fecha de entrega</label>
                <input type="date" id="fechaEntrega" name="fechaEntrega" value="<?php echo $fechaEntrega?>">

                <label for="nombreRecibio">Persona que recibió:</label>
                <input type="text" id="nombreRecibio" name="nombreRecibio" placeholder="Ingrese el nombre de la persona que recibió" value="<?php echo $nombreRecibio; ?>">

                <label for="dependencia">Departamento al que pertenece:</label>
                <input type="text" id="dependencia" name="dependencia" placeholder="Registre la dependencia/departamento a donde pertenece" value="<?php echo $dependencia; ?>">

                <label for="dependencia2">Departamento al que se prestó:</label>
                <input type="text" id="dependencia2" name="dependencia2" placeholder="Registre la dependencia/departamento en donde se prestó" value="<?php echo $dependencia2; ?>">

                <label for="personalSistemasId">Personal de sistemas:</label>
                <select name="personalSistemasId">
                    <option value="">-- Seleccione quien entregó --</option>
                    <?php while($persona = mysqli_fetch_assoc($resultado1)): ?>
                        <option <?php echo $personalSistemasId === $persona['idPersona'] ? 'selected' : ''; ?> value="<?php echo $persona['idPersona']; ?>"> <?php echo $persona['nombrePersona'] . " " . $persona['apellidos']; ?> </option>
                    <?php endwhile; ?>    
                </select>

                <label for="descripcion">Descripcion (Opcional):</label>
                <textarea id="descripcion" name="descripcion"><?php echo $descripcion; ?></textarea>

            </fieldset>

            <input type="submit" value="Actualizar" class="boton boton-verde">
        </form>

    </main>

<?php 
    incluirTemplate('footer-registros'); 
?>