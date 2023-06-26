<?php
    require_once 'funciones.php';

    session_start();

    HTMLInicio();
    MostrarHeader(getSession("tipoCliente"));

    // Mostrar contenido
    MostrarContenidoMisIncidencias();
    
    MostrarFooter();
    HTMLFin();
?>