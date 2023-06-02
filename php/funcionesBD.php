<?php
    /************************************************************************************************************** */
    // Funciones de acceso a Base de Datos

    ini_set('display_errors', 1);
    $db = null;

    //Conexion a la BD
    function ConectarBD(){
        global $db;
        $db = mysqli_connect("localhost","tw","tw123","proyectoTW");
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

    //Obtener todos los datos del usuario
    function ObtenerDatosUsuario($email){
        global $db;
        $consulta = "SELECT * FROM Usuario WHERE email=?";
        $prep = mysqli_prepare($db, $consulta);
        mysqli_stmt_bind_param($prep,'s', $email);

        if(mysqli_stmt_execute($prep)){
            $res = mysqli_stmt_get_result($prep);

            if($res){
                while ($row = mysqli_fetch_assoc($res)) {
                    foreach ($row as $r){
                        echo $r;
                        echo "<br>";
                    }
                }
            }
            else{
                echo "<p>Error en la consulta</p>";
                echo "<p>Código: ".mysqli_errno($db)."</p>";
                echo "<p>Mensaje: ".mysqli_error($db)."</p>";
            }
        }
        mysqli_stmt_close($prep);
    }

    //Insertar un usuario
    function InsertarUsuario($email, $nombre, $apellidos, $clave, $direccion, $tlf, $rol, $estado, $foto){
        global $db;
        $consulta = "INSERT INTO Usuario(email, nombre, apellidos, clave, direccion, tlf, rol, estado, foto) VALUES 
            ('$email', '$nombre', '$apellidos', '$clave', '$direccion', '$tlf', '$rol', '$estado', '$foto')";

        if(mysqli_query($db, $consulta)){

            echo "insertado correctamente";
        }
        else{
            echo "<p>Error en la insercion</p>";
            echo "<p>Código: ".mysqli_errno($db)."</p>";
            echo "<p>Mensaje: ".mysqli_error($db)."</p>";
        }
    }

    //Obtener todos los datos de una incidencia
    function ObtenerDatosIncidencia($id){
        global $db;
        $consulta = "SELECT * FROM Incidencia WHERE id=?";
        $prep = mysqli_prepare($db, $consulta);
        mysqli_stmt_bind_param($prep,'i', $id);

        if(mysqli_stmt_execute($prep)){
            $res = mysqli_stmt_get_result($prep);

            if($res){
                while ($row = mysqli_fetch_assoc($res)) {
                    foreach ($row as $r){
                        echo $r;
                        echo "<br>";
                    }
                }
            }
            else{
                echo "<p>Error en la consulta</p>";
                echo "<p>Código: ".mysqli_errno($db)."</p>";
                echo "<p>Mensaje: ".mysqli_error($db)."</p>";
            }
        }
        mysqli_stmt_close($prep);
    }

    //Insertar una incidencia
    function InsertarIncidencia($luagr, $titulo, $palClave, $estado, $descripcion, $valPos, $valNeg){
        global $db;
        $consulta = "INSERT INTO Incidencia(lugar, titulo, palClave, estado, descripcion, valPos, valNeg) VALUES 
            ('$luagr', '$titulo', '$palClave', '$estado', '$descripcion', '$valPos', '$valNeg')";

        if(mysqli_query($db, $consulta)){

            echo "insertado correctamente";
        }
        else{
            echo "<p>Error en la insercion</p>";
            echo "<p>Código: ".mysqli_errno($db)."</p>";
            echo "<p>Mensaje: ".mysqli_error($db)."</p>";
        }
    }

    /*ConectarBD();
    ObtenerDatosUsuario("admin@correo.ugr.es");
    ObtenerDatosUsuario("raultlopez@correo.ugr.es");
    ObtenerDatosIncidencia(1);
    mysqli_close($db);*/
    if(mail("mario25@correo.ugr.es", "bienbenido a la pagina", "verifica tu correo lorem lorem lorem")){
        echo "enviado";
    }
?>