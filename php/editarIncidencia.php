<?php
    require_once 'funciones.php';

    session_start();

    HTMLInicio();
    MostrarHeader(getSession("tipoCliente"));

    // Restringir accesp
    if(getSession("logged") == false){
        MostrarAccesoDenegado();
    }
    else{
        // Obtener origen
        if (isset($_GET['src'])) $id = $_GET['src'];
        else $id = null;

        // Mostrar contenido
        MostrarEditarIncidencia($_POST, $_FILES, $id);
    }

    MostrarFooter();
    HTMLFin();
?>