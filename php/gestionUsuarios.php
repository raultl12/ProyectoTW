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
        if (!empty($_GET)) $GET = $_GET;
        else $GET = NULL;

        // Mostrar contenido
        MostrarContenidoGestionUsuarios($_POST, $GET);
    }

    MostrarFooter();
    HTMLFin();
?>