
<?php

    // Inclusión de las funciones que modifican la base de datos
    require_once 'funcionesBD.php';

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    /************************************************************************************************************** */
    // Variables globales

    // Guarda el usuario actual
    $actualUser = null;

    // Guarda el tipo del usuario actual
    $tipoCliente = "anonimo";

    // Guarda si estamos logeados
    $logged = false;

    /************************************************************************************************************** */
    // Guardado de variables de sesión
    function setSession($nombreVariable, $valor){
        $_SESSION[$nombreVariable] = $valor;
    }

    // Obtención de variables de sesión
    function getSession($nombreVariable){
        if(isset($_SESSION[$nombreVariable])){
            return $_SESSION[$nombreVariable];  
        }
        else return null;
    }

    /************************************************************************************************************** */
    // Generación de HTML inicial e inclusión de archivos CSS
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

    // Generación de HTML final
    function HTMLFin(){
        echo <<<HTML
            </body>
            </html>
        HTML;
    }

    // Generación del Header
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

    // Generación del Footer
    function MostrarFooter(){
        echo <<<HTML
        <footer>
            <p>Creado por <a href="https://www.linkedin.com/in/ra%C3%BAl-torrente-l%C3%B3pez-6b9760250/">Raúl Torrente López</a>
               y <a href="https://www.linkedin.com/in/mario-pi%C3%B1a-munera-465116225/">Mario Piña Munera</a></p>

            <p><a href="../doc/documentacion.pdf">Documentación</a></p>
        </footer>
        HTML;
    }

    // Generación de la barra de navegación
    function MostrarNav($tipoUsuario){
        echo <<<HTML
            <nav>
                <ul>
        HTML;

        // Dependiendo del tipo de usuario se muestra una información u otra
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
                    <li><a href="./gestionBD.php">Gestión de BBDD</a></li>
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

    // Mostrar una incidencia determinada por el id
    function MostrarIncidencia($inci, $post){
        // Obtener la información
        $datos = ObtenerDatosIncidencia($inci);

        // Obtener el usuario que la ha publicado
        $usuarioPublica = ObtenerUsuarioPublica($inci);
        $nombreUsuario = $usuarioPublica["nombre"] . " " . $usuarioPublica["apellidos"];
        $autor = $usuarioPublica["email"];

        // Obtener los comentarios
        $comentarios = ObtenerTodosComentarios($inci);

        // Obtener las imágenes
        $fotos = ObtenerFotosIncidencia($inci);

        // Mostrar datos
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

                    <p>{$datos["descripcion"]}</p>

                    <div class="fotos">
        HTML;
                        if($fotos){
                            foreach($fotos as $foto){
                                $imagen = base64_encode($foto);
                                echo "<img src='data:image/jpg;base64," . $imagen . "'>";
                            }
                        }
                        else echo "<h2>Todavia no hay fotos</h2>";
        echo <<<HTML
                    </div>

                </div>

                <div class="seccionComentarios">
        HTML;

        // Mostrar comentarios
        if($comentarios){
            foreach($comentarios as $c){
                MostrarComentario($c);
            }
        }
        else{
            echo "<h2>Todavia no hay comentarios</h2>";
        }

        // Acciones especificas para cada incidencia
        $plus = "plus" . $inci;
        $minus = "minus" . $inci;
        $comment = "comment" . $inci;
        $eliminar = "eliminar" . $inci;

        // Mostrar formulario para añadir un comentario
        if (isset($post[$comment])){
            comentarIncidencia($inci);
        } 
            
        // Mostrar opciones de acción
        echo <<<HTML

                </div>

                <div class="iconos">
                    <form action="./index.php" method="post">
                        <label for="$plus"><img src="../img/plus.png" alt="+"></label>
                        <input type="submit" name=$plus id="$plus">
                        
                        <label for="$minus"><img src="../img/minus.png" alt="-"></label>
                        <input type="submit" name="$minus" id="$minus">

                        <label for="$comment"><img src="../img/comment.png" alt="comentar"></label>
                        <input type="submit" name="$comment" id="$comment">
        HTML;

        // Mostrar opciones de accion asociadas al administrador
        if((getSession("tipoCliente") == "administrador") or (getSession("currentUser") == $autor)){
            echo <<<HTML
                        <a href="./editarIncidencia.php?src=$inci"><img src="../img/editar.png"></a>
                
                        <label for="$eliminar"><img src="../img/basura.png" alt="eliminar"></label>
                        <input type="submit" name="$eliminar" id="$eliminar">
                    </form>
            HTML;
        }

        echo <<<HTML
                </div>
            </div>
        HTML;

        $nuevoCom = "nuevoComentario" . $inci;

        // Actuar según la acción seleccionada
        
        if (isset($post[$plus])){
            votoPositivo($inci);
        }

        if (isset($post[$minus])){
            votoNegativo($inci);
        }

        if (isset($post[$nuevoCom])){
            nuevoComentario($inci, $post['textoComentario']);
        }

        if (isset($post[$eliminar])){
            eliminarIncidencia($inci);
        }
    }

    // Añadir un comentario a una incidencia
    function comentarIncidencia($inci){
        // Acción especifica para la incidencia concreta
        $nuevoCom = "nuevoComentario" . $inci;

        echo <<<HTML
            <div class="nuevoComentario">
                <form action="./index.php" method="POST">
                    <textarea name="textoComentario"></textarea>
                    <input type="submit" name="$nuevoCom" value="Enviar comentario">
                </form>
            </div>
        HTML;
    }

    // Mostrar la barra lateral
    function MostrarAside(){
        $correcto = false;
        $datos = null;
        $error = false;
        $errorText = "Error en email o contraseña. Si no tienes cuenta solicita una a un administrador";

        // Desloguear
        if (isset($_POST['logout'])){
            $usuario = getSession('currentUser');
            LogOut($usuario);
            GuardarLog("El usuario $usuario ha cerrado sesion");
            session_unset();
        }

        // Obtener datos del usuario logeado
        else if(getSession("logged")){
            $datos = ObtenerDatosUsuario(getSession("currentUser"));
        }

        // Comprobar intento de logeo
        else if (isset($_POST['login'])){
            //Validar mail
            $email = htmlentities($_POST['email']);
            $email = filter_var($email, FILTER_VALIDATE_EMAIL);
            if(!$email) $error = true;

            // Comprobar contraseña
            if(!$error){
                $contrasena = htmlentities($_POST['clave']);
                $correcto = ComprobarUsuario($email, $contrasena);
    
                // Establecer datos
                if($correcto){
                    setSession('currentUser', $email);
                    setSession('logged', true);

                    $datos = ObtenerDatosUsuario($email);
                    setSession("tipoCliente", $datos["rol"]);
                    LogIn($datos["email"]);
                }

                else $error = true;
            }
        }

        else session_unset(); // Mantener sesion sin iniciar

        // Mostrar datos del usuario
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

            echo "<img style=\"width: 100%; margin-top: 10px;\" src='data:image/jpg;base64," . $foto . "'>";

            echo <<<HTML
                            <div class="envios">
                                <form action="./edicionUsuario.php" method="POST"><input type="submit" value="Editar"></form> 
                                <form action="./" method="POST"><input type="submit" name="logout" value="Logout"></form>
                            </div>
                        </div>
            HTML;
        }

        // Mostrar formulario de inicio de sesión
        else{
            echo <<<HTML
                    <aside>
                        <div class="login-aside">
                            <form action="" method="POST">
                                <p>Email:</p>
                                <input type="email" name="email" style="width: 100%;">

                                <p>Clave:</p>
                                <input type="password" name="clave" style="width: 100%;">

                                <input type="submit" name="login" value="Log In">
                            </form>
            HTML;

            // Mostrar error si algo no funciono correctamente
            if($error) echo "<p style=\"color: red;\">$errorText</p>";

            echo <<<HTML
                        </div>
            HTML;
        }

        // Variables del ranking
        $top1_quejas = Ranking(true, 1);
        $top2_quejas = Ranking(true, 2);
        $top3_quejas = Ranking(true, 3);

        $top1_opinion = Ranking(false, 1);
        $top2_opinion = Ranking(false, 2);
        $top3_opinion = Ranking(false, 3);

        // Mostrar ambas tablas
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

    // Página de incidencias
    function MostrarContenidoIncidencias($post){
        $incidencias = ObtenerTodasIncidencias($post);
        echo <<<HTML
            <div class="contenido">
                <main>
        HTML;

        // Filtro de búsqueda
        if ($incidencias or isset($post['busqueda'])){
            MostrarFormularioBusqueda($post);

            if ($incidencias == null) 
                echo "<h2>Sin resultados conincidentes</h2>";
        }
        else echo "<h2>Todavia no hay incidencias</h2>";

        // Filtrar elementos a mostrar
        if (isset($post["items"])) $max = $post["items"];
        else $max = INF;
        $cont = 0;
        
        // Mostrar cada incidencia
        echo "<section>";

        if ($incidencias){
            foreach($incidencias as $inci){
                if ($cont < $max){
                    MostrarIncidencia($inci, $post);
                    $cont++;
                }
            }
        }
        
        echo <<<HTML
                    </section>
            </main>
        HTML;

        // Mostrar barra lateral
        MostrarAside();
        echo "</div>";
    }

    // Mostrar filtro de busqueda de incidencias
    function MostrarFormularioBusqueda($post){
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
                            <label><input type="checkbox" name="estadoBusqueda[]" value="pendiente"> Pendiente </label>
                            <label><input type="checkbox" name="estadoBusqueda[]" value="comprobada"> Comprobada </label>
                            <label><input type="checkbox" name="estadoBusqueda[]" value="tramitada"> Tramitada </label>
                            <label><input type="checkbox" name="estadoBusqueda[]" value="irresoluble"> Irresoluble </label>
                            <label><input type="checkbox" name="estadoBusqueda[]" value="resuelta"> Resuelta </label>
                        </div>
                    </div>

                    <div class="opciones">
                        <div class="incidenciasPagina">
                            <label>Mostrar:</label>

                            <select name="items">
                                <option value="todo">Todas las incidencias</option>
                                <option value="5">5 incidencias</option>
                                <option value="3">3 incidencias</option>
                                <option value="1">1 incidencia</option>
                            </select>
                        </div>

                        <input type="submit" value="Aplicar criterios de búsqueda" name="busqueda">
                    </div>
                </form>
            </section>
        HTML;
    }

    // Gestión de los usuarios registrados
    function MostrarContenidoGestionUsuarios($post, $get){
        echo <<<HTML
            <div class="menu">
                <h2 id="gestionUsuario">Gestion de Usuario</h2>
                <label>Indique la accion a realizar</label>

                <form method="POST" action="./gestionUsuarios.php">    
                    <div class="opciones" id="mostrarListado">
                        <label for="listado">Listado</label>
                        <input type="submit" name="listado" id="listado">
                        <a href="./aniadirUsuario.php">Añadir nuevo</a>
                    </div>
                </form>
            </div>
        HTML;

        // Listar los usuarios registrados
        if (isset($_POST['listado'])){
            echo <<<HTML
                <div class="listado">
                    
            HTML;

            $usuarios = MostrarUsuariosRegistrados();

            foreach ($usuarios as $usuario){
                $foto = $usuario[8];
                $imagen = base64_encode($foto);
                $delete = "delete-" . $usuario[0];
                
                echo <<<HTML
                        <div class="usuario">
                            <div class="imagenPerfil"><img src='data:image/jpg;base64,$imagen' alt="foto perfil"></div>

                            <div class="infoUsuario">
                                <label>Usuario: <em>{$usuario[1]} {$usuario[2]}</em> Email: <em>{$usuario[0]}</em></label>
                                <label>Direccion: <em>{$usuario[4]}</em></label>
                                <label>Rol: <em>{$usuario[6]}</em> Estado: <em>{$usuario[7]}</em></label>
                            </div>
                            
                            <div class="botones">
                                <form action="./edicionUsuario.php?src=$usuario[0]" method="POST">
                                    <label for="edit"><img src="../img/editar.png" alt="editar"></label>
                                    <input type="submit" name="edit" id="edit">
                                </form>

                                <form action="" method="GET">
                                    <label for="$delete"><img src="../img/basura.png" alt="borrar"></label>
                                    <input type="submit" name=$delete id="$delete">
                                </form>
                            </div>
                        </div>
                HTML;
            }

            echo "</div>";
        }

        // Obtener usuario a eliminar
        if ($get != NULL){
            $variables = reset($get); // primer valor de $_GET
            $primera = array_search($variables, $_GET); // nombre de la variable
            $email = explode("-", $primera); // separar usuario de acción
            $email = str_replace("_", ".", $email[1]); // corregir codificación de la url
            
            borrarUsuario($email);
        }
    }

    // Mostrar error de aceso
    function MostrarAccesoDenegado(){
        echo "<h2>No tienes permiso para estar aqui</h2>";
    }

    // Edición o adición de un usuario
    function MostrarContenidoEdicionUsuario($tipoUsuario, $desactivado, $nuevo, $numeroPost, $post, $files, $get){
        // Elección de información según se edite o se añada
        $titulo = "Edición de";
        $ruta = "./edicionUsuario.php";
        $valor = "modificación"; // Botón de envio
        $tipoImagen = ""; // Etiqueta añadir foto

        if ($nuevo == true){
            $titulo = "Nuevo";
            $ruta = "./aniadirUsuario.php";
            $valor = "creación";

            $foto = null;
            $nombre = null;            
            $apellidos = null;
            $email = null;
            $passw1 = null;
            $passw2 = $passw1;
            $direccion = null;
            $telefono = null;
            $rol = null;
            $estado = null;
        }

        else{
            // Obtener datos del usuario a editar
            if ($desactivado != "readonly"){
                if ($get != null) $datos = ObtenerDatosUsuario($get['src']);    // Administrador editando cualquier usuario
                else $datos = ObtenerDatosUsuario(getSession('currentUser'));   // Editar un perfil propio

                $foto = base64_encode($datos['foto']);
                $nombre = $datos['nombre'];                   
                $apellidos = $datos['apellidos'];
                $email = $datos['email'];
                $passw1 = "";
                $passw2 = $passw1;
                $direccion = $datos['direccion'];
                $telefono = $datos['tlf'];
                $rol = $datos['rol'];
                $estado = $datos['estado'];
            }
        }

        // Mantener datos para confirmación (sticky)   
        if ($desactivado == "readonly"){
            $foto = file_get_contents($files['photo-selected']['tmp_name']);
            setSession('fotoPerfil', $foto);
            $foto = base64_encode($foto);

            $nombre = htmlentities($post['nombre']);
            $apellidos = htmlentities($post['apellidos']);

            $email = htmlentities($post['email']);
            $email = filter_var($email, FILTER_VALIDATE_EMAIL);
            if (!$email){
                header('Location: ' . $ruta);
            }
            
            // Si la contraseña no coincide se reinicia el formulario
            $passw1 = htmlentities($post['passw1']);
            $passw2 = htmlentities($post['passw2']);
            if ($passw1 != $passw2){
                header('Location: ' . $ruta);
            }
            
            $direccion = htmlentities($post['dir']);
            $patron_tlf = "/^\d{9}$/";
            $telefono = htmlentities($post['telf']);
            if(!preg_match($patron_tlf, $telefono)){
                header('Location: ' . $ruta);
            }
            
            $rol = $post['rol'];
            $estado = $post['estado'];
            
            $tipoImagen = "oculto";
        }
        
        // Mostrar formulario
        echo <<<HTML
            <h2>$titulo usuario</h2>
            <form action="$ruta" method="POST" enctype='multipart/form-data'>
                <div class="foto">
        HTML;

        // No mostrar imágen si se crea un usuario por primera vez
        if ((!$nuevo) or ($nuevo and $desactivado == "readonly"))
            echo "<img src='data:image/jpg;base64," . $foto . "'>";

        echo <<<HTML
                    <div class="nuevo">
                        <label for="seleccionar" class=$tipoImagen >Añadir/Cambiar imágen</label>
                        <input type="file" name="photo-selected" id="seleccionar" $desactivado>
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

        // Si es un usuario nuevo o si se esta modificando por el administrador
        if ($nuevo or (!$nuevo and getSession('tipoCliente') == "administrador")){
            echo <<<HTML
                    <div class="selectores">
                        <label>Rol:</label>
                        <select name="rol" value="$rol" $desactivado>
                            <option value="administrador">Administrador</option>
                            <option value="colaborador">Colaborador</option>
                        </select>
                    
                        <label>Estado:</label>
                        <select name="estado" value="$estado" $desactivado>
                            <option value="activo">Activo</option>
                            <option value="inactivo">Inactivo</option>
                        </select>
                    </div>
            HTML;
        }

        // Si no, enviarlo en oculto
        else{
            echo <<<HTML
                    <input type="hidden" name="rol" value="$rol"/>
                    <input type="hidden" name="estado" value="$estado"/>
            HTML;
        }

        // Boton de envio
        echo <<<HTML
                </div>

                <div class="enviar">
                    <input type="submit" name="changes" id="modificarUsuario" value="Confirmar $valor">
                </div>
            </form>
        HTML;
    }

    // Realizar acciones de usuario y mostrar mensaje
    function MostrarCambiosExito($nuevo, $post, $files){
        if ($nuevo) {
            InsertarUsuario($post['email'], $post['nombre'], $post['apellidos'], $post['passw1'], $post['dir'], $post['telf'], "colaborador", $post['estado'], getSession('fotoPerfil'));
            echo <<<HTML
                <p style="text-align: center; font-weight: bold; font-size: 25px;">Se ha creado el usuario</p>
                <p style="text-align: center; font-size: 15px;">Redirigiendo a página principal...</p>
            HTML;
        }

        else{
            ActualizarUsuario($post['email'], $post['nombre'], $post['apellidos'], $post['passw1'], $post['dir'], $post['telf'], $post['rol'], $post['estado'], getSession('fotoPerfil'));
            echo <<<HTML
                <p style="text-align: center; font-weight: bold; font-size: 25px;">Se han modificado los datos del usuario</p>
                <p style="text-align: center; font-size: 15px;">Redirigiendo a página principal...</p>
            HTML;
        }

        header('Refresh: 5; URL=./index.php');
    }

    // Mostrar registro
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

    // Añadir o editar una incidencia
    function MostrarAniadirIncidencia($editar, $post, $datos){
        if ($editar == false){
            echo "<h2>Nueva incidencia</h2>";

            $titulo = "";
            $desc = "";
            $lugar = "";
            $palCla = "";
        }

        // Mostrar datos actuales
        else{
            $titulo = $datos['titulo'];
            $desc = $datos['descripcion'];
            $lugar = $datos['lugar'];
            $palCla = $datos['palClave'];
        }

        echo <<<HTML
            <h3>Datos principales:</h3>
                
            <div class="nueva-incidencia">
                <form action="" method="POST">
                    <div>
                        <label>Titulo:</label>
                        <input type="text" name="titulo" value = "$titulo" required>
                    </div>

                    <div class="desc">
                        <label>Descripción:</label>
                        <textarea name="descripcion" value = "$desc" required></textarea>
                    </div>

                    <div>
                        <label>Lugar:</label>
                        <input type="text" name="lugar" value = "$lugar" required>
                    </div>

                    <div>
                        <label>Palabras clave:</label>
                        <input type="text" name="palClave" value = "$palCla" required>
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

        // Filtrar datos y crear entrada en la bd
        if (isset($post['enviarNueva'])){
            $titulo = htmlentities($post['titulo']);
            $desc = htmlentities($post['descripcion']);
            $lugar = htmlentities($post['lugar']);
            $palClave = htmlentities($post['palClave']);

            InsertarIncidencia($lugar, $titulo, $palClave, "pendiente", $desc, 0, 0);
            header('Refresh: 0; URL=./index.php');
        }
    }

    // Editar incidencia
    function MostrarEditarIncidencia($post, $files, $id){
        echo "<h2>Editar incidencia</h2>";

        // Filtrar datos por permisos
        if (getSession("tipoCliente") == "administrador"){
            echo <<<HTML
                <div class="estado">
                    <h3>Estado de la incidencia:</h3>
    
                    <form action="" method="POST">
                        <input type="radio" name="estado" value="pendiente"><label>Pendiente</label>
                        <input type="radio" name="estado" value="comprobada"><label>Comprobada</label>
                        <input type="radio" name="estado" value="tramitada"><label>Tramitada</label>
                        <input type="radio" name="estado" value="irresoluble"><label>Irresoluble</label>
                        <input type="radio" name="estado" value="resuelta"><label>Resuelta</label>
    
                        <div class="envio">
                            <input type="submit" name="state" value="Modificar estado">
                        </div>
                    </form> 
                </div>
    
            HTML;
        }


        // Mostrar contenido de edicion
        $datos = ObtenerDatosIncidencia($id);
        MostrarAniadirIncidencia(true, $post, $datos);

        // Adición de fotografías
        echo <<<HTML
            <div class="imagenes">
                <h3>Fotografías adjuntas:</h3>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="botonesIncidencia">
                        <input type="file" id="examinar" name="fotos[]" value="Seleccionar archivo" multiple>
                        <input type="submit" name="sendPics" value="Subir fotos">
                    </div>
                </form>
            </div>
        HTML;

        // Realizar decisiones y filtrar datos
        if (isset($post['state'])){
            $estado = $post['estado'];
            print($estado);
            EditarEstadoIncidencia($estado, $id);
        } 

        if (isset($post['editarNueva'])){
            $titulo = htmlentities($post['titulo']);
            $desc = htmlentities($post['descripcion']);
            $lugar = htmlentities($post['lugar']);
            $palClave = htmlentities($post['palClave']);

            EditarIncidencia($id, $lugar, $titulo, $palClave, $desc);
        }
        
        if (isset($post['sendPics'])){
            // Iterar sobre las diferentes fotos
            foreach($files['fotos']['tmp_name'] as $img){
                $foto = file_get_contents($img);
                $res = InsertarImagenesIncidencia($id, $foto);
            }

            if ($res){
                echo "<h3 style=\"text-align: center;\">Imágenes añadidas</h3>";
            }
        }
    }

    // Mostrar comentarios
    function MostrarComentario($com){
        // Obtener todo el contenido del comentario
        $comentario = ObtenerComentario($com);

        // Obtener autor
        $nombreUsuario = ObtenerUsuarioComentario($comentario['id']);

        if ($nombreUsuario)
            $nombreUsuario = $nombreUsuario['nombre'] . " " . $nombreUsuario['apellidos'];
        else
            $nombreUsuario = "Anónimo";

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

    // Mostrar incidencias pertenecientes a un mismo usuario
    function MostrarContenidoMisIncidencias($post){
        $incidencias = ObtenerTodasIncidencias($post);

        if ($incidencias != null){
            $cont = 0;

            foreach($incidencias as $inci){
                if (getSession('currentUser') == ObtenerUsuarioPublica($inci)['email']){
                    MostrarIncidencia($inci, $post);
                    $cont++;
                }
            }

            if ($cont == 0){
                echo "<h2 id=\"sinDatos\">No hay incidencias</h2>";
            }
        }
    }

    // Mostrar página de gestión de la BD
    function MostrarGestionBD(){
        echo <<<HTML
            <div style="display: flex; justify-content: center; margin-bottom: -1rem;">
                <form action="gestionBD.php" method="POST">
                    <input type="submit" value="Crear copia de seguridad" name="copia">
                </form>
                
                <form action="../backupBD.sql" method="post">
                    <input type="submit" value="Descargar BD vacía" formtarget="_blank" formaction="../backupBD.sql" download="copia.sql">
                </form>

            </div>
        HTML;
    }
?>