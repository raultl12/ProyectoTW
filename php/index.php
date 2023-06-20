<?php
    require_once 'funciones.php';

    session_start();
    if(getSession("tipoCliente") == null){
        setSession("tipoCliente", "anonimo");
    }

    //Borra todas las variables de sesion
    //session_unset();

    HTMLInicio();
    MostrarHeader(getSession("tipoCliente"));
    MostrarContenidoIncidencias();
    MostrarFooter();
    HTMLFin();
?>