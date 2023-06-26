<?php
    require_once 'funciones.php';

    session_start();

    HTMLInicio();
    MostrarHeader(getSession("tipoCliente"));

    if(isset($_POST['numeroPost']) and $_POST['numeroPost'] == "uno"){ // Primera confiramacion
        $post = new ArrayObject($_POST);
        $files = new ArrayObject($_FILES);
        /*
        $binario = null;
        $nombreArchivo = null;
        if(isset($_FILES["photo-selected"])){
            $binario = file_get_contents($_FILES['photo-selected']['tmp_name']);
            $nombreArchivo = $_FILES['photo-selected']['name'];
        }*/

        MostrarContenidoEdicionUsuario("tipoCliente", "readonly", false, "dos", $post, $files);
        print($_POST['numeroPost']);
    }

    else if(isset($_POST['numeroPost']) and $_POST['numeroPost'] == "dos"){ // Éxito
        $post = new ArrayObject($_POST);
        $files = new ArrayObject($_FILES);
        MostrarCambiosExito(false, $post, $files);
    }

    else{ // Primera vez
        MostrarContenidoEdicionUsuario("tipoCliente", "", false, "uno", null, null);
    }

/*
    if(isset($_POST["hidden"])){
        if($_POST["hidder"] == "2"){
            MostrarCambiosExito(false);
        }
        else{

        }
    }*/
/*
    if (isset($_COOKIE['correcto']) and $_COOKIE == true){
        setcookie('correcto', false);
        MostrarCambiosExito(false);
    }

    else if (isset($_POST['changes'])){
        MostrarContenidoEdicionUsuario("tipoCliente", "disabled", false);
        setcookie('correcto', true);
    }
    else{
        MostrarContenidoEdicionUsuario("tipoCliente", "", false, null);
    }
*/
    MostrarFooter();
    HTMLFin();
?>