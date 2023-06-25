
<?php

    require_once 'funcionesBD.php';

    /************************************************************************************************************** */
    // Variables globales

    $actualUser = null;
    $tipoCliente = "anonimo";
    $logged = false;

    /*$actualUser = getSession('actualUser');     // identificador del usuario actual loggeado
    $tipoCliente = getSession('tipoCliente');   // tipo del usuario actual loggeado
    $logged = getSession('logged');             // hay un usuario loggeado ?*/

    /************************************************************************************************************** */
    // Codigo de guardado y obtencion de sesion
    function setSession($nombreVariable, $valor){
        $_SESSION[$nombreVariable] = $valor;
    }

    function getSession($nombreVariable){
        if(isset($_SESSION[$nombreVariable])){
            return $_SESSION[$nombreVariable];  
        }
        else{
            return null;
        }
    }

    function Recargar(){
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    }

    /************************************************************************************************************** */
    // Codigo de generación de HTML
    function HTMLInicio(){
        echo <<<HTML
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="../css/style.css">
            <link rel="stylesheet" href="../css/incidencia.css">
            <link rel="stylesheet" href="../css/listadoIncidencias.css">
            <link rel="stylesheet" href="../css/gestionUsuarios.css">
            <link rel="stylesheet" href="../css/log.css">
            <link rel="stylesheet" href="../css/edicionUsuario.css">
            <link rel="stylesheet" href="../css/gestionIncidencia.css">
            
            <title>Proyecto</title>
        </head>
        <body>
        HTML;
    }

    function HTMLFin(){
        echo <<<HTML
            </body>
            </html>
        HTML;
    }

    function MostrarHeader($tipoUsuario){
        echo <<<HTML
        <header>
            <div class="cabecera">
                <img src="../img/megafono.png" alt="megafono" class="pageLogo">
                <h1>Quéjate ¡no te calles!</h1>
            </div>
            
            <h2>¿Algo va mal? Publica tu queja</h2>
        </header>
        HTML;

        MostrarNav($tipoUsuario);
    }

    function MostrarFooter(){
        echo <<<HTML
        <footer>
            <p>Creado por <a href="https://www.linkedin.com/in/ra%C3%BAl-torrente-l%C3%B3pez-6b9760250/">Raúl Torrente López</a>
               y <a href="https://www.linkedin.com/in/mario-pi%C3%B1a-munera-465116225/">Mario Piña Munera</a></p>

            <p><a href="../doc/doc.pdf">Documentación</a></p>
        </footer>
        HTML;
    }

    function MostrarNav($tipoUsuario){
        echo <<<HTML
            <nav>
                <ul>
        HTML;

        switch($tipoUsuario){
            case "colaborador":
                echo <<<HTML
                    <li><a href="./index.php">Ver incidencias</a></li>
                    <li><a href="./nuevaIncidencia.php">Nueva incidencia</a></li>
                    <li><a href="./misIncidencias.php">Mis incidencias</a></li>
                HTML;
                break;

            case "administrador":
                echo <<<HTML
                    <li><a href="./index.php">Ver incidencias</a></li>
                    <li><a href="./nuevaIncidencia.php">Nueva incidencia</a></li>
                    <li><a href="./misIncidencias.php">Mis incidencias</a></li>
                    <li><a href="./gestionUsuarios.php">Gestión de usuarios</a></li>
                    <li><a href="./log.php">Ver log</a></li>
                    <li><a href="">Gestión de BBDD</a></li>
                HTML;
                break;

            default:
                echo "<li><a href=\"./index.php\">Ver incidencias</a></li>";
                break;
        }

        echo <<<HTML
                </ul>
            </nav>
        HTML;
    }

    function MostrarIncidencia($inci){
        $datos = ObtenerDatosIncidencia($inci);
        //Obtener el usuario que la ha publicado
        $usuarioPublica = ObtenerUsuarioPublica($inci);
        $nombreUsuario = $usuarioPublica["nombre"] . " " . $usuarioPublica["apellidos"];

        //Obtener los comentarios
        //Obtener el numero total de comentarios (los ids)
        $comentarios = ObtenerTodosComentarios($inci);
        $fotos = ObtenerFotosIncidencia($inci);

        echo <<<HTML
            <div class="incidencia">
                <h2>{$datos["titulo"]}</h2>

                <div class="detalles">
                    <div class="infoGeneral">
                        <label>Lugar: <em>{$datos["lugar"]}</em></label>
                        <label>Fecha: <em>{$datos["fecha"]}</em></label>
                        <label>Creador por: <em>$nombreUsuario</em></label>
                        <label>Palabras clave: <em>{$datos["palClave"]}</em></label>
                        <label>Estado: <em>{$datos["estado"]}</em></label>
                        <label>Valoraciones: <em>Pos: {$datos["valPos"]} Neg: {$datos["valNeg"]}</em></label>
                    </div>

                    <p>
                    {$datos["descripcion"]}
                    </p>

                    <div class="fotos">
        HTML;
                        if($fotos){
                            foreach($fotos as $foto){
                                $imagen = base64_encode($foto);
                                echo "<img src='data:image/jpg;base64,".$imagen."'>";
                            }
                        }
                        else{
                            echo "<h2>Todavia no hay fotos</h2>";
                        }
        echo <<<HTML
                    </div>

                </div>

                <div class="seccionComentarios">
        HTML;

        if($comentarios){
            foreach($comentarios as $c){
                MostrarComentario($c);
            }
        }
        else{
            echo "<h2>Todavia no hay comentarios</h2>";
        }

        if (isset($_POST['comment']))
            comentarIncidencia();

        echo <<<HTML

                </div>

                <div class="iconos">
                    <form method="post" action="./index.php">
                        <label for="plus"><img src="../img/plus.png" alt="+"></label>
                        <input type="submit" name="plus" id="plus">
                        
                        <label for="minus"><img src="../img/minus.png" alt="-"></label>
                        <input type="submit" name="minus" id="minus">

                        <label for="comment"><img src="../img/comment.png" alt="comentar"></label>
                        <input type="submit" name="comment" id="comment">
        HTML;
        if(getSession("tipoCliente") != "anonimo"){
            echo <<<HTML
                        <a href="./editarIncidencia.php"><img src="../img/editar.png" alt=""></a>
                
                        <label for="eliminar"><img src="../img/basura.png" alt="eliminar"></label>
                        <input type="submit" name="eliminar" id="eliminar">
                    </form>
            HTML;
        }
        echo <<<HTML
                </div>
            </div>
        HTML;

        if (isset($_POST['plus'])) votoPositivo($datos['id']);
        if (isset($_POST['minus'])) votoNegativo($datos['id']);
        if (isset($_POST['eliminar'])) eliminarIncidencia($datos['id']);
        if (isset($_POST['nuevoComentario'])) nuevoComentario($datos['id'], $_POST['textoComentario']);
    }

    function comentarIncidencia(){
        echo <<<HTML
            <div class="nuevoComentario">
                <form action="./index.php" method="post">
                    <textarea name="textoComentario"></textarea>
                    <input type="submit" name="nuevoComentario" value="Enviar comentario">
                </form>
            </div>
        HTML;
    }

    function MostrarAside(){
        $correcto = false;
        $datos = null;
        $error = false;
        $errorText = "Error en email o contraseña. Si no tienes cuenta solicita una a un administrador";

        if (isset($_POST['logout'])){
            /*setSession('logged', false);
            setSession("tipoCliente", "anonimo");*/
            session_unset();
            Recargar();
        }
        else if(getSession("logged")){
            $datos = ObtenerDatosUsuario(getSession("currentUser"));
        }
        else if (isset($_POST['login'])){
            //Validar mail
            $email = htmlentities($_POST['email']);
            $email = filter_var($email, FILTER_VALIDATE_EMAIL) ? filter_var($email, FILTER_VALIDATE_EMAIL) : null;

            if($email == null){
                $error = true;
            }

            if(!$error){
                $contrasena = htmlentities($_POST['clave']);
                $correcto = ComprobarUsuario($email, $contrasena);
    
                if($correcto){
                    setSession('currentUser', $email);
                    setSession('logged', true);
                    $datos = ObtenerDatosUsuario($email);
                    setSession("tipoCliente", $datos["rol"]);
                    Recargar();
                }
                else{
                    $error = true;
                }
            }
            

        }
        else{
            session_unset();
        }

        if ($correcto or getSession("logged")){
            $nombre = $datos["nombre"];
            $rol = $datos["rol"];
            $foto = base64_encode($datos['foto']);
            echo <<<HTML
                    <aside>
                        <div class="usuario-aside">
                            <p>$nombre</p>
                            <p>$rol</p>
            HTML;
                            echo "<img src='data:image/jpg;base64,".$foto."'>";
            echo <<<HTML
                            <div class="envios">
                                <form action="./edicionUsuario.php" method="POST"><input type="submit" value="Editar"></form> 
                                <form method="POST"><input type="submit" name="logout" value="Logout"></form>
                            </div>
                        </div>
            HTML;
        }
        else{
            echo <<<HTML
                    <aside>
                        <div class="login-aside">
                            <form action="./" method="POST">
                                <p>Email:</p>
                                <input type="email" name="email">

                                <p>Clave:</p>
                                <input type="password" name="clave">

                                <input type="submit" name="login" value="Log In">
                            </form>
            HTML;
            if($error){
                echo "<p style=\"color: red;\">$errorText</p>";
            }
            echo <<<HTML
                        </div>
            HTML;
        }

        // Pedir a la base de datos
        // Sintaxis: (numero) nombre
        // funcion de la base de datos pa sacar esta wea

        $top1_quejas = 0;
        $top2_quejas = 0;
        $top3_quejas = 0;

        $top1_opinion = 0;
        $top2_opinion = 0;
        $top3_opinion = 0;

        echo <<<HTML

                    <div class="rankings">
                        <div class="quejas">
                            <h3>Top quejicas</h3>

                            <ol>
                                <li>$top1_quejas</li>
                                <li>$top2_quejas</li>
                                <li>$top3_quejas</li>
                            </ol>
                        </div>

                        <div class="opiniones">
                            <h3>Top opinionistas</h3>

                            <ol>
                                <li>$top1_opinion</li>
                                <li>$top2_opinion</li>
                                <li>$top3_opinion</li>
                            </ol>
                        </div>
                    </div>
                </aside>
        HTML;
    }

    function MostrarContenidoIncidencias(){
        $incidencias = ObtenerTodasIncidencias();
        /*foreach($incidencias as $i){
            echo $i;
            echo "<br>";
        }*/
        echo <<<HTML
            <div class="contenido">
                <main>
        HTML;

        if($incidencias){
            MostrarFormularioBusqueda();
        }
        else{
            echo "<h2>Todavia no hay incidencias</h2>";
        }

        echo <<<HTML
                    <section>
        HTML;
        
        if($incidencias){
            foreach($incidencias as $inci){
                MostrarIncidencia($inci);
            }
        }
        

        echo <<<HTML
                    </section>
            </main>
        HTML;
        MostrarAside();
        echo "</div>";
    }

    function MostrarFormularioBusqueda(){
        echo <<<HTML
            <section class="formBusqueda">
                <h2>Listado de Incidencias</h2>

                <form action="./" method="POST">
                    <h2>Criterios de búsqueda</h2>

                    <div class="ordenar">
                        <h2>Ordenar por:</h2>

                        <div class="opcionesOrdenar">
                            <label><input type="radio" name="ordenar" value="antiguedad"> Antigüedad (primero las más recientes)</label>
                            <label><input type="radio" name="ordenar" value="positivos"> Número de positivos (de más a menos)</label>
                            <label><input type="radio" name="ordenar" value="netos"> Número de positivos netos (de más a menos)</label>
                        </div>
                    </div>

                    <div class="busqueda">
                        <h2>Incidencias que contengan:</h2>

                        <label>Texto de búsqueda: <input type="text" name="buscarTexto"></label>
                        <label>Lugar:<input type="text" name="buscarLugar"></label>
                    </div>

                    <div class="estado">
                        <h2>Estado</h2>

                        <div class="inputsEstado">
                            <label><input type="checkbox" name="estadoBusqueda" value="pendiente"> Pendiente </label>
                            <label><input type="checkbox" name="estadoBusqueda" value="comprobada"> Comprobada </label>
                            <label><input type="checkbox" name="estadoBusqueda" value="tramitada"> Tramitada </label>
                            <label><input type="checkbox" name="estadoBusqueda" value="irresoluble"> Irresoluble </label>
                            <label><input type="checkbox" name="estadoBusqueda" value="resuelta"> Resuelta </label>
                        </div>
                    </div>

                    <div class="opciones">
                        <div class="incidenciasPagina">
                            <label>Incidencias por página</label>

                            <select name="items">
                                <option value="1">1 item</option>
                                <option value="3">3 items</option>
                                <option value="5">5 items</option>
                                <option value="10">10 items</option>
                            </select>
                        </div>

                        <input type="submit" value="Aplicar criterios de búsqueda" name="busqueda">
                    </div>
                </form>
            </section>
        HTML;

        if (isset($_POST['busqueda'])){
            setSession('ordenar', $_POST['ordenar']);
            setSession('textoBusqueda', $_POST['buscarTexto']);
            setSession('lugarBusqueda', $_POST['buscarLugar']);
            setSession('estadoBusqueda', $_POST['estadoBusqueda']);
            setSession('itemsBusqueda', $_POST['items']);
        }
    }

    function MostrarContenidoGestionUsuarios(){
        echo <<<HTML
            <div class="menu">
                <h2 id="gestionUsuario" >Gestion de Usuario</h2>
                <label>Indique la accion a realizar</label>

                <form method="POST">    
                    <div class="opciones" id="mostrarListado">
                        <label for="listado">Listado</label>
                        <input type="submit" name="listado" id="listado">
                        <a href="./aniadirUsuario.php">Añadir nuevo</a>
                    </div>
                </form>
            </div>
        HTML;

        if ($_POST['listado']){
            echo <<<HTML
                <div class="listado">
                    <div class="usuario">
                        <img src="../img/basura.png" alt="fotoPerfil">

                        <div class="infoUsuario">
                            <label>Usuario: <em>Mario Piña Munera</em> Email: <em>mariomario</em></label>
                            <label>Direccion: <em>su casa</em></label>
                            <label>Rol: <em>administrador</em> Estado: <em>Activo</em></label>
                        </div>

                        <div class="botones">
                            <img src="../img/editar.png" alt="editar">
                            <img src="../img/basura.png" alt="borrar">
                        </div>
                    </div>

                    <div class="usuario">
                        <img src="../img/basura.png" alt="fotoPerfil">

                        <div class="infoUsuario">
                            <label>Usuario: <em>Mario Piña Munera</em> Email: <em>mariomario</em></label>
                            <label>Direccion: <em>su casa</em></label>
                            <label>Rol: <em>administrador</em> Estado: <em>Activo</em></label>
                        </div>

                        <div class="botones">
                            <img src="../img/editar.png" alt="editar">
                            <img src="../img/basura.png" alt="borrar">
                        </div>
                    </div>

                    <div class="usuario">
                        <img src="../img/basura.png" alt="fotoPerfil">

                        <div class="infoUsuario">
                            <label>Usuario: <em>Mario Piña Munera</em> Email: <em>mariomario</em></label>
                            <label>Direccion: <em>su casa</em></label>
                            <label>Rol: <em>administrador</em> Estado: <em>Activo</em></label>
                        </div>

                        <div class="botones">
                            <img src="../img/editar.png" alt="editar">
                            <img src="../img/basura.png" alt="borrar">
                        </div>
                    </div>

                    <div class="usuario">
                        <img src="../img/basura.png" alt="fotoPerfil">

                        <div class="infoUsuario">
                            <label>Usuario: <em>Mario Piña Munera</em> Email: <em>mariomario</em></label>
                            <label>Direccion: <em>su casa</em></label>
                            <label>Rol: <em>administrador</em> Estado: <em>Activo</em></label>
                        </div>

                        <div class="botones">
                            <img src="../img/editar.png" alt="editar">
                            <img src="../img/basura.png" alt="borrar">
                        </div>
                    </div>
                </div>
            HTML;
        }
    }

    function MostrarAccesoDenegado(){
        echo "<h2>No tienes permiso para estar aqui</h2>";
    }

    function MostrarContenidoEdicionUsuario($tipoUsuario, $desactivado, $nuevo, $numeroPost, $post, $files){
        $titulo = "Edición de";
        $ruta = "./edicionUsuario.php";

        if ($nuevo == true){
            $titulo = "Nuevo";
            $ruta = "./aniadirUsuario.php";
        }

        if ($nuevo == false and $desactivado != "readonly"){
            $datos = ObtenerDatosUsuario(getSession('currentUser'));

            $foto = base64_encode($datos['foto']);
            $foto_nombre = $foto;
            $nombre = $datos['nombre'];                   
            $apellidos = $datos['apellidos'];
            $email = $datos['email'];
            $passw1 = "";
            $passw2 = "";
            $direccion = $datos['direccion'];
            $telefono = $datos['tlf'];
            $rol = $datos['rol'];
            $estado = $datos['estado'];
        }


        // Sticky        
        if ($desactivado == "readonly"){
            //$foto = base64_encode(file_get_contents($files['photo-selected']['tmp_name']));
            $foto_nombre = $files['photo-selected']['name'];
            $nombre = htmlentities($post['nombre']);
            $apellidos = htmlentities($post['apellidos']);

            $email = htmlentities($post['email']);
            $email = filter_var($email, FILTER_VALIDATE_EMAIL);

            $passw1 = htmlentities($post['passw1']);
            $passw2 = htmlentities($post['passw2']);
            if ($passw1 != $passw2){
                header('Location: ' . $ruta);
            }
            
            $direccion = htmlentities($post['dir']);
            $patron_tlf = "/^\d{9}$/";
            $telefono = htmlentities($post['telf']);
            if(preg_match($patron_tlf, $telefono)) $telefono; // Completar else en caso de que haya error

            $rol = $post['rol'];
            $estado = $post['estado'];
        }

        echo <<<HTML
            <h2>$titulo usuario</h2>
            <form action="$ruta" method="POST" enctype='multipart/form-data'>
                <div class="foto">
        HTML;
                    echo "<img src='data:image/jpg;base64,".$foto."'>";
        echo <<<HTML
                    <div class="nuevo">
                        <label for="seleccionar">Añadir/Cambiar imágen</label>
                        <input type="file" name="photo-selected" id="seleccionar" value=$foto_nombre $desactivado>
                    </div>
                </div>

                <div class="inputs">
                    <div>
                        <label>Nombre:</label>
                        <input type="text" placeholder="Introduzca su nombre" name="nombre" value=$nombre $desactivado>
                    </div>

                    <div>
                        <label>Apellidos:</label>
                        <input type="text" placeholder="Introduzca su/s apellido/s" name="apellidos" value="$apellidos" $desactivado>
                    </div>

                    <div>
                        <label>Email:</label>
                        <input type="email" placeholder="ex@am.ple" name="email" value="$email" $desactivado>
                    </div>

                    <div>
                        <label>Clave:</label>
                        <input type="password" placeholder="Nueva contraseña" name="passw1" value="$passw1" $desactivado>  
                        <input type="password" placeholder="Repita nueva contraseña" name="passw2" value="$passw2" $desactivado> 
                    </div>

                    <div>
                        <label>Dirección:</label>
                        <input type="text" placeholder="Calle falsa, nº1" name="dir" value="$direccion" $desactivado>
                    </div>

                    <div>
                        <label>Telefono:</label>
                        <input type="tel" placeholder="123456789" name="telf" value="$telefono" $desactivado>
                    </div>
                    <input type="hidden" name="numeroPost" value="$numeroPost"/>
        HTML;

        // si es un usuario nuevo o si se esta modificando
        if ($nuevo == true or ($nuevo == false and $tipoUsuario == "administrador")){
            echo <<<HTML
                    <div class="selectores">
                        <label>Rol:</label>
                        <select name="rol" value="$rol" $desactivado>
                            <option value="admin">Administrador</option>
                            <option value="colab">Colaborador</option>
                        </select>
                    
                        <label>Estado:</label>
                        <select name="estado" value="$estado" $desactivado>
                            <option value="activo">Activo</option>
                            <option value="inactivo">Inactivo</option>
                        </select>
                    </div>
            HTML;
        }
        else{
            echo <<<HTML
                    <input type="hidden" name="rol" value="$rol"/>
                    <input type="hidden" name="estado" value="$estado"/>
            HTML;
        }

        $valor = "modificación";
        if ($nuevo == true) $valor = "creación";

        echo <<<HTML
                </div>

                <div class="enviar">
                    <input type="submit" name="changes" id="modificarUsuario" value="Confirmar $valor">
                </div>
            </form>
        HTML;
    }

    function MostrarCambiosExito($nuevo, $post, $files){
        // En teoría no hay que sanearlos ya que vienen del sticky y ahi ya estan saneados
        if ($nuevo) {
            InsertarUsuario($post['email'], $post['nombre'], $post['apellidos'], $post['passw1'], $post['dir'], $post['telf'], $post['rol'], $post['estado'], $post['photo-selected']);
        }
        else{
            print_r($post);
            ActualizarUsuario($post['email'], $post['nombre'], $post['apellidos'], $post['passw1'], $post['dir'], $post['telf'], $post['rol'], $post['estado'], $files['photo-selected']['tmp_name']);
            echo <<<HTML
                <p style="text-align: center; font-weight: bold; font-size: 25px;">Se han modificado los datos del usuario</p>
                <p style="text-align: center; font-size: 15px;">Redirigiendo a página principal...</p>
            HTML;
    
            header('Refresh: 5; URL=./index.php');
        }

    }


    function MostrarLog(){
        $datos = ObtenerDatosLog();

        if ($datos != null){
            echo <<<HTML
                <section class="log">
                    <h2>Eventos del sistema</h2>

                    <div class="eventos">
            HTML;

            foreach ($datos as $registro){
                echo <<<HTML
                    <div class="evento">
                        <label>{$registro[1]}</label>
                        <label>{$registro[2]}</label>
                    </div>
                HTML;
            }

            echo <<<HTML
                    </div>
                </section>
            HTML;
        }
        
        else{
            echo <<<HTML
                <h2 id="sinDatos">No hay registros</h2>
            HTML;
        }
    }

    function MostrarAniadirIncidencia($editar){
        if ($editar == false)
            echo "<h2>Nueva incidencia</h2>";

        echo <<<HTML
            <h3>Datos principales:</h3>
                
            <div class="nueva-incidencia">
                <form action="./" method="POST">
                    <div>
                        <label>Titulo:</label>
                        <input type="text" name="titulo" required>
                    </div>

                    <div class="desc">
                        <label>Descripción:</label>
                        <textarea name="descripcion" required></textarea>
                    </div>

                    <div>
                        <label>Lugar:</label>
                        <input type="text" name="lugar" required>
                    </div>

                    <div>
                        <label>Palabras clave:</label>
                        <input type="text" name="palClave" required>
                    </div>

        HTML;

        if ($editar == true)
            echo "<input type=\"submit\" name=\"editarNueva\" value=\"Modificar datos\">";
        else
            echo "<input type=\"submit\" name=\"enviarNueva\" value=\"Enviar\">";

        echo <<<HTML
                </form>
            </div>
        HTML;

        if (isset($_POST['enviarNueva'])){
            $titulo = htmlentities($_POST['titulo']);
            $desc = htmlentities($_POST['descripcion']);
            $lugar = htmlentities($_POST['lugar']);
            $palClave = htmlentities($_POST['palClave']);

            InsertarIncidencia($lugar, $titulo, $palClave, "pendiente", $desc, 0, 0);
        }
    }

    function MostrarEditarIncidencia($post, $files){
        echo <<<HTML
            <h2>Editar incidencia</h2>

            <div class="estado">
                <h3>Estado de la incidencia:</h3>

                <form action="" method="POST">
                    <input type="radio" name="estado" value="pendiente"><label>Pendiente</label>
                    <input type="radio" name="estado" value="Comprobada"><label>Comprobada</label>
                    <input type="radio" name="estado" value="Tramitada"><label>Tramitada</label>
                    <input type="radio" name="estado" value="Irresoluble"><label>Irresoluble</label>
                    <input type="radio" name="estado" value="Resuelta"><label>Resuelta</label>

                    <div class="envio"><input type="submit" value="Modificar estado"></div>
                </form> 
            </div>

        HTML;

        MostrarAniadirIncidencia(true);

        echo <<<HTML
            <div class="imagenes">
                <h3>Fotografías adjuntas:</h3>
                <form action="" method="POST" enctype="multipart/form-data">
                    <img src="../img/comment.png">
                    <img src="../img/comment.png">
                    <img src="../img/comment.png">

                    <div class="botones">
                        <label for="examinar">+</label>
                        <input type="file" id="examinar" value="Seleccionar archivo">

                        <input type="submit" name="borrar" value="Borrar todo">
                        <input type="file" name="fotos[]" value="Añadir fotografías" multiple>
                    </div>
                </form>
            </div>
        HTML;

        if (isset($_POST['editarNueva'])){
            $titulo = htmlentities($post['titulo']);
            $desc = htmlentities($post['descripcion']);
            $lugar = htmlentities($post['lugar']);
            $palClave = htmlentities($post['palClave']);
            $estado = $post['estado'];
            $fotos = $files['fotos'];

            $id = InsertarIncidencia($lugar, $titulo, $palClave, $estado, $desc, 0, 0);
            InsertarImagenesIncidencia($id, $fotos);
        }
    }

    function MostrarComentario($com){
        //Obtener todo el contenido del comentario
        $comentario = ObtenerComentario($com);
        $nombreUsuario = ObtenerUsuarioComentario($com);
        $nombreUsuario = $nombreUsuario["nombre"] . " " . $nombreUsuario["apellidos"];
        echo <<<HTML
                    <div class="comentario">
                        <div class="infoComentario">
                            <label>$nombreUsuario</label>
                            <label>{$comentario["fecha"]}</label>
                        </div>
        
                        <p>{$comentario["descripcion"]}</p>
                    </div>
        HTML;
    }

    function MostrarContenidoMisIncidencias(){
        $incidencias = ObtenerTodasIncidencias();

        if ($incidencias != null){
            foreach($incidencias as $inci){
                if (getSession('actualUser') == ObtenerUsuarioPublica($inci))
                    MostrarIncidencia($inci);
            }
        }
        else{
            echo <<<HTML
                <h2 id="sinDatos">No hay incidencias</h2>
            HTML;
        }
    }

?>