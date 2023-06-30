<?php
    require_once 'funciones.php';

    session_start();

    HTMLInicio();
    MostrarHeader(getSession("tipoCliente"));

    print_r($_POST);

    // Restringir acceso
    if(getSession("tipoCliente") != "administrador"){
        MostrarAccesoDenegado();
    }
    else{
        // Mostrar contenido
        MostrarContenidoGestionUsuarios($_POST);
    }

    MostrarFooter();
    HTMLFin();
?>