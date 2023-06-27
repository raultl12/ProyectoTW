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

    if(isset($_POST["copia"])){
        // Datos de conexión a la base de datos
        $host = 'localhost';
        $username = 'tw';
        $password = 'TW12345tw_';
        $database = 'tw';
        
        // Nombre del archivo de copia de seguridad
        $backupFile = 'backup.sql';
        
        // Comando para generar la copia de seguridad usando mysqldump
        $command = "mysqldump --host={$host} --user={$username} --password={$password} {$database} > {$backupFile}";
        
        $returnValue = null;
        $output = null;
        // Ejecutar el comando del sistema
        exec($command, $output, $returnValue);
        echo $returnValue;
        print_r($output);
        
        if ($returnValue === 0) {
            // Descargar el archivo de copia de seguridad
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($backupFile).'"');
            readfile($backupFile);
            exit;
        }
    }
    
    MostrarFooter();
    HTMLFin();
?>