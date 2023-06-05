<?php
    /************************************************************************************************************** */
    // Funciones de acceso a Base de Datos

    ini_set('display_errors', 1);
    $db = null;

    //Conexion a la BD
    function ConectarBD(){
        global $db;
        $db = mysqli_connect("localhost","tw","TW12345tw_","tw");
        //$db = mysqli_connect("localhost","tw","tw123","proyectoTW");
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
        $resultado = null;
        global $db;
        $consulta = "SELECT * FROM Usuario WHERE email=?";
        $prep = mysqli_prepare($db, $consulta);
        mysqli_stmt_bind_param($prep,'i', $email);

        if(mysqli_stmt_execute($prep)){
            $res = mysqli_stmt_get_result($prep);
            
            if($res){
                $resultado = mysqli_fetch_assoc($res);
            }
            else{
                echo "<p>Error en la consulta</p>";
                echo "<p>Código: ".mysqli_errno($db)."</p>";
                echo "<p>Mensaje: ".mysqli_error($db)."</p>";
            }
        }
        mysqli_free_result($res);
        mysqli_stmt_close($prep);

        return $resultado ? $resultado : null;
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

    //Obtener todos los ids de todas las incidencias
    function ObtenerTodasIncidencias(){
        $resultado = null;
        $cont = 0;
        global $db;
        $consulta = "SELECT id FROM Incidencia";
        $prep = mysqli_prepare($db, $consulta);

        if(mysqli_stmt_execute($prep)){
            $res = mysqli_stmt_get_result($prep);

            if($res){
                while ($row = mysqli_fetch_assoc($res)) {
                    foreach ($row as $r){
                        $resultado[] = $r;
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
        return $resultado ? $resultado : null;
    }

    //Obtener todos los datos de una incidencia
    function ObtenerDatosIncidencia($id){
        $resultado = null;
        global $db;
        $consulta = "SELECT * FROM Incidencia WHERE id=?";
        $prep = mysqli_prepare($db, $consulta);
        mysqli_stmt_bind_param($prep,'i', $id);

        if(mysqli_stmt_execute($prep)){
            $res = mysqli_stmt_get_result($prep);
            
            if($res){
                $resultado = mysqli_fetch_assoc($res);
                /*while ($row = mysqli_fetch_assoc($res)) {
                    foreach ($row as $r){
                        echo $r;
                        echo "<br>";
                    }
                }*/
            }
            else{
                echo "<p>Error en la consulta</p>";
                echo "<p>Código: ".mysqli_errno($db)."</p>";
                echo "<p>Mensaje: ".mysqli_error($db)."</p>";
            }
        }
        mysqli_free_result($res);
        mysqli_stmt_close($prep);

        return $resultado ? $resultado : null;
    }

    //Insertar una incidencia
    function InsertarIncidencia($lugar, $titulo, $palClave, $estado, $descripcion, $valPos, $valNeg){
        global $db;
        $consulta = "INSERT INTO Incidencia(lugar, titulo, palClave, estado, descripcion, valPos, valNeg) VALUES 
            ('$lugar', '$titulo', '$palClave', '$estado', '$descripcion', '$valPos', '$valNeg')";

        if(mysqli_query($db, $consulta)){

            echo "insertado correctamente";
        }
        else{
            echo "<p>Error en la insercion</p>";
            echo "<p>Código: ".mysqli_errno($db)."</p>";
            echo "<p>Mensaje: ".mysqli_error($db)."</p>";
        }
    }

    function votoPositivo($id){
        // aumentar un voto positivo en una incidencia
    }

    function votoNegativo($id){
        // aumentar un voto negativo en una incidencia
    }

    function eliminarIncidencia($id){
        // eliminar incidencia entera
    }

    function nuevoComentario($id){
        // añadir un comentario a una incidencia
    }

    function InsertarImagenesIncidencia($id){
        // añadir un array de imagenes a una INIcidencia
    }

    function ObtenerDatosLog(){
        return null;
    }

    ConectarBD();
    ObtenerDatosUsuario("admin@correo.ugr.es");
    ObtenerDatosUsuario("raultlopez@correo.ugr.es");
    //InsertarIncidencia("mi calle", "farola rota", "farola", "irresoluble", "Se han roto las farolas bobis", 0, 0);
    //ObtenerDatosIncidencia(1);
    //ObtenerTodasIncidencias();

    
?>