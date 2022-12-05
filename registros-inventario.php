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
    
   require 'includes/config/database.php';
     
    $db = conectarDB();
 
    $consulta = "SELECT *
    FROM registroequipo
    ORDER BY fechaEntrega DESC";

    $resultadoConsulta = mysqli_query($db,$consulta);

    // $resultado = $_GET['resultado'] ?? null;
    

?>
    <main class="contenedor seccion">
 
        <h1 class="titulo">Inventario</h1>
            
        <div class="contenedorTitulo">
        
            <form action="" method="$_POST" class="contenedorBuscar">
                <input type="text" id="campo" name="campo" placeholder="Ingresa tu búsqueda" class="buscar">
            </form>
            
            <div class="acciones">
            <div >
                <form action="">
                    <a class="boton boton-amarillo" onclick="sendData();">Generar reporte</a>
                </form>
            </div>

            <div >
                <a href="/inventario_ayuntamiento/crear-inventario.php" class="boton boton-verde">Nuevo registro</a>
            </div>
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

    <?php 
    if(isset($_GET['m'])){ ?>
    <div class="flash-data" data-flashdata="<?php echo $_GET['m'];?>"></div>
    <?php } ?>
    
    <script>
        $(document).on('click','.del-btn',function(e){
            e.preventDefault();
            const href = $(this).attr('href') 

                swal({
                    title: "¿Estás seguro?",
                    text: "El registro se eliminará de la base de datos!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                    })
                    .then((willDelete) => {
                    if (willDelete) {
                        document.location.href = href;
                    } 
                    });

         })

         const flashdata = $('.flash-data').data('flashdata')
         if(flashdata){
            swal("Registro eliminado!", {
                        icon: "success",
                        }).then(function() {
             window.location = "/inventario_ayuntamiento/registros-inventario.php";
                });
         }
    </script>
 
    <script>
        /* Llamando a la función getData() */
        getData()
        /* Escuchar un evento keyup en el campo de entrada y luego llamar a la función getData. */
        
        document.getElementById("campo").addEventListener("keyup", getData)
        /* Peticion AJAX */
        function getData() {
            let input = document.getElementById("campo").value
            let content = document.getElementById("content")
            let url = "load-inventario.php"
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

    <script>
        function sendData(){
            let input = document.getElementById("campo").value
            window.open('/inventario_ayuntamiento/reporte.php'+ "?input=" + input, '_blank');
        }
    </script>

<?php 
    mysqli_close($db);
    incluirTemplate('footer-registros'); 
?>