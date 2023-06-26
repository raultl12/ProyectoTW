<?php
    require_once 'funciones.php';

    session_start();

    HTMLInicio();
    MostrarHeader(getSession("tipoCliente"));
    
    // Mostrar contenido
    MostrarEditarIncidencia($_POST, $_FILES);

    MostrarFooter();
    HTMLFin();
?>