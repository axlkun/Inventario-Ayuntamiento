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
    <h1 class="titulo">Recordatorios</h1>

    <div class="contenedorTitulo">
        
            <form action="" method="$_POST" class="contenedorBuscar">
                <input type="text" id="camporecordatorio" name="camporecordatorio" placeholder="Ingresa tu búsqueda" class="buscar">
            </form>
            
            <div style="visibility: hidden;">
                <a href="/inventario_ayuntamiento/crear-recordatorio.php" class="boton boton-verde">Nuevo registro</a>
            </div>
        </div>
        
        <table class="propiedadesNodo2" style="margin: 0 auto;">
            <thead>
                <tr>
                    <th>Asunto</th>
                    <th>Descripcion</th>
                </tr> 
            </thead>

            <tbody id="contentrecordatorio"> <!-- Mostrar los resultados --> 
            
            </tbody>
        </table>

</main>

    <script>
        /* Llamando a la función getData() */
        getData()
        /* Escuchar un evento keyup en el campo de entrada y luego llamar a la función getData. */
        document.getElementById("camporecordatorio").addEventListener("keyup", getData)
        /* Peticion AJAX */
        function getData() {
            let input = document.getElementById("camporecordatorio").value
            let content = document.getElementById("contentrecordatorio")
            let url = "load-recordatorios-user.php"
            let formaData = new FormData()
            formaData.append('camporecordatorio', input)
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