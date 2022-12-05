
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="Axel Cruz">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario</title>
    <link rel="icon" type="image/png" href="build/img/iconopestana.png" />
    <script
  src="https://code.jquery.com/jquery-3.6.1.min.js"
  integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ="
  crossorigin="anonymous"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="/inventario_ayuntamiento/build/css/app.css"> <!-- la primera / indica la raiz del proyecto, entonces busca ahi una carpeta llamada build -->
</head>
<body>
    <header class="header"> <!-- con un if (operador ternario) evalua si la variable inicio es true para agregar la clase inicio al header y sino no agregarla ----- isset es una funcion que permite revisar si una variable esta definida-->
        <div class="contenedor contenido-header">
            <div class="barra">

                <div class="contenedorLogo">
                    <a href="/inventario_ayuntamiento/index.php">
                        <img src="/inventario_ayuntamiento/src/img/logo.png" alt="Logotipo Ayuntamiento">
                    </a>
                </div>
                
                <div class="mobile-menu oscurecericono">
                    <img src="/inventario_ayuntamiento/build/img/barras.svg" alt="icono menu responsive">
                </div>

                <div class="derecha">
                    <!-- <div class="oscurecericono">
                        <img class="dark-mode-boton" src="/inventario_ayuntamiento/build/img/dark-mode.svg" alt="boton dark mode">
                    </div> -->
                    
                    <nav class="navegacion">
                        <a href="https://alamotemapache.gob.mx/" target="_blank">Pagina oficial</a>
                    </nav>
                </div>

            </div> <!--barra-->

            <!--titulo de la pagina que solo aparece en la pagina inicio-->
            <!-- <?//php if($inicio): ?> -->
                <!-- <h1>Inventario</h1> -->
            <!-- <?//php endif;?> -->

        </div>
    </header>