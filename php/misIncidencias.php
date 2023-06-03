<?php
    require_once 'funciones.php';

    session_start();
    setSession("tipoCliente", "administrador");

    HTMLInicio();
    MostrarHeader(getSession("tipoCliente"));
    MostrarContenidoMisIncidencias();
    MostrarFooter();
    HTMLFin();
?>