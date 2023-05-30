<?php
    require_once 'funciones.php';

    session_start();

    HTMLInicio();
    /*MostrarHeader(getSession("tipoCliente"));*/
    
    MostrarEditarIncidencia();

    MostrarFooter();
    HTMLFin();
?>