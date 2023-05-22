<?php
    require_once 'funciones.php';

    session_start();
    ini_set('display_errors', 1);
    print_r($_POST);

    HTMLInicio();
    MostrarHeader(getSession("tipoCliente"));

    // La contraseña si no esta la primera la segunda tampoco
    // hacer algunos requiered
    // si no se rellena alguno se queda como antes
    // las contraseñas deben coincidir

    if (isset($_COOKIE['correcto']) and $_COOKIE == true){
        setcookie('correcto', false);
        MostrarCambiosExito();
    }

    else if (isset($_POST['change-saved'])){
        MostrarContenidoEdicionUsuario("tipoCliente", "disabled");
        setcookie('correcto', true);
    }

    else{
        MostrarContenidoEdicionUsuario("tipoCliente", "");
    }

    MostrarFooter();
    HTMLFin();
?>