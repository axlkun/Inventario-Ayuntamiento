<?php
    require 'includes/funciones.php';
    incluirTemplate("header-registros-user");

    $auth = estaAutenticado();

    if(!$auth){
        header('Location: /inventario_ayuntamiento/index.php');
    }

    $rol = rolNormal();
    if(!$rol === true){
        header('Location: /inventario_ayuntamiento/index.php');
    }
    
?>

<main class="contenedor seccion">
    <h1 class="titulo">Nodos</h1>

    <div class="contenedorTitulo">
        
            <form action="" method="$_POST" class="contenedorBuscar">
                <input type="text" id="camponodo" name="camponodo" placeholder="Ingresa tu búsqueda" class="buscar">
            </form>
            
            <div style="visibility: hidden;">
                <a href="/inventario_ayuntamiento/crear-nodo.php" class="boton boton-verde">Nuevo registro</a>
            </div>
        </div>
        
        <table class="propiedadesNodo2" style="margin: 0 auto;">
            <thead>
                <tr>
                    <th>Dependencia</th>
                    <th>Red</th>
                    <th>Información</th>
                </tr> 
            </thead>

            <tbody id="contentnodo"> <!-- Mostrar los resultados --> 
            
            </tbody>
        </table>

</main>


<?php if(isset($_GET['m'])){ ?>
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
             window.location = "/inventario_ayuntamiento/registros-nodos.php";
                });
         }
    </script>

    <script>
        /* Llamando a la función getData() */
        getData()
        /* Escuchar un evento keyup en el campo de entrada y luego llamar a la función getData. */
        document.getElementById("camponodo").addEventListener("keyup", getData)
        /* Peticion AJAX */
        function getData() {
            let input = document.getElementById("camponodo").value
            let content = document.getElementById("contentnodo")
            let url = "load-nodos-user.php"
            let formaData = new FormData()
            formaData.append('camponodo', input)
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
   
    incluirTemplate('footer-registros'); 
?>