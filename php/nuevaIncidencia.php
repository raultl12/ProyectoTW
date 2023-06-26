<?php
    require_once 'funciones.php';

    session_start();

    HTMLInicio();
    MostrarHeader(getSession("tipoCliente"));
    
    // Mostrar contenido
    MostrarAniadirIncidencia(false);

    MostrarFooter();
    HTMLFin();
?>