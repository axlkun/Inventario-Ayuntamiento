<?php 

    require 'includes/funciones.php';
    
    incluirTemplate('header');

    require 'includes/config/database.php';
    $db = conectarDB();
     

    $errores = [];

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        // echo '<pre>';
        // var_dump($_POST);
        // echo '</pre>';

        $email = mysqli_real_escape_string($db,filter_var($_POST['email'],FILTER_VALIDATE_EMAIL));
        // $usuario = $_POST['usuario'];
        $contraseña = mysqli_real_escape_string($db, $_POST['contraseña']);

        if(!$email){
            $errores[] = "Correo no válido";
        }

        if(!$contraseña){
            $errores[] = "Contraseña no válida";
        }

        // echo '<pre>';
        // var_dump($errores);
        // echo '</pre>';

        if(empty($errores)){
            //Revisar si el usuario existe
            $query = "SELECT * FROM usuarios WHERE email = '${email}'";
            // echo $query;
            $resultado = mysqli_query($db,$query);
            // var_dump($resultado);

            if($resultado -> num_rows){
                //Revisar si el password es correcto
                $usuario = mysqli_fetch_assoc($resultado);

                //esta funcion retorna true o false al comparar la contraseña original y la contraseña hasheada en la BDD
                $auth = password_verify($contraseña,$usuario['password']);

                // var_dump($auth);

                if($auth){
                    //el usuario esta autenticado
                    session_start();

                    //llenar el arreglo de la sesion
                    $_SESSION['usuario'] = $usuario['email'];
                    $_SESSION['rol'] = $usuario['rol'];
                    $_SESSION['login'] = true;
                    $rol = rolNormal();

                    if($rol){
                        header('Location: /inventario_ayuntamiento/registros-inventario-user.php');
                    }else{
                        header('Location: /inventario_ayuntamiento/registros-inventario.php');
                    }
                    

                }else{
                    $errores[] = "Contraseña incorrecta";
                }

            }else{
                $errores[] = "El usuario no existe";
            }
        }
    }

?>

    <main class="contenedor formulario-centrado">
        <h1 class="titulo">Iniciar Sesión</h1>

        <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error ?>
            </div>
        <?php endforeach; ?>    

        <!--Para enviar informacion sensible su utiliza POST, para obtener datos de un servidor se utiliza GET  -->
        <form class="formulario" method="POST" enctype="multipart/form-data" novalidate>
            <fieldset>
                <legend>Credenciales</legend>

                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" placeholder="Ingresa tu correo">

                <label for="contraseña">Contraseña:</label>
                <input type="password" id="contraseña" name="contraseña" placeholder="Ingresa tu contraseña">
            </fieldset>

            <div class="centrar-boton">
                <input type="submit" value="Ingresar" class="boton boton-rojo">
                <!-- <a href="/inventario_ayuntamiento/registros-inventario.php" class="boton-rojo">Ingresar</a> -->
            </div>

            <div class="espacio">

            </div>
            
        </form>

    </main>

<?php 
    incluirTemplate('footer'); 
?>