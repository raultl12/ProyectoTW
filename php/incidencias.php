<?php
    require_once 'funciones.php';

    session_start();

    HTMLInicio();
    MostrarHeader(getSession("tipoCliente")); //Cambiar por el valor de la cookie de sesion
    //Poner aqui el codigo de generacion de incidencia
    MostrarFooter();
    HTMLFin();
?>