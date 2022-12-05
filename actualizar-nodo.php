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
        header('Location: /inventario_ayuntamiento/registros-wifi.php');
    }

    //base de datos
    require 'includes/config/database.php';
    $db = conectarDB();

    $consulta = "SELECT * FROM nodos where idnodos = ${id}";

    // echo $consulta;
    $resultado = mysqli_query($db,$consulta);
    $registro = mysqli_fetch_assoc($resultado);

    //Arreglo con mensaje de errores
    $errores = [];

    $dependencia = $registro['dependencia'];
    $red = $registro['red'];
    $informacionNodo = $registro['informacionNodo'];

    //Ejecuta el codigo despues de que el usuario envia el formulario (da clic en el boton)
    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        $dependencia = mysqli_real_escape_string($db,$_POST['dependencia']);
        $red = mysqli_real_escape_string($db,$_POST['red']);
        $informacionNodo = mysqli_real_escape_string($db,$_POST['informacionNodo']);
    
        if(!$dependencia){
            $errores[] = "Debes añadir el departento/dependencia";
        }

        if(!$red){
            $errores[] = "Debes añadir la red";
        }

        if(!$informacionNodo){
            $errores[] = "Debes añadir la información del nodo";
        }

        //revisar que el arreglo de errores esté vacío
        if(empty($errores)){

            //Insertar en la base de datos

            $query3 = "UPDATE nodos SET dependencia = '${dependencia}', red = '${red}', informacionNodo = '${informacionNodo}' WHERE idnodos = ${id} ";


            // echo $query3; //para ver si si jala correctamente los valores a las variables para posteriormente hacer la insercion
            // exit;

            $resultado3 = mysqli_query($db,$query3); //se le pasa la conexion a la BDD y el query a ejecutar

            if($resultado3){
                echo '<script>
                swal("Buen trabajo!", "Registro actualizado!", "success")
                .then(function() {
             window.location = "/inventario_ayuntamiento/registros-nodos.php";
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

        <a href="/inventario_ayuntamiento/registros-nodos.php" class="boton boton-rojo marginArriba">Volver</a> 

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

                    <label for="dependencia">Dependencia:</label>
                    <input type="text" id="dependencia" name="dependencia" placeholder="Registre el departamento/dependencia" value="<?php echo $dependencia; ?>">

                    <label for="red">Red:</label>
                    <input type="text" id="red" name="red" placeholder="Registre la red" value="<?php echo $red; ?>">

                    <label for="informacionNodo">Informacion del nodo:</label>
                    <textarea id="informacionNodo" name="informacionNodo"><?php echo $informacionNodo; ?></textarea>

                </fieldset>

            <input type="submit" value="Actualizar" class="boton boton-verde">
        </form>

    </main>

<?php 
    incluirTemplate('footer-registros'); 
?>