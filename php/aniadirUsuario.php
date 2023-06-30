<?php
    require_once 'funciones.php';

    session_start();

    HTMLInicio();
    MostrarHeader(getSession("tipoCliente"));

    // Mostrar contenido
    if(isset($_POST['numeroPost']) and $_POST['numeroPost'] == "uno"){ // Confiramacion
        $post = new ArrayObject($_POST);
        $files = new ArrayObject($_FILES);

        MostrarContenidoEdicionUsuario("tipoCliente", "readonly", true, "dos", $post, $files, null);
    }

    else if(isset($_POST['numeroPost']) and $_POST['numeroPost'] == "dos"){ // Éxito
        $post = new ArrayObject($_POST);
        $files = new ArrayObject($_FILES);
        MostrarCambiosExito(true, $post, $files);
    }

    else{ // Primera vez
        MostrarContenidoEdicionUsuario("tipoCliente", "", true, "uno", null, null, null);
    }

    MostrarFooter();
    HTMLFin();
?>