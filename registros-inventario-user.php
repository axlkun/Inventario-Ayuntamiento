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
 
    $consulta = "SELECT *
    FROM registroequipo
    ORDER BY fechaEntrega DESC";

    $resultadoConsulta = mysqli_query($db,$consulta);

    $resultado = $_GET['resultado'] ?? null;
    

?>
    <main class="contenedor seccion">
 
        <h1 class="titulo">Registros</h1>
            
        <div class="contenedorTitulo">
        
            <form action="" method="$_POST" class="contenedorBuscar">
                <input type="text" id="campo" name="campo" placeholder="Ingresa tu búsqueda" class="buscar">
            </form>
            
            <div style="visibility: hidden;">
                <a href="/inventario_ayuntamiento/crear-inventario.php" class="boton boton-verde">Nuevo registro</a>
            </div>
        </div>
        
        <table class="propiedadestabla" style="margin: 0 auto;">
            <thead>
                <tr>
                    <th>Numero de serie</th>
                    <th>Dispositivo</th>
                    <!-- <th>Estado</th> -->
                    
                    <th>Pertenece</th>
                    <th>Se encuentra</th>
                    <th>Fecha de entrega</th>
                    <!-- <th>Recibió</th> -->
                    <!-- <th>Entregó</th> -->
                    <th>Acciones</th>
                </tr> 
            </thead>
            
            <tbody id="content"> <!-- Mostrar los resultados --> 
           
            </tbody>

        </table>
    </main>

    <script>
        /* Llamando a la función getData() */
        getData()
        /* Escuchar un evento keyup en el campo de entrada y luego llamar a la función getData. */
        
        document.getElementById("campo").addEventListener("keyup", getData)
        /* Peticion AJAX */
        function getData() {
            let input = document.getElementById("campo").value
            let content = document.getElementById("content")
            let url = "load-inventario-user.php"
            let formaData = new FormData()
            formaData.append('campo', input)
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