<?php
    /************************************************************************************************************** */
    // Funciones de acceso a la base de datos

    $db = null; // Conexión con la base de datos
    $dev = "m";

    //Conexion a la BD
    function ConectarBD(){
        global $db;
        global $dev;
        
        // Conectar
        //$db = mysqli_connect("localhost","mario252223","DWyd1cEO","mario252223");
        
        if($dev == "r")
            $db = mysqli_connect("localhost","tw","tw123","proyectoTW");
        else if($dev == "m")
            $db = mysqli_connect("localhost","tw","TW12345tw_","tw");
        else
            $db = mysqli_connect("localhost","mario252223","DWyd1cEO","mario252223");

        // Informar de errores
        if (!$db) {
            echo "<p>Error en la conexión a la base de datos</p>";
            echo "<p>Código: " . mysqli_connect_errno() . "</p>";
            echo "<p>Mensaje: " . mysqli_connect_error() . "</p>";
            die("Adiós");
        } 

        // Establecer el conjunto de caracteres del cliente
        mysqli_set_charset($db,"utf8");
    }

    // Facilitar errores al administrador
    function Error($msg){
        if (getSession('tipoCliente') == "administrador"){
            global $db;

            echo "<p>$msg</p>";
            echo "<p>Código: ".mysqli_errno($db)."</p>";
            echo "<p>Mensaje: ".mysqli_error($db)."</p>";
        }

        GuardarLog($msg);
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
                Error("Error en la obtención de datos del usuario");
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
        $foto = mysqli_real_escape_string($db, $foto);

        $consulta = "INSERT INTO Usuario (email, nombre, apellidos, clave, direccion, tlf, rol, estado, foto) VALUES 
                     ('$email', '$nombre', '$apellidos', '$clave', '$dir', '$tlf', '$rol', '$estado', '$foto')";

        if (mysqli_query($db, $consulta)){
            GuardarLog("Nuevo usuario: \"$email\" añadido");
        }
        else{
            Error("Error en la inserción del nuevo usuario");
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

            else Error("Error en la obtención de todas las incidencias");
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
                Error("Error en obtener los datos de la incidencia $id");
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
        else Error("Error en la inserción de la nueva incidencia");    

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
            Error("Error en la edición de la incidencia $id");
        }
    }

    // Obtener autor de incidencia
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
                Error("Error en la obtención del autor de la incidenia $idInci");
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

            mysqli_free_result($res);
        }
        else{
            Error("Error en la obtención de todos los comentarios");
        }

        mysqli_stmt_close($prep);
        return $resultado ? $resultado : null;
    }

    // Obtener comentario
    function ObtenerComentario($idCom){
        $resultado = null;
        global $db;

        $consulta = "SELECT * FROM Comentario where id=?";

        $prep = mysqli_prepare($db, $consulta);
        mysqli_stmt_bind_param($prep,'i', $idCom);

        if(mysqli_stmt_execute($prep)){
            $res = mysqli_stmt_get_result($prep);

            if($res){
                $resultado = mysqli_fetch_assoc($res);
            }

            mysqli_free_result($res);
        }
        else{
            Error("Error en la obtención del comentario $idCom");
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
        }
        else{
            Error("Error en la obtención del autor del comentario $idCom");
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
            
            mysqli_free_result($res);
        }
        else{
            Error("Error en la obtención de las imágenes de la incidencia $inci");
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
                else{
                    Error("Error en la obtención de las imágenes");
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
            $consulta = "UPDATE Incidencia SET valPos = '$valor' WHERE id = $id";

            if (mysqli_query($db, $consulta)){
                GuardarLog("Voto positivo añadido a incidencia $id");
            }
            else{
                Error("Error en la inserción del nuevo voto positivo en la incidencia $id");
            }
        }
        else{
            Error("Error en la obtención de los votos positivos de la incidencia $id");
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
                Error("Error en la inseción del nuevo voto negativo en la incidencia $id");
            }
        }
        else{
            Error("Error en la obtención de los votos negativos de la incidencia $id");
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
                Error("Error en el borrado de la tabla \"Incidencia\" para la incidencia $id");
            }
        }
        else{
            Error("Error en el borrado de la tabla \"Publica\" para la incidencia $id");
        }
    }

    // Añadir un comentario a una incidencia
    function nuevoComentario($id, $comentario){
        echo $id;
        echo $comentario;
        global $db;
        $comentario = mysqli_real_escape_string($db, $comentario);
        $consulta = "INSERT INTO Comentario(descripcion) VALUES ('$comentario')";

        if (mysqli_query($db, $consulta)){
            $idCom = mysqli_insert_id($db);
            $consulta = "INSERT INTO Contiene(idComentario, idIncidencia) VALUES ('$idCom', '$id')";

            if (mysqli_query($db, $consulta)){
                $tipo = getSession('tipoCliente'); 

                // Los comentarios anonimos no se tienen en cuenta en la siguiente sentencia
                // ya que no estan registrados en la tabla de usuarios, aunque sí aparecerá el comentario,
                // no se reflejará en el ranking.
                if ($tipo != "anonimo"){
                    $usuario = getSession('currentUser');
                    $consulta = "INSERT INTO Escribe(idComentario, email) VALUES ('$idCom', '$usuario')";

                    if (mysqli_query($db, $consulta)){
                        GuardarLog("El usuario $usuario ha comentado en la incidencia $id");
                    }
                    else{
                        Error("Error en la inserición de la tabla \"Escribe\" para el comentario $idCom");
                    }
                }
                else{
                    GuardarLog("Un usuario anónimo ha comentado en la incidencia $id");
                }
            }
            else{
                Error("Error en la inserición de la tabla \"Contiene\" para la incidencia $id");
            }
        }
        else{
            Error("Error en la inserición de la tabla \"Comentario\"");
        }
    }

    // Insertar imagenes en una incidencia
    function InsertarImagenesIncidencia($id, $imagen){
        global $db;
        $consulta = "INSERT INTO Foto (foto) VALUES (?)";

        $prep = mysqli_prepare($db, $consulta);
        mysqli_stmt_bind_param($prep, 's', $imagen);

        if (mysqli_stmt_execute($prep)){
            $idPic = mysqli_insert_id($db);
            $consulta = "INSERT INTO Tiene (idFoto, idIncidencia) VALUES ('$idPic', '$id')";

            if (mysqli_query($db, $consulta)){
                GuardarLog("Imagen añadida a la incidencia: $id");
                return true;
            }
            else{
                Error("Error en la inserición de la tabla \"Tiene\" para la incidencia $id");
                return false;
            }
        }
        else{
            Error("Error en la inserición de la tabla \"Foto\"");
            return false;
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
                Error("Error en la obtención de los datos del registro");
            }
            mysqli_free_result($res);
        }
        mysqli_stmt_close($prep);

        return $resultado ? $resultado : null;
    }

    // Añadir datos al registro
    // Este texto no es saneado porque se escribe automáticamente por el sistema,
    // el usuario no interviene en la redacción
    function GuardarLog($texto){
        global $db;
        $consulta = "INSERT INTO Log(evento) values ('$texto')";

        if(!mysqli_query($db, $consulta)){
            echo "<p>Error al guardar el nuevo registro</p>";
            echo "<p>Código: " . mysqli_errno($db) . "</p>";
            echo "<p>Mensaje: " . mysqli_error($db) . "</p>";
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

    // Cambiar estado del usuario
    function LogIn($user){
        global $db;
        $user = mysqli_real_escape_string($db, $user);
        $consulta = "UPDATE Usuario SET estado = 'activo' WHERE email = ?";

        $prep = mysqli_prepare($db, $consulta);
        mysqli_stmt_bind_param($prep, 's', $user);

        if (!mysqli_stmt_execute($prep)){
            Error("Error en el cambio de estado del usuario $user");
        }

        mysqli_stmt_close($prep);
    }

    // Cambiar estado del usuario
    function LogOut($user){
        global $db;
        $user = mysqli_real_escape_string($db, $user);
        $consulta = "UPDATE Usuario SET estado = 'inactivo' WHERE email = ?";

        $prep = mysqli_prepare($db, $consulta);
        mysqli_stmt_bind_param($prep, 's', $user);

        if (!mysqli_stmt_execute($prep)){
            Error("Error en el cambio de estado del usuario $user");
        }

        mysqli_stmt_close($prep);
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
        $foto = mysqli_real_escape_string($db, $foto);

        $consulta = "UPDATE Usuario SET nombre = '$nombre', apellidos = '$apellidos', clave = '$clave', direccion = '$direccion', 
        tlf = '$tlf', rol = '$rol', estado = '$estado', foto = '$foto' WHERE email = '$email';";

        if(mysqli_query($db, $consulta)){
            GuardarLog("Usuario \"$email\" modificado");
        }
        else{
            Error("Error en la modificación del usuario $email");
        }
        
    }

    // Extrae información para el relleno del ranking
    function Ranking($quejas, $pos){
        global $db;
        $pos = mysqli_real_escape_string($db, $pos);

        // Incidencias
        if ($quejas){
            $consulta = "SELECT email, COUNT(*) AS total
                      FROM Publica
                      GROUP BY email
                      ORDER BY total DESC
                      LIMIT " . ($pos - 1) . ", 1";
        }

        // Comentarios
        else{
            $consulta = "SELECT email, COUNT(*) AS total
                      FROM Escribe
                      GROUP BY email
                      ORDER BY total DESC
                      LIMIT " . ($pos - 1) . ", 1";
        }

        if ($resultado = mysqli_query($db, $consulta)){            
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

        else Error("Error al obtener los datos del Ranking");
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
                Error("Error en la obtención de todos los usuarios registrados");
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
                    Error("Error en la eliminación de la tabla \"Usuario\" para el usuario $email");
                }
            }
            else{
                Error("Error en la eliminación de la tabla \"Escribe\" para el usuario $email");
            }
        }
        else{
            Error("Error en la eliminación de la tabla \"Publica\" para el usuario $email");
        }
    }

    // Edita el estado de una incidencia
    function EditarEstadoIncidencia($estado, $id){
        global $db;
        $id = mysqli_real_escape_string($db, $id);
        $estado = mysqli_real_escape_string($db, $estado);
        $consulta = "UPDATE Incidencia SET estado = '$estado' WHERE id = $id";

        if (mysqli_query($db, $consulta)){
            GuardarLog("Estado de la incidencia $id cambiado a $estado");
        }
        else{
            Error("Error al alterar el estado de la incidencia $id");
        }
    }

    // Iniciar conexión
    ConectarBD();
?>