<?php
    require_once 'funciones.php';

    session_start();

    HTMLInicio();
    MostrarHeader(getSession("tipoCliente"));

    // Restringir acceso
    if(getSession("logged") == false){
        MostrarAccesoDenegado();
    }
    else{
        // Mostrar contenido
        MostrarAniadirIncidencia(false, $_POST, "");
    }

    MostrarFooter();
    HTMLFin();
?>