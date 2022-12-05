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
    //base de datos
    require 'includes/config/database.php';
    $db = conectarDB();

    //Arreglo con mensaje de errores
    $errores = [];

    $nombrewifi = '';
    $contraseña = '';
    $pertenece = '';
    $descripcion = '';

    //Ejecuta el codigo despues de que el usuario envia el formulario (da clic en el boton)
    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        // echo "<pre>";
        // var_dump($_POST);
        // echo "</pre>";
        // exit; 

        $nombrewifi = mysqli_real_escape_string($db,$_POST['nombrewifi']);
        $contraseña = mysqli_real_escape_string($db,$_POST['contraseña']);
        $pertenece = mysqli_real_escape_string($db,$_POST['pertenece']);
        $descripcion = mysqli_real_escape_string($db,$_POST['descripcion']);
    
        if(!$nombrewifi){
            $errores[] = "Debes añadir el SSID (Nombre de red)";
        }

        if(!$contraseña){
            $errores[] = "Debes añadir la contraseña";
        }

        if(!$pertenece){
            $errores[] = "Debes añadir la dependencia/departamento donde se encuentra";
        }

        //revisar que el arreglo de errores esté vacío
        if(empty($errores)){

            //Insertar en la base de datos
            $query3 = "INSERT INTO wifi (nombrewifi, contraseña, pertenece, descripcion) VALUES ('$nombrewifi', '$contraseña', '$pertenece', '$descripcion')";

            // echo $query3; //para ver si si jala correctamente los valores a las variables para posteriormente hacer la insercion
            // exit;

            $resultado3 = mysqli_query($db,$query3); //se le pasa la conexion a la BDD y el query a ejecutar

            if($resultado3){
                //reedireccionar para indicar que si jalo la consulta
                //echo "Insertado correctamente";
                //header('Location: /inventario_ayuntamiento/registros-inventario.php?mensaje=Registrado Correctamente&resultado=1'); //el header reedirecciona al usuario a la pagina anterior, esta funcion no sirve si existe algo de html previo
                echo '<script>
                swal("Buen trabajo!", "Registro creado!", "success")
                .then(function() {
             window.location = "/inventario_ayuntamiento/registros-wifi.php";
                });
                    </script>';
                
            }
        }
        
    }

     //al momento de entrar en ejecucion la variable se vuelve true, o sea cada que se abra el index.php
    //include "includes/templates/header.php"
    
?>
    
    <main class="contenedor seccion contenido-centrado">
        <h1 class="tituloMargin">Crear registro</h1>

        <a href="/inventario_ayuntamiento/registros-wifi.php" class="boton boton-rojo marginArriba">Volver</a> 

        <!-- Mensaje de error validacion. for each se ejecuta al menos una vez por cada elemento en el arreglo, si no hay nada, no se ejecuta -->
        <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>    

        <!--Para enviar informacion sensible su utiliza POST, para obtener datos de un servidor se utiliza GET  -->
        <form class="formulario" method="POST" action="/inventario_ayuntamiento/crear-wifi.php" enctype="multipart/form-data">
            <fieldset>
                <legend>Informacion del registro</legend>

                <label for="nombrewifi">Nombre de red:</label>
                <input type="text" id="nombrewifi" name="nombrewifi" placeholder="Registre el SSID (Nombre de red)" value="<?php echo $nombrewifi; ?>">

                <label for="contraseña">Contraseña:</label>
                <input type="text" id="contraseña" name="contraseña" placeholder="Registre la contraseña de la red" value="<?php echo $contraseña; ?>">

                <label for="pertenece">Departamento en el que se encuentra:</label>
                <input type="text" id="pertenece" name="pertenece" placeholder="Registre el departamento/dependencia en donde se encuentra" value="<?php echo $pertenece; ?>">

                <label for="descripcion">Descripcion (Opcional):</label>
                <textarea id="descripcion" name="descripcion"><?php echo $descripcion; ?></textarea>

            </fieldset>

            <input type="submit" value="Crear registro" class="boton boton-verde">
        </form>

    </main>

<?php 
    incluirTemplate('footer-registros'); 
?>