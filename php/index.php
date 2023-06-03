<?php
    require_once 'funciones.php';

    session_start();
    setSession("tipoCliente", "administrador");

    HTMLInicio();
    MostrarHeader(getSession("tipoCliente"));
    MostrarContenidoIncidencias();
    MostrarFooter();
    HTMLFin();
?>