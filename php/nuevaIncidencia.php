<?php
    require_once 'funciones.php';

    session_start();

    HTMLInicio();
    MostrarHeader(getSession("tipoCliente"));
    
    MostrarAniadirIncidencia();

    MostrarFooter();
    HTMLFin();
?>