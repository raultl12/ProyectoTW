<?php
    require_once 'funciones.php';

    session_start();

    HTMLInicio();
    MostrarHeader(getSession("tipoCliente"));

    // Mostrar contenido
    if(getSession("tipoCliente") != "administrador"){
        MostrarAccesoDenegado();
    }
    else{
        MostrarContenidoGestionUsuarios($_POST);
    }

    MostrarFooter();
    HTMLFin();
?>