<?php
    require_once 'funciones.php';

    session_start();

    HTMLInicio();
    MostrarHeader(getSession("tipoCliente"));

    if(isset($_POST['numeroPost']) and $_POST['numeroPost'] == "uno"){ // Confiramacion
        MostrarContenidoEdicionUsuario("tipoCliente", "readonly", false, "dos", $_POST, $_FILES, null);
    }

    else if(isset($_POST['numeroPost']) and $_POST['numeroPost'] == "dos"){ // Éxito
        MostrarCambiosExito(false, $_POST, $_FILES);
    }

    else{ // Primera vez
        MostrarContenidoEdicionUsuario("tipoCliente", "", false, "uno", null, null, $_GET);
    }

    MostrarFooter();
    HTMLFin();
?>