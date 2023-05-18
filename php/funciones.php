
<?php
    function setSession($nombreVariable, $valor){
        $_SESSION[$nombreVariable] = $valor;
    }

    function getSession($nombreVariable){
        return $_SESSION[$nombreVariable];
    }

    function MostrarMain(){
        echo <<<HTML
        <div class="contenido">
            <main>
                <p>Contenido principal de la pagina</p>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Reprehenderit architecto dolorum earum beatae, quisquam quibusdam at quas vero inventore, praesentium excepturi? Voluptate earum magnam, delectus animi iusto molestiae voluptas aliquid?</p>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Reprehenderit architecto dolorum earum beatae, quisquam quibusdam at quas vero inventore, praesentium excepturi? Voluptate earum magnam, delectus animi iusto molestiae voluptas aliquid?</p>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Reprehenderit architecto dolorum earum beatae, quisquam quibusdam at quas vero inventore, praesentium excepturi? Voluptate earum magnam, delectus animi iusto molestiae voluptas aliquid?</p>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Reprehenderit architecto dolorum earum beatae, quisquam quibusdam at quas vero inventore, praesentium excepturi? Voluptate earum magnam, delectus animi iusto molestiae voluptas aliquid?</p>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Reprehenderit architecto dolorum earum beatae, quisquam quibusdam at quas vero inventore, praesentium excepturi? Voluptate earum magnam, delectus animi iusto molestiae voluptas aliquid?</p>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Reprehenderit architecto dolorum earum beatae, quisquam quibusdam at quas vero inventore, praesentium excepturi? Voluptate earum magnam, delectus animi iusto molestiae voluptas aliquid?</p>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Reprehenderit architecto dolorum earum beatae, quisquam quibusdam at quas vero inventore, praesentium excepturi? Voluptate earum magnam, delectus animi iusto molestiae voluptas aliquid?</p>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Reprehenderit architecto dolorum earum beatae, quisquam quibusdam at quas vero inventore, praesentium excepturi? Voluptate earum magnam, delectus animi iusto molestiae voluptas aliquid?</p>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Reprehenderit architecto dolorum earum beatae, quisquam quibusdam at quas vero inventore, praesentium excepturi? Voluptate earum magnam, delectus animi iusto molestiae voluptas aliquid?</p>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Reprehenderit architecto dolorum earum beatae, quisquam quibusdam at quas vero inventore, praesentium excepturi? Voluptate earum magnam, delectus animi iusto molestiae voluptas aliquid?</p>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Reprehenderit architecto dolorum earum beatae, quisquam quibusdam at quas vero inventore, praesentium excepturi? Voluptate earum magnam, delectus animi iusto molestiae voluptas aliquid?</p>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Reprehenderit architecto dolorum earum beatae, quisquam quibusdam at quas vero inventore, praesentium excepturi? Voluptate earum magnam, delectus animi iusto molestiae voluptas aliquid?</p>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Reprehenderit architecto dolorum earum beatae, quisquam quibusdam at quas vero inventore, praesentium excepturi? Voluptate earum magnam, delectus animi iusto molestiae voluptas aliquid?</p>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Reprehenderit architecto dolorum earum beatae, quisquam quibusdam at quas vero inventore, praesentium excepturi? Voluptate earum magnam, delectus animi iusto molestiae voluptas aliquid?</p>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Reprehenderit architecto dolorum earum beatae, quisquam quibusdam at quas vero inventore, praesentium excepturi? Voluptate earum magnam, delectus animi iusto molestiae voluptas aliquid?</p>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Reprehenderit architecto dolorum earum beatae, quisquam quibusdam at quas vero inventore, praesentium excepturi? Voluptate earum magnam, delectus animi iusto molestiae voluptas aliquid?</p>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Reprehenderit architecto dolorum earum beatae, quisquam quibusdam at quas vero inventore, praesentium excepturi? Voluptate earum magnam, delectus animi iusto molestiae voluptas aliquid?</p>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Reprehenderit architecto dolorum earum beatae, quisquam quibusdam at quas vero inventore, praesentium excepturi? Voluptate earum magnam, delectus animi iusto molestiae voluptas aliquid?</p>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Reprehenderit architecto dolorum earum beatae, quisquam quibusdam at quas vero inventore, praesentium excepturi? Voluptate earum magnam, delectus animi iusto molestiae voluptas aliquid?</p>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Reprehenderit architecto dolorum earum beatae, quisquam quibusdam at quas vero inventore, praesentium excepturi? Voluptate earum magnam, delectus animi iusto molestiae voluptas aliquid?</p>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Reprehenderit architecto dolorum earum beatae, quisquam quibusdam at quas vero inventore, praesentium excepturi? Voluptate earum magnam, delectus animi iusto molestiae voluptas aliquid?</p>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Reprehenderit architecto dolorum earum beatae, quisquam quibusdam at quas vero inventore, praesentium excepturi? Voluptate earum magnam, delectus animi iusto molestiae voluptas aliquid?</p>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Reprehenderit architecto dolorum earum beatae, quisquam quibusdam at quas vero inventore, praesentium excepturi? Voluptate earum magnam, delectus animi iusto molestiae voluptas aliquid?</p>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Reprehenderit architecto dolorum earum beatae, quisquam quibusdam at quas vero inventore, praesentium excepturi? Voluptate earum magnam, delectus animi iusto molestiae voluptas aliquid?</p>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Reprehenderit architecto dolorum earum beatae, quisquam quibusdam at quas vero inventore, praesentium excepturi? Voluptate earum magnam, delectus animi iusto molestiae voluptas aliquid?</p>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Reprehenderit architecto dolorum earum beatae, quisquam quibusdam at quas vero inventore, praesentium excepturi? Voluptate earum magnam, delectus animi iusto molestiae voluptas aliquid?</p>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Reprehenderit architecto dolorum earum beatae, quisquam quibusdam at quas vero inventore, praesentium excepturi? Voluptate earum magnam, delectus animi iusto molestiae voluptas aliquid?</p>
            </main>
            <aside>
                <p>Barra aside</p>
            </aside>
        </div>
        HTML;
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
                    <li><a href="../php/incidencias.php">Ver incidencias</a></li>
                    <li><a href="">Nueva incidencia</a></li>
                    <li><a href="">Mis incidencias</a></li>
                HTML;
                break;

            case "administrador":
                echo <<<HTML
                    <li><a href="../php/incidencias.php">Ver incidencias</a></li>
                    <li><a href="">Nueva incidencia</a></li>
                    <li><a href="">Mis incidencias</a></li>
                    <li><a href="">Gestión de usuarios</a></li>
                    <li><a href="">Ver log</a></li>
                    <li><a href="">Gestión de BBDD</a></li>
                HTML;
                break;

            default:
                echo "<li><a href=\"../php/incidencias.php\">Ver incidencias</a></li>";
                break;

            
        }

        echo <<<HTML
                </ul>
            </nav>
        HTML;
    }

    function mostrarIncidencias($numIncidencias, $tipoUsuario){
        global $lugarIncidencia;
        global $fechaIncidencia;
        global $creadorIncidencia;
        global $palabrasIncidencia;
        global $estadoIncidencia;
        global $positivasIncidencia;
        global $negativasIncidencia;

        for ($i = 0; $i < $numIncidencias; $i++){
            echo <<<HTML
                <div class="incidencia">
                    <h2>name php</h2>

                    <div class="detalles">
                        <label>Lugar: $lugarIncidencia[$i]</label>
                        <label>Fecha: $fechaIncidencia[$i]</label>
                        <label>Creador por: $creadorIncidencia[$i]</label>
                        <label>Palabras clave: $palabrasIncidencia[$i]</label>
                        <label>Estado: $estadoIncidencia[$i]</label>
                        <label>Valoraciones: Pos: $positivasIncidencia[$i] Neg: $negativasIncidencia[$i]</label>

                        <p>
                            Comentario incidencia
                        </p>
            HTML;

            // mostrar de alguna manera x imagenes 
            // correspondientes a la incidencia
            
            for ($j = 0; $j < 5; $j++){
                echo "<img src=\"\" alt=\"\">";
            }

            echo <<<HTML
                    </div>

                    <div class="comentarios">
                        <label>Usuario</label>
                        <label>Comentario</label>

                        <div class="iconos">
                            <a><img src="../img/plus.png" alt="Voto positivo" name="voto_pos"></a>
                            <a><img src="../img/minus.png" alt="Voto negativo" name="voto_neg"></a>
                            <a><img src="../img/comment.png" alt="Añadir comentario" name="nuevo_com"></a>
            HTML;

            if ($tipoUsuario == "administrador"){
                echo "<a><img src=\"../img/editar.png\" alt=\"Editar comentario\" name=\"edit_com\"></a>";
                echo "<a><img src=\"../img/basura.png\" alt=\"Borrar comentario\" name=\"del_com\"></a>";
            }

            echo <<<HTML
                        </div>
                    </div>
                </div>
            HTML;
        }
    }

    function mostrarIncidencia(){
        echo <<<HTML
        <section>
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
        </section>
        HTML;
    }
?>