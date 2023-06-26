<?php
    require_once 'funciones.php';

    // Iniciar un usuario anonimo si no hay registro
    session_start();
    if(getSession("tipoCliente") == null){
        setSession("tipoCliente", "anonimo");
    }

    HTMLInicio();
    MostrarHeader(getSession("tipoCliente"));

    // Mostrar contenido
    MostrarContenidoIncidencias($_POST);
    
    MostrarFooter();
    HTMLFin();
?>