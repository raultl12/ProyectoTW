<?php
    require_once 'funciones.php';

    session_start();

    HTMLInicio();
    MostrarHeader(getSession("tipoCliente"));

    // La contraseña si no esta la primera la segunda tampoco
    // hacer algunos requiered
    // si no se rellena alguno se queda como antes
    // las contraseñas deben coincidir

    if (isset($_COOKIE['correcto']) and $_COOKIE == true){
        setcookie('correcto', false);
        MostrarCambiosExito(true);
    }

    else if (isset($_POST['changes'])){
        MostrarContenidoEdicionUsuario("tipoCliente", "disabled", true);
        setcookie('correcto', true);
    }

    else{
        MostrarContenidoEdicionUsuario("tipoCliente", "", true);
    }

    MostrarFooter();
    HTMLFin();
?>