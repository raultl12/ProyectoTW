<?php
    require_once 'funciones.php';

    session_start();

    HTMLInicio();
    MostrarHeader(getSession("tipoCliente"));

    // Mostrar contenido
    if(getSession("tipoCliente") != "administrador"){
        MostrarAccesoDenegado();
    }
    else{
        MostrarGestionBD();
    }

    // BD en estado actual
    if (isset($_POST["copia"])){
        $host = 'localhost';
        $db = 'tw';
        $user = 'root';
        $pw = 'YES';
        $res = 'volcado.sql';

        $command = "mysqldump --host=$host --user=$user --password=$pw $db > $res";

        // Ejecutar el comando
        exec($command, $output, $result);

        // Verificar si el volcado se generó correctamente
        if ($result === 0) {
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $res . '"');

            // Enviar el contenido del archivo
            readfile($res);

            // Eliminar el archivo del servidor
            unlink($res);
            //exit();
        }
        else {
            echo "Error al generar el volcado de la base de datos.";
        }

    }

    // BD vacía, solo usuarios
    if(isset($_POST['vacia'])){
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="backupBD.sql"');

        readfile("../backupBD.sql");
    }
    
    MostrarFooter();
    HTMLFin();
?>