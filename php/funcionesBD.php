<?php
    /************************************************************************************************************** */
    // Funciones de acceso a Base de Datos

    phpinfo();
    ini_set('display_errors', 1);

    function ObtenerDatosUsuario(){
        $db = mysqli_connect("https://void.ugr.es/mywebsql/","raultlopez2223","AdiGd24D","raultlopez2223");
        if ($db) {
            echo "<p>Conexión con éxito</p>";
        } else {
            echo "<p>Error de conexión</p>";
            echo "<p>Código: ".mysqli_connect_errno()."</p>";
            echo "<p>Mensaje: ".mysqli_connect_error()."</p>";
            die("Adiós");
        }
        // Establecer el conjunto de caracteres del cliente
        mysqli_set_charset($db,"utf8");
    }

    ObtenerDatosUsuario();
?>