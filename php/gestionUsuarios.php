<?php
    require_once 'funciones.php';

    session_start();

    HTMLInicio();
    MostrarHeader(getSession("tipoCliente"));
    if(getSession("tipoCliente") != "administrador"){
        MostrarAccesoDenegado();
    }
    else{
        MostrarContenidoGestionUsuarios();
    }
    MostrarFooter();
    HTMLFin();
?>