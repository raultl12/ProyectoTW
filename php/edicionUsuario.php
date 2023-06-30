<?php
    require_once 'funciones.php';

    session_start();

    HTMLInicio();
    MostrarHeader(getSession("tipoCliente"));

    if(isset($_POST['numeroPost']) and $_POST['numeroPost'] == "uno"){ // Confiramacion
        $post = new ArrayObject($_POST);
        $files = new ArrayObject($_FILES);

        MostrarContenidoEdicionUsuario("tipoCliente", "readonly", false, "dos", $post, $files, null);
    }

    else if(isset($_POST['numeroPost']) and $_POST['numeroPost'] == "dos"){ // Éxito
        $post = new ArrayObject($_POST);
        $files = new ArrayObject($_FILES);
        MostrarCambiosExito(false, $post, $files);
    }

    else{ // Primera vez
        MostrarContenidoEdicionUsuario("tipoCliente", "", false, "uno", null, null, $_GET);
    }

    MostrarFooter();
    HTMLFin();
?>