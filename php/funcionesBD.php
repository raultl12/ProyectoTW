<?php
    /************************************************************************************************************** */
    // Funciones de acceso a Base de Datos

    ini_set('display_errors', 1);
    $db = null;

    $dev = "m";

    //Conexion a la BD
    function ConectarBD(){
        global $db;
        global $dev;
        if($dev == "r"){
            $db = mysqli_connect("localhost","tw","tw123","proyectoTW");
        }
        else{
            $db = mysqli_connect("localhost","tw","TW12345tw_","tw");
        }
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
            echo "Insertado correctamente";
        }
        else{
            echo "<p>Error en la insercion</p>";
            echo "<p>Código: ".mysqli_errno($db)."</p>";
            echo "<p>Mensaje: ".mysqli_error($db)."</p>";
        }

        return mysqli_insert_id($db);
    }

    function ObtenerUsuarioPublica($idInci){
        $resultado = null;
        global $db;
        //$consulta = "SELECT email FROM Publica WHERE idIncidencia=?";
        $consulta = "SELECT nombre, apellidos FROM Usuario WHERE email=(SELECT email FROM Publica WHERE idIncidencia=?)";
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
                        echo $r;
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

    function ObtenerUsuarioComentario($idCom){
        $resultado = null;
        global $db;
        //$consulta = "SELECT email FROM Publica WHERE idIncidencia=?";
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
                    echo $idFoto["idFoto"];

                }
            }
            else{
                echo "<p>Error en la consulta</p>";
                echo "<p>Código: ".mysqli_errno($db)."</p>";
                echo "<p>Mensaje: ".mysqli_error($db)."</p>";
            }
            mysqli_free_result($res);
        }
        else{
            echo "No se ha ejecutado";
        }
        mysqli_stmt_close($prep);
        
        //Ya obtenidos los ids de las fotos de la incidencia, almacenados en idsFotos
        //Hacer la consulta para obtener las fotos

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

    function votoPositivo($id){
        global $db;
        $consulta = "SELECT valPos FROM Incidencia where id = $id";

        if ($res = mysqli_query($db, $consulta)){
            $resultado = mysqli_fetch_assoc($res);
            $valor = (int) $resultado['valPos'];

            $valor += 1;

            $act = "UPDATE Incidencia SET valPos = $valor WHERE id = $id";
            if (mysqli_query($db, $act)){
                echo "Insertado correctamente";
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

    function votoNegativo($id){
        global $db;
        $consulta = "SELECT valNeg FROM Incidencia where id = $id";

        if ($res = mysqli_query($db, $consulta)){
            $resultado = mysqli_fetch_assoc($res);
            $valor = (int) $resultado['valPos'];

            $valor += 1;

            $act = "UPDATE Incidencia SET valNeg = $valor WHERE id = $id";
            if (mysqli_query($db, $act)){
                echo "Insertado correctamente";
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

    function eliminarIncidencia($id){
        global $db;
        $consulta = "DELETE FROM Incidencias WHERE id = $id";

        if (mysqli_query($db, $consulta)){
            echo "Insertado correctamente";
        }
        else{
            echo "<p>Error en el borrado</p>";
            echo "<p>Código: ".mysqli_errno($db)."</p>";
            echo "<p>Mensaje: ".mysqli_error($db)."</p>";
        }
    }

    function nuevoComentario($id, $comentario){
        global $db;
        $consulta = "INSERT INTO Comentario(descripcion) VALUES '$comentario'";

        if (mysqli_query($db, $consulta)){
            $idCom = $db->lastInsertId();
            $consulta = "INSERT INTO Contiene(idComentario, idIncidencia) VALUES ('$idCom', '$id')";

            if (mysqli_query($db, $consulta)){
                echo "Insertado correctamente";
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

    function InsertarImagenesIncidencia($id, $imagenes){
        global $db;

        foreach ($imagenes as $imagen){
            $consulta = "INSERT INTO Foto(foto) VALUES '$imagen'";

            if (mysqli_query($db, $consulta)){
                $idPic = $db->lastInsertId();
                $consulta = "INSERT INTO Tiene (idFoto, idIncidencia) VALUES ('$idPic', '$id')";

                if (mysqli_query($db, $consulta)){
                    echo "Insertado correctamente";
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

    function ComprobarUsuario($email, $contra){
        $datos = ObtenerDatosUsuario($email);
        if(password_verify($contra, $datos["clave"])){
            return true;
        }
        else{
            return false;
        }
    }

    function ActualizarUsuario($email, $nombre, $apellidos, $clave, $direccion, $tlf, $rol, $estado, $foto){
        global $db;
        $consulta = "UPDATE Usuario SET nombre = '$nombre', apellidos = '$apellidos', clave = '$clave', direccion = '$direccion', 
        tlf = '$tlf', rol = '$rol', estado = '$estado', foto = '$foto' WHERE email = '$email';";

        if(mysqli_query($db, $consulta)){

            echo "actualizado correctamente";
        }
        else{
            echo "<p>Error en la insercion</p>";
            echo "<p>Código: ".mysqli_errno($db)."</p>";
            echo "<p>Mensaje: ".mysqli_error($db)."</p>";
        }
        
    }

    ConectarBD();
    /*mysqli_close($db); (?)
    $contra = "1234"; //-->Es la contraseña del usuario raul $2y$10$qsArjeEi./DEGX3kucloGOED1szvDlOy3Om8/iaRJCqgCzQtFs/fK
    $cifrada = password_hash($contra, PASSWORD_BCRYPT, ['salt' => $salt]);
    echo $cifrada;*/
    //ObtenerDatosUsuario("raultlopez@correo.ugr.es");
    //InsertarIncidencia("mi calle", "farola rota", "farola", "irresoluble", "Se han roto las farolas bobis", 0, 0);
    //ObtenerDatosIncidencia(1);
    //ObtenerTodasIncidencias();

    
?>