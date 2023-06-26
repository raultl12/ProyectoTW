<?php
    require_once 'funciones.php';

    session_start();

    HTMLInicio();
    MostrarHeader(getSession("tipoCliente"));

    if(isset($_POST['numeroPost']) and $_POST['numeroPost'] == "uno"){ // Primera confiramacion
        $post = new ArrayObject($_POST);
        $files = new ArrayObject($_FILES);

        MostrarContenidoEdicionUsuario("tipoCliente", "readonly", true, "dos", $post, $files);
        print($_POST['numeroPost']);
    }

    else if(isset($_POST['numeroPost']) and $_POST['numeroPost'] == "dos"){ // Éxito
        $post = new ArrayObject($_POST);
        $files = new ArrayObject($_FILES);
        MostrarCambiosExito(true, $post, $files);
    }

    else{ // Primera vez
        MostrarContenidoEdicionUsuario("tipoCliente", "", true, "uno", null, null);
    }

    MostrarFooter();
    HTMLFin();
?>