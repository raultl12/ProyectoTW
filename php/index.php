<?php
    require_once 'funciones.php';

    session_start();
    setSession("tipoCliente", "administrador");

    HTMLInicio();
    MostrarHeader(getSession("tipoCliente")); //Cambiar por el valor de la cookie de sesion
    MostrarContenido();
    MostrarFooter();
    HTMLFin();
?>