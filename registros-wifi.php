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
            
            <div >
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
             window.location = "/inventario_ayuntamiento/registros-wifi.php";
                });
         }
    </script>

    <script>
        /* Llamando a la función getData() */
        getData()
        /* Escuchar un evento keyup en el campo de entrada y luego llamar a la función getData. */
        document.getElementById("campowifi").addEventListener("keyup", getData)
        /* Peticion AJAX */
        function getData() {
            let input = document.getElementById("campowifi").value
            let content = document.getElementById("contentwifi")
            let url = "load-wifi.php"
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