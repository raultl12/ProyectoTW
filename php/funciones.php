
<?php
    function setSession($nombreVariable, $valor){
        $_SESSION[$nombreVariable] = $valor;
    }

    function getSession($nombreVariable){
        return $_SESSION[$nombreVariable];
    }

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
                    <li><a href="">Gestión de usuarios</a></li>
                    <li><a href="">Ver log</a></li>
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
        echo <<<HTML
                <aside>
                    <p> Barra aside</p>
                </aside>
        HTML;
    }

    function MostrarContenido(){
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
?>