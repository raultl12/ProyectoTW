
<?php

    require_once 'funcionesBD.php';

    /************************************************************************************************************** */
    // Codigo de guardado y obtencion de sesion
    function setSession($nombreVariable, $valor){
        $_SESSION[$nombreVariable] = $valor;
    }

    function getSession($nombreVariable){
        return $_SESSION[$nombreVariable];
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
            <p>
                Creado por <a href="https://www.linkedin.com/in/ra%C3%BAl-torrente-l%C3%B3pez-6b9760250/">Raúl Torrente López</a>
                y <a href="https://www.linkedin.com/in/mario-pi%C3%B1a-munera-465116225/">Mario Piña Munera</a>
            </p>
        </footer>
        HTML;
    }

    function MostrarNav($tipoUsuario){
        echo <<<HTML
            <nav>
                <ul>
        HTML;

        switch($tipoUsuario){
            case "miembro":
                echo <<<HTML
                    <li><a href="../php/index.php">Ver incidencias</a></li>
                    <li><a href="">Nueva incidencia</a></li>
                    <li><a href="">Mis incidencias</a></li>
                HTML;
                break;

            case "administrador":
                echo <<<HTML
                    <li><a href="../php/index.php">Ver incidencias</a></li>
                    <li><a href="">Nueva incidencia</a></li>
                    <li><a href="">Mis incidencias</a></li>
                    <li><a href="../php/gestionUsuarios.php">Gestión de usuarios</a></li>
                    <li><a href="../php/log.php">Ver log</a></li>
                    <li><a href="">Gestión de BBDD</a></li>
                HTML;
                break;

            default:
                echo "<li><a href=\"../php/index.php\">Ver incidencias</a></li>";
                break;

            
        }

        echo <<<HTML
                </ul>
            </nav>
        HTML;
    }

    function MostrarIncidencia(){
        echo <<<HTML
            <div class="incidencia">
                <h2>Titulo Incidencia</h2>

                <div class="detalles">
                    <div class="infoGeneral">
                        <label>Lugar: <em>Granada</em></label>
                        <label>Fecha: <em>25-05-04</em></label>
                        <label>Creador por: <em>Cristina</em></label>
                        <label>Palabras clave: <em>Titulo, incidencia</em></label>
                        <label>Estado: <em>Pendiente</em></label>
                        <label>Valoraciones: <em>Pos: 15 Neg: 41</em></label>
                    </div>

                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt sequi laudantium molestias quas ab, voluptatem aperiam? Corporis quidem, illo excepturi harum consequuntur fugiat cupiditate. Error vitae mollitia consequatur eum aut?
                    </p>

                    <div class="fotos">
                        <img src="../img/basura.png" alt="">
                        <img src="../img/editar.png" alt="">
                        <img src="../img/megafono.png" alt="">
                    </div>

                </div>

                <div class="seccionComentarios">
                    <div class="comentario">
                        <div class="infoComentario">
                            <label>Usuario</label>
                            <label>2023-05-69 16:69:69</label>
                        </div>
        
                        <p>
                            Este es el texto del comentario
                            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Ipsum ducimus ea consequatur velit vitae et provident odit corporis ex. Sed ea ex vitae magni maxime, a magnam et adipisci eligendi.
                        </p>
                    </div>

                    <div class="comentario">
                        <div class="infoComentario">
                            <label>Usuario</label>
                            <label>2023-05-69 16:69:69</label>
                        </div>
        
                        <p>
                            Este es el texto del comentario
                            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Ipsum ducimus ea consequatur velit vitae et provident odit corporis ex. Sed ea ex vitae magni maxime, a magnam et adipisci eligendi.
                        </p>
                    </div>
                </div>

                <div class="iconos">
                    <a href=""><img src="../img/plus.png" alt=""></a>
                    <a href=""><img src="../img/minus.png" alt=""></a>
                    <a href=""><img src="../img/comment.png" alt=""></a>
                    <a href=""><img src="../img/editar.png" alt=""></a>
                    <a href=""><img src="../img/basura.png" alt=""></a>
                </div>
            </div>
        HTML;
    }

    function MostrarAside(){
        global $logged;  // solo es pa que no de error

        if ($logged){
            echo <<<HTML
                    <aside>
                        <div class="usuario-aside">
                            <p>Nombre</p>
                            <p>Rol</p>
                            
                            <img src="../img/plus.png" alt="Foto usuario">
                            
                            <div class="envios">
                                <form action="./edicionUsuario.php" method="POST"><input type="submit" value="Editar"></form>
                                <form action="" method="POST"><input type="submit" value="Logout"></form>
                            </div>
                        </div>
            HTML;
        }

        else{
            echo <<<HTML
                    <aside>
                        <div class="login-aside">
                            <p>Email:</p>
                            <input type="email">

                            <p>Clave:</p>
                            <input type="password">

                            <input type="submit" value="LogIn">
                        </div>
            HTML;
        }

        echo <<<HTML

                    <div class="rankings">
                        <div class="quejas">
                            <h3>Top quejicas</h3>

                            <ol>
                                <li>(quejas) Tim Berners Lee</li>
                                <li>(quejas) Lucía Ansino Ariza</li>
                                <li>(quejas) Mario Guisado García</li>
                            </ol>
                        </div>

                        <div class="opiniones">
                            <h3>Top opinionistas</h3>

                            <ol>
                                <li>(opiniones) Tim Berners Lee</li>
                                <li>(opiniones) Lucía Ansino Ariza</li>
                                <li>(opiniones) Mario Guisado García</li>
                            </ol>
                        </div>
                    </div>
                </aside>
        HTML;
    }

    function MostrarContenidoIncidencias(){
        echo <<<HTML
            <div class="contenido">
                <main>
        HTML;

        MostrarFormularioBusqueda();

        echo <<<HTML
                    <section>
        HTML;
        
        MostrarIncidencia();
        MostrarIncidencia();
        MostrarIncidencia();
        

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
                <form action="" method="">
                    <h2>Criterios de búsqueda</h2>

                    <div class="ordenar">
                        <h2>Ordenar por:</h2>

                        <div class="opcionesOrdenar">
                            <label><input type="radio" name="ordenar"> Antigüedad (primero las más recientes)</label>
                            <label><input type="radio" name="ordenar"> Número de positivos (de más a menos)</label>
                            <label><input type="radio" name="ordenar"> Número de positivos netos (de más a menos)</label>
                        </div>
                    </div>

                    <div class="busqueda">
                        <h2>Incidencias que contengan:</h2>

                        <label>Texto de búsqueda: <input type="text" name=""></label>
                        

                        <label>Lugar:<input type="text" name=""></label>
                        
                    </div>

                    <div class="estado">
                        <h2>Estado</h2>

                        <div class="inputsEstado">
                            <label><input type="checkbox"> Pendiente </label>
                            <label><input type="checkbox"> Comprobada </label>
                            <label><input type="checkbox"> Tramitada </label>
                            <label><input type="checkbox"> Irresoluble </label>
                            <label><input type="checkbox"> Resuelta </label>
                        </div>
                    </div>

                    <div class="opciones">
                        <div class="incidenciasPagina">
                            <label>Incidencias por página</label>
                            <select name="">
                                <option value="1">1 item</option>
                                <option value="3">3 items</option>
                                <option value="5">5 items</option>
                                <option value="10">10 items</option>
                            </select>
                        </div>
                        <input type="submit" value="Aplicar criterios de búsqueda">

                    </div>
                </form>
            </section>
        HTML;
    }

    function MostrarContenidoGestionUsuarios(){
        echo <<<HTML
            <div class="menu">
                <h2>Gestion de Usuario</h2>
                <label>Indique la accion a realizar</label>

                <div class="opciones">
                    <a href="">Listado</a>
                    <a href="">Añadir nuevo</a>
                </div>
            </div>

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

    function MostrarAccesoDenegado(){
        echo "<h2>No tienes permiso para estar aqui</h2>";
    }

    function MostrarContenidoEdicionUsuario($tipoUsuario, $desactivado){
        echo <<<HTML
            <h2>Edición de usuario</h2>

            <form action="" method="POST">
                <div class="foto">
                    <label>Foto: </label>
                    <img src="../img/basura.png" alt="Imagen de ejemplo">

                    <div class="nuevo">
                        <input type="submit" name="photo-selected" value="Seleccionar archivo" $desactivado>
                        <label>Archivo.img</label>
                    </div>
                </div>

                <div class="inputs">
                    <div>
                        <label>Nombre:</label>
                        <input type="text" placeholder="Introduzca su nombre" name="nombre" $desactivado>
                    </div>

                    <div>
                        <label>Apellidos:</label>
                        <input type="text" placeholder="Introduzca su/s apellido/s" name="apellidos" $desactivado>
                    </div>

                    <div>
                        <label>Email:</label>
                        <input type="email" placeholder="ex@am.ple" name="email" $desactivado>
                    </div>

                    <div>
                        <label>Clave:</label>
                        <input type="password" placeholder="Nueva contraseña" name="passw1" $desactivado>  
                        <input type="password" placeholder="Repita nueva contraseña" name="passw2" $desactivado> 
                    </div>

                    <div>
                        <label>Dirección:</label>
                        <input type="text" placeholder="Calle falsa, nº1" name="dir" $desactivado>
                    </div>

                    <div>
                        <label>Telefono:</label>
                        <input type="tel" placeholder="123456789" name="telf" $desactivado>
                    </div>
        HTML;

        if ($tipoUsuario == "administrador"){
            echo <<<HTML
                    <div class="selectores">
                        <label>Rol:</label>
                        <select name="rol" $desactivado>
                            <option value="admin">Administrador</option>
                            <option value="colab">Colaborador</option>
                        </select>
                    
                        <label>Estado:</label>
                        <select name="estado" $desactivado>
                            <option value="activo">Activo</option>
                            <option value="inactivo">Inactivo</option>
                        </select>
                    </div>
            HTML;
        }

        echo <<<HTML
                </div>

                <div class="enviar">
                    <input type="submit" name="change-saved" value="Confirmar modificación">
                </div>
            </form>
        HTML;
    }

    function MostrarCambiosExito(){
        echo <<<HTML
            <p style="text-align: center; font-weight: bold; font-size: 25px;">Se han modificado los datos del usuario</p>
        HTML;

        header('Refresh: 5; URL=./index.php');
    }


    function MostrarLog(){
        echo <<<HTML
            <section class="log">
                <h2>Eventos del sistema</h2>

                <div class="eventos">
                    <div class="evento">
                        <label>2023-05-23 17:46:69</label>
                        <label>INFO: El usuario ha iniciado sesion</label>
                    </div>
            
                    <div class="evento">
                        <label>2023-05-23 17:46:69</label>
                        <label>INFO: El usuario ha iniciado sesion</label>
                    </div>
            
                    <div class="evento">
                        <label>2023-05-23 17:46:69</label>
                        <label>INFO: El usuario ha iniciado sesion</label>
                    </div>
            
                    <div class="evento">
                        <label>2023-05-23 17:46:69</label>
                        <label>INFO: El usuario ha iniciado sesion</label>
                    </div>

                    <div class="evento">
                        <label>2023-05-23 17:46:69</label>
                        <label>INFO: El usuario ha iniciado sesion</label>
                    </div>

                    <div class="evento">
                        <label>2023-05-23 17:46:69</label>
                        <label>INFO: El usuario ha iniciado sesion</label>
                    </div>

                    <div class="evento">
                        <label>2023-05-23 17:46:69</label>
                        <label>INFO: El usuario ha iniciado sesion</label>
                    </div>

                    <div class="evento">
                        <label>2023-05-23 17:46:69</label>
                        <label>INFO: El usuario ha iniciado sesion</label>
                    </div>

                    <div class="evento">
                        <label>2023-05-23 17:46:69</label>
                        <label>INFO: El usuario ha iniciado sesion</label>
                    </div>
                </div>
            </section>
        HTML;
    }

?>