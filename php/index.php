<?php
    require_once 'funciones.php';

    session_start();
    setSession("tipoCliente", "anonimo");

    HTMLInicio();
    MostrarHeader(getSession("tipoCliente"));
    MostrarContenidoIncidencias();
    MostrarFooter();
    HTMLFin();
?>