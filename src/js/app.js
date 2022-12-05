document.addEventListener('DOMContentLoaded', function(){
    eventListeners();
});

function darkMode(){

    const prefiereDarkMode = window.matchMedia('(prefers-color-scheme: dark)'); //sirve para leer las preferencias de la computadora del usuario tema dark o light
    console.log(prefiereDarkMode.matches);

    if(prefiereDarkMode.matches){
        document.body.classList.add('dark-mode');
    }else{
        document.body.classList.remove('dark-mode');
    }

    prefiereDarkMode.addEventListener('change', function(){
        if(prefiereDarkMode.matches){
            document.body.classList.add('dark-mode');
        }else{
            document.body.classList.remove('dark-mode');
        }
    });

    const botonDarkMode = document.querySelector('.dark-mode-boton');

    botonDarkMode.addEventListener('click', function(){
        document.body.classList.toggle('dark-mode');
    });
}

function eventListeners(){
    const mobileMenu = document.querySelector('.mobile-menu');

    mobileMenu.addEventListener('click',navegacionResponsive);
}

function navegacionResponsive(){
    //console.log('desde navegacionResponsive');
    const navegacion = document.querySelector('.navegacion');

    if(navegacion.classList.contains('mostrar')){
        navegacion.classList.remove('mostrar');
    }else{
        navegacion.classList.add('mostrar');
    }

    //navegacion.classList.toggle('mostrar'); toggle hace exactamente lo mismo que el if de arriba
}


 


