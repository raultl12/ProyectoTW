<?php
    require_once 'funciones.php';

    session_start();

    HTMLInicio();
    MostrarHeader(getSession("tipoCliente"));

    // Restringir acceso
    if (getSession('logged') == false){
        MostrarAccesoDenegado();
    }
    else{
        // Mostrar contenido
        MostrarContenidoMisIncidencias($_POST);
    }
    
    MostrarFooter();
    HTMLFin();
?>