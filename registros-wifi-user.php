<?php 

    require 'includes/funciones.php';
    incluirTemplate('header-registros-user');

    $auth = estaAutenticado();
    

    if(!$auth){
        header('Location: /inventario_ayuntamiento/index.php');
    }

    $rol = rolNormal();
    if(!$rol === true){
        header('Location: /inventario_ayuntamiento/index.php');
    }

   require 'includes/config/database.php';
     
    $db = conectarDB();
 
    $consulta = "SELECT * FROM wifi";

    $resultadoConsulta = mysqli_query($db,$consulta);

    $resultado = $_GET['resultado'] ?? null;

?>
 
    <main class="contenedor seccion">


        <h1 class="titulo">Wifi</h1>

        <div class="contenedorTitulo">
        
            <form action="" method="$_POST" class="contenedorBuscar">
                <input type="text" id="campowifi" name="campowifi" placeholder="Ingresa tu búsqueda" class="buscar">
            </form>
            
            <div style="visibility: hidden;">
                <a href="/inventario_ayuntamiento/crear-wifi.php" class="boton boton-verde">Nuevo registro</a>
            </div>
        </div>
        
        <table class="propiedades" style="margin: 0 auto;">
            <thead>
                <tr>
                    <th>Nombre de red</th>
                    <th>Contraseña</th>
                    <th>Ubicación</th>
                    <th>Acciones</th>
                </tr> 
            </thead>

            <tbody id="contentwifi"> <!-- Mostrar los resultados --> 
            
            </tbody>
        </table>
    </main>

    <script>
        /* Llamando a la función getData() */
        getData()
        /* Escuchar un evento keyup en el campo de entrada y luego llamar a la función getData. */
        document.getElementById("campowifi").addEventListener("keyup", getData)
        /* Peticion AJAX */
        function getData() {
            let input = document.getElementById("campowifi").value
            let content = document.getElementById("contentwifi")
            let url = "load-wifi-user.php"
            let formaData = new FormData()
            formaData.append('campowifi', input)
            fetch(url, {
                    method: "POST",
                    body: formaData
                }).then(response => response.json())
                .then(data => {
                    content.innerHTML = data
                }).catch(err => console.log(err))
        }
    </script>

<?php 
    mysqli_close($db);
    incluirTemplate('footer-registros'); 
?>