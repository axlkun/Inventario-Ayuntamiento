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
        header('Location: /inventario_ayuntamiento/registros-wifi.php');
    }

    //base de datos
    require 'includes/config/database.php';
    $db = conectarDB();

    $consulta = "SELECT * FROM wifi where idwifi = ${id}";

    $resultado = mysqli_query($db,$consulta);
    $registro = mysqli_fetch_assoc($resultado);

    //Arreglo con mensaje de errores
    $errores = [];

    $nombrewifi = $registro['nombrewifi'];
    $contraseña = $registro['contraseña'];
    $pertenece = $registro['pertenece'];
    $descripcion = $registro['descripcion'];

?>

    <main class="contenedor seccion contenido-centrado">
        <h1 class="tituloMargin">Ver registro</h1>

        <a href="<?php if($rol){echo "/inventario_ayuntamiento/registros-wifi-user.php";}else{echo "/inventario_ayuntamiento/registros-wifi.php";} ?>" class="boton boton-rojo marginArriba">Volver</a> 
        
        <!--Para enviar informacion sensible su utiliza POST, para obtener datos de un servidor se utiliza GET  -->
        <form class="formulario" method="POST" enctype="multipart/form-data">
            <fieldset>
                <legend>Informacion del registro</legend>

                <label for="nombrewifi">Nombre de red:</label>
                <input type="text" id="nombrewifi" name="nombrewifi" placeholder="Ingrese el nombre de la red" value="<?php echo $nombrewifi; ?>" disabled>

                <label for="contraseña">Contraseña:</label>
                <input type="text" id="contraseña" name="contraseña" placeholder="Ingrese la contraseña" value="<?php echo $contraseña; ?>" disabled>

                <label for="pertenece">Departamento en el que se encuentra:</label>
                <input type="text" id="pertenece" name="pertenece" placeholder="Ingrese el departamento/dependencia donde se encuentra" value="<?php echo $pertenece; ?>" disabled>

                <label for="descripcion">Descripcion (Opcional):</label>
                <textarea id="descripcion" name="descripcion" disabled><?php echo $descripcion; ?></textarea>

            </fieldset>

            <!-- <input type="submit" value="Actualizar" class="boton boton-verde"> -->
        </form>

    </main>

<?php 
    incluirTemplate('footer-registros'); 
?>