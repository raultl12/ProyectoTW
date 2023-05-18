<?php
    require_once 'funciones.php';

    HTMLInicio();
    MostrarHeader("anonimo"); //Cambiar por el valor de la cookie de sesion
    MostrarMain();
    MostrarFooter();
    HTMLFin();
?>