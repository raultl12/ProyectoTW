<?php
    /************************************************************************************************************** */
    // Funciones de acceso a la base de datos

    $db = null; // Conexión con la base de datos
    $dev = "m";

    //Conexion a la BD
    function ConectarBD(){
        global $db;
        global $dev;
        
        //$db = mysqli_connect("localhost","mario252223","DWyd1cEO","mario252223");
        
        if($dev == "r")
            $db = mysqli_connect("localhost","tw","tw123","proyectoTW");
        else
            $db = mysqli_connect("localhost","tw","TW12345tw_","tw");

        if (!$db) {
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
        $email = mysqli_real_escape_string($db, $email);
        mysqli_stmt_bind_param($prep,'s', $email);

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
    function InsertarUsuario($email, $nombre, $apellidos, $clave, $dir, $tlf, $rol, $estado, $foto){
        global $db;

        // Sanear datos
        $email = mysqli_real_escape_string($db, $email);
        $nombre = mysqli_real_escape_string($db, $nombre);
        $apellidos = mysqli_real_escape_string($db, $apellidos);
        $clave = mysqli_real_escape_string($db, $clave);
        $clave = password_hash($clave, PASSWORD_BCRYPT);
        $dir = mysqli_real_escape_string($db, $dir);
        $tlf = mysqli_real_escape_string($db, $tlf);
        $rol = mysqli_real_escape_string($db, $rol);
        $estado = mysqli_real_escape_string($db, $estado);

        $consulta = "INSERT INTO Usuario (email, nombre, apellidos, clave, direccion, tlf, rol, estado, foto) VALUES 
                     ('$email', '$nombre', '$apellidos', '$clave', '$dir', '$tlf', '$rol', '$estado', '$foto')";

        if (mysqli_query($db, $consulta)){
            GuardarLog("Nuevo usuario: \"$email\" añadido");
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
    function InsertarIncidencia($lugar, $titulo, $palClave, $estado, $desc, $valPos, $valNeg){
        global $db;

        // Sanear datos
        $lugar = mysqli_real_escape_string($db, $lugar);
        $titulo = mysqli_real_escape_string($db, $titulo);
        $palClave = mysqli_real_escape_string($db, $palClave);
        $estado = mysqli_real_escape_string($db, $estado);
        $desc = mysqli_real_escape_string($db, $desc);
        $valPos = mysqli_real_escape_string($db, $valPos);
        $valNeg = mysqli_real_escape_string($db, $valNeg);


        $consulta = "INSERT INTO Incidencia(lugar, titulo, palClave, estado, descripcion, valPos, valNeg) VALUES 
                     ('$lugar', '$titulo', '$palClave', '$estado', '$desc', '$valPos', '$valNeg')";

        if(mysqli_query($db, $consulta)){
            $id = mysqli_insert_id($db);
            $usuario = getSession('currentUser');

            $consulta = "INSERT INTO Publica(idIncidencia, email) VALUES ('$id', '$usuario')";

            mysqli_query($db, $consulta);
            GuardarLog("El usuario $usuario ha creado una incidencia");
        }
        else{
            echo "<p>Error en la insercion</p>";
            echo "<p>Código: ".mysqli_errno($db)."</p>";
            echo "<p>Mensaje: ".mysqli_error($db)."</p>";
        }        

        return mysqli_insert_id($db);
    }

    // Editar una incidencia existente
    function EditarIncidencia($id, $lugar, $titulo, $palClave, $desc){
        global $db;

        // Sanear datos
        $id = mysqli_real_escape_string($db, $id);
        $lugar = mysqli_real_escape_string($db, $lugar);
        $titulo = mysqli_real_escape_string($db, $titulo);
        $palClave = mysqli_real_escape_string($db, $palClave);
        $desc = mysqli_real_escape_string($db, $desc);

        $consulta = "UPDATE Incidencia SET titulo='$titulo', lugar='$lugar',
                     palClave='$palClave', descripcion='$desc' WHERE id='$id'";

        if (mysqli_query($db, $consulta)){
            GuardarLog("Incidencia $id editada");
        }
        else{
            echo "<p>Error en la insercion</p>";
            echo "<p>Código: ".mysqli_errno($db)."</p>";
            echo "<p>Mensaje: ".mysqli_error($db)."</p>";
        }
    }

    // Obtener autro de incidencia
    function ObtenerUsuarioPublica($idInci){
        $resultado = null;
        global $db;

        $consulta = "SELECT email, nombre, apellidos FROM Usuario WHERE email=(SELECT email FROM Publica WHERE idIncidencia=?)";
        $prep = mysqli_prepare($db, $consulta);
        mysqli_stmt_bind_param($prep,'i', $idInci);

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

    // Obtener comentarios de una incidencia
    function ObtenerTodosComentarios($idInci){
        $resultado = null;
        global $db;
        $consulta = "SELECT idComentario FROM Contiene where idIncidencia=?";

        $prep = mysqli_prepare($db, $consulta);
        mysqli_stmt_bind_param($prep,'i', $idInci);

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
            mysqli_free_result($res);
        }
        mysqli_stmt_close($prep);
        return $resultado ? $resultado : null;
    }

    // Obtener comentario
    function ObtenerComentario($id){
        $resultado = null;
        global $db;

        $consulta = "SELECT * FROM Comentario where id=?";

        $prep = mysqli_prepare($db, $consulta);
        mysqli_stmt_bind_param($prep,'i', $id);

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
            mysqli_free_result($res);
        }
        mysqli_stmt_close($prep);
        return $resultado ? $resultado : null;
    }

    // Obtener autor de un comentario
    function ObtenerUsuarioComentario($idCom){
        $resultado = null;
        global $db;
        
        $consulta = "SELECT nombre, apellidos FROM Usuario WHERE email=(SELECT email FROM Escribe WHERE idComentario=?)";
        $prep = mysqli_prepare($db, $consulta);
        mysqli_stmt_bind_param($prep,'i', $idCom);

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

    // Obtener fotos de una incidencia
    function ObtenerFotosIncidencia($inci){
        $resultado = null;
        global $db;

        $idsFotos = null;
        $consulta = "SELECT idFoto FROM Tiene WHERE idIncidencia=?";
        $prep = mysqli_prepare($db, $consulta);
        mysqli_stmt_bind_param($prep,'i', $inci);
        
        if(mysqli_stmt_execute($prep)){
            $res = mysqli_stmt_get_result($prep);
            
            if($res){
                while($idFoto = mysqli_fetch_assoc($res)){
                    $idsFotos[] = $idFoto["idFoto"];
                }
            }
            else{
                echo "<p>Error en la consulta</p>";
                echo "<p>Código: ".mysqli_errno($db)."</p>";
                echo "<p>Mensaje: ".mysqli_error($db)."</p>";
            }
            mysqli_free_result($res);
        }
        mysqli_stmt_close($prep);
        
        // Ya obtenidos los ids de las fotos de la incidencia, almacenados en idsFotos
        // Hacer la consulta para obtener las fotos

        if($idsFotos){
            foreach($idsFotos as $id){
                $res = mysqli_query($db, "SELECT foto FROM Foto WHERE id=$id");
                if($res){
                    while($foto = mysqli_fetch_assoc($res)){
                        $resultado[] = $foto["foto"];
    
                    }
                }
            }
        }

        return $resultado ? $resultado : null;
    }

    // Añadir un voto positivo a una incidencia
    function votoPositivo($id){
        global $db;
        $id = mysqli_real_escape_string($db, $id);
        $consulta = "SELECT valPos FROM Incidencia WHERE id = $id";

        if ($res = mysqli_query($db, $consulta)){
            $resultado = mysqli_fetch_assoc($res);
            $valor = (int) $resultado['valPos'];

            $valor += 1;
            $consulta = "UPDATE Incidencia SET valPos = $valor WHERE id = $id";

            if (mysqli_query($db, $consulta)){
                GuardarLog("Voto positivo añadido a incidencia $id");
            }
            else{
                echo "<p>Error en la insercion</p>";
                echo "<p>Código: ".mysqli_errno($db)."</p>";
                echo "<p>Mensaje: ".mysqli_error($db)."</p>";
            }
        }
        else{
            echo "<p>Error en la extraccion</p>";
            echo "<p>Código: ".mysqli_errno($db)."</p>";
            echo "<p>Mensaje: ".mysqli_error($db)."</p>";
        }
    }

    // Añadir un voto negativo a una incidencia
    function votoNegativo($id){
        global $db;
        $id = mysqli_real_escape_string($db, $id);
        $consulta = "SELECT valNeg FROM Incidencia WHERE id = $id";

        if ($res = mysqli_query($db, $consulta)){
            $resultado = mysqli_fetch_assoc($res);
            $valor = (int) $resultado['valNeg'];

            $valor += 1;
            $consulta = "UPDATE Incidencia SET valNeg = $valor WHERE id = $id";

            if (mysqli_query($db, $consulta)){
                GuardarLog("Voto negativo añadido a incidencia $id");
            }
            else{
                echo "<p>Error en la insercion</p>";
                echo "<p>Código: ".mysqli_errno($db)."</p>";
                echo "<p>Mensaje: ".mysqli_error($db)."</p>";
            }
        }
        else{
            echo "<p>Error en la extraccion</p>";
            echo "<p>Código: ".mysqli_errno($db)."</p>";
            echo "<p>Mensaje: ".mysqli_error($db)."</p>";
        }
    }

    // Eliminar una incidencia
    function eliminarIncidencia($id){
        global $db;
        $id = mysqli_real_escape_string($db, $id);
        $consulta = "DELETE FROM Publica WHERE idIncidencia = $id";

        if (mysqli_query($db, $consulta)){
            $consulta = "DELETE FROM Incidencia WHERE id = $id";

            if (mysqli_query($db, $consulta)){
                GuardarLog("Incidencia $id eliminada");
            }
            else{
                echo "<p>Error en el primer borrado</p>";
                echo "<p>Código: ".mysqli_errno($db)."</p>";
                echo "<p>Mensaje: ".mysqli_error($db)."</p>";
            }
        }
        else{
            echo "<p>Error en el segundo borrado</p>";
            echo "<p>Código: ".mysqli_errno($db)."</p>";
            echo "<p>Mensaje: ".mysqli_error($db)."</p>";
        }
    }

    // Añadir un comentario a una incidencia
    function nuevoComentario($id, $comentario){
        global $db;
        $comentario = mysqli_real_escape_string($db, $comentario);
        $consulta = "INSERT INTO Comentario(descripcion) VALUES ('$comentario')";

        if (mysqli_query($db, $consulta)){
            $idCom = mysqli_insert_id($db);
            $consulta = "INSERT INTO Contiene(idComentario, idIncidencia) VALUES ('$idCom', '$id')";

            if (mysqli_query($db, $consulta)){
                $usuario = getSession('currentUser');
                $consulta = "INSERT INTO Escribe(idComentario, email) VALUES ('$idCom', '$usuario')";

                if (mysqli_query($db, $consulta)){
                    GuardarLog("El usuario $usuario ha comentado en una incidencia");
                }
                else{
                    echo "<p>Error en la primera insercion</p>";
                    echo "<p>Código: ".mysqli_errno($db)."</p>";
                    echo "<p>Mensaje: ".mysqli_error($db)."</p>";
                }
            }
            else{
                echo "<p>Error en la segunda insercion</p>";
                echo "<p>Código: ".mysqli_errno($db)."</p>";
                echo "<p>Mensaje: ".mysqli_error($db)."</p>";
            }
        }
        else{
            echo "<p>Error en la tercera insercion</p>";
            echo "<p>Código: ".mysqli_errno($db)."</p>";
            echo "<p>Mensaje: ".mysqli_error($db)."</p>";
        }
    }

    // Insertar imagenes en una incidencia
    function InsertarImagenesIncidencia($id, $imagenes){
        global $db;

        foreach ($imagenes as $imagen){
            $consulta = "INSERT INTO Foto(foto) VALUES '$imagen'";

            if (mysqli_query($db, $consulta)){
                $idPic = mysqli_insert_id($db);
                $consulta = "INSERT INTO Tiene (idFoto, idIncidencia) VALUES ('$idPic', '$id')";

                if (mysqli_query($db, $consulta)){
                    GuardarLog("Imagenes añadidas para la incidencia: $id");
                }
                else{
                    echo "<p>Error en la primera insercion</p>";
                    echo "<p>Código: ".mysqli_errno($db)."</p>";
                    echo "<p>Mensaje: ".mysqli_error($db)."</p>";
                }
            }
            else{
                echo "<p>Error en la segunda insercion</p>";
                echo "<p>Código: ".mysqli_errno($db)."</p>";
                echo "<p>Mensaje: ".mysqli_error($db)."</p>";
            }
        }
    }

    // Obtener datos del registro
    function ObtenerDatosLog(){
        $resultado = null;
        global $db;

        $consulta = "SELECT * FROM Log";
        $prep = mysqli_prepare($db, $consulta);

        if(mysqli_stmt_execute($prep)){
            $res = mysqli_stmt_get_result($prep);

            if($res){
                $resultado = mysqli_fetch_all($res);
            }
            else{
                echo "<p>Error en la consulta</p>";
                echo "<p>Código: ".mysqli_errno($db)."</p>";
                echo "<p>Mensaje: ".mysqli_error($db)."</p>";
            }
            mysqli_free_result($res);
        }
        mysqli_stmt_close($prep);

        return $resultado ? $resultado : null;
    }

    // Añadir datos al registro
    // Este texto no es saneado porque se escribe automáticamente por el sistema,
    // el usuario no interviene en la redaccion
    function GuardarLog($texto){
        global $db;
        $consulta = "INSERT INTO Log(evento) values ('$texto')";

        if(!mysqli_query($db, $consulta)){
            echo "<p>Error en la insercion</p>";
            echo "<p>Código: ".mysqli_errno($db)."</p>";
            echo "<p>Mensaje: ".mysqli_error($db)."</p>";
        }
    }

    // Verifica un usuario que intenta logearse
    function ComprobarUsuario($email, $contra){
        $datos = ObtenerDatosUsuario($email);
        if(password_verify($contra, $datos['clave'])){
            GuardarLog("El usuario $email ha iniciado sesion");
            return true;
        }
        else{
            GuardarLog("El usuario $email ha intentado inciar sesion sin éxito");
            return false;
        }
    }

    // Edita los datos de un usuario
    function ActualizarUsuario($email, $nombre, $apellidos, $clave, $direccion, $tlf, $rol, $estado, $foto){
        global $db;

        // Sanear datos
        $email = mysqli_real_escape_string($db, $email);
        $nombre = mysqli_real_escape_string($db, $nombre);
        $apellidos = mysqli_real_escape_string($db, $apellidos);
        $clave = mysqli_real_escape_string($db, $clave);
        $clave = password_hash($clave, PASSWORD_BCRYPT);
        $direccion = mysqli_real_escape_string($db, $direccion);
        $tlf = mysqli_real_escape_string($db, $tlf);
        $rol = mysqli_real_escape_string($db, $rol);
        $estado = mysqli_real_escape_string($db, $estado);

        $consulta = "UPDATE Usuario SET nombre = '$nombre', apellidos = '$apellidos', clave = '$clave', direccion = '$direccion', 
        tlf = '$tlf', rol = '$rol', estado = '$estado', foto = '$foto' WHERE email = '$email';";

        if(mysqli_query($db, $consulta)){
            GuardarLog("Usuario \"$email\" modificado");
        }
        else{
            echo "<p>Error en la insercion</p>";
            echo "<p>Código: ".mysqli_errno($db)."</p>";
            echo "<p>Mensaje: ".mysqli_error($db)."</p>";
        }
        
    }

    // Extrae información para el relleno del ranking
    function Ranking($quejas, $pos){
        global $db;
        $pos = mysqli_real_escape_string($db, $pos);

        if ($quejas){
            $consulta = "SELECT email, COUNT(*) AS total
                     FROM Publica
                     GROUP BY email
                     ORDER BY total DESC
                     LIMIT " . ($pos - 1) . ", 1";
        }
        else{
            $consulta = "SELECT email, COUNT(*) AS total
                     FROM Escribe
                     GROUP BY email
                     ORDER BY total DESC
                     LIMIT " . ($pos - 1) . ", 1";
        }

        $resultado = mysqli_query($db, $consulta);

        if (mysqli_num_rows($resultado) > 0) {
            $res = mysqli_fetch_assoc($resultado);

            $email = $res['email'];
            $consulta = "SELECT nombre, apellidos FROM Usuario WHERE email = '$email'";
            $resultado = mysqli_query($db, $consulta);
            $res1 = mysqli_fetch_assoc($resultado);

            return "(" . $res['total'] . ") " . $res1['nombre'] . " " . $res1['apellidos'];
        }
        else{
            return "Sin datos aún";
        }
    }

    // Obtener los usuarios guardados
    function MostrarUsuariosRegistrados(){
        $resultado = null;
        global $db;

        $consulta = "SELECT * FROM Usuario";
        $prep = mysqli_prepare($db, $consulta);

        if(mysqli_stmt_execute($prep)){
            $res = mysqli_stmt_get_result($prep);

            if($res){
                $resultado = mysqli_fetch_all($res);
            }
            else{
                echo "<p>Error en la consulta</p>";
                echo "<p>Código: ".mysqli_errno($db)."</p>";
                echo "<p>Mensaje: ".mysqli_error($db)."</p>";
            }
            mysqli_free_result($res);
        }
        mysqli_stmt_close($prep);

        return $resultado ? $resultado : null;
    }

    // Eliminar un usuario
    function BorrarUsuario($email){
        global $db;
        $email = mysqli_real_escape_string($db, $email);
        $consulta = "DELETE FROM Publica WHERE email = '$email'";

        if (mysqli_query($db, $consulta)){
            $consulta = "DELETE FROM Escribe WHERE email = '$email'";
            
            if (mysqli_query($db, $consulta)){
                $consulta = "DELETE FROM Usuario WHERE email = '$email'";

                if (mysqli_query($db, $consulta)){
                    GuardarLog("Usuario \"$email\" eliminado");
                }
                else{
                    echo "<p>Error en la primera eliminación</p>";
                    echo "<p>Código: ".mysqli_errno($db)."</p>";
                    echo "<p>Mensaje: ".mysqli_error($db)."</p>";
                }
            }
            else{
                echo "<p>Error en la segunda eliminación</p>";
                echo "<p>Código: ".mysqli_errno($db)."</p>";
                echo "<p>Mensaje: ".mysqli_error($db)."</p>";
            }
        }
        else{
            echo "<p>Error en la tercera eliminación</p>";
            echo "<p>Código: ".mysqli_errno($db)."</p>";
            echo "<p>Mensaje: ".mysqli_error($db)."</p>";
        }
    }

    // Iniciar conexión
    ConectarBD();
?>