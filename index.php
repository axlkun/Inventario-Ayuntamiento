<?php 
    require 'includes/funciones.php';
     //al momento de entrar en ejecucion la variable se vuelve true, o sea cada que se abra el index.php
    //include "includes/templates/header.php"
    incluirTemplate('header',$inicio = true);
?>

    <main class="contenedor seccion">
        <!-- <h1>Control de inventario del departamento de sistemas del H. Ayuntamiento de Álamo Temapache</h1> -->
    </main>

    <section class="imagen-contacto">
        <div class="oscuro">
            <h2>Inventario</h2>
            <p>Control de inventario del departamento de sistemas del H. Ayuntamiento de Álamo Temapache</p>
                <a href="/inventario_ayuntamiento/login.php" class="boton-rojo">Iniciar sesión</a>
        </div>
        
    </section>

    <?php 
        incluirTemplate('footer'); 
    ?>