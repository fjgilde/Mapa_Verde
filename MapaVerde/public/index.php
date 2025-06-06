    <?php
    session_start();
    ?>

    <!DOCTYPE html>
    <html>
    <head>
        <title>MAPA VERDE</title>
        <link rel="stylesheet" href="css/estilo.css">
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
        <style>
            #map {
                height: 600px;
                width: 70%;
                margin: 20px 0;
                border: 2px solid #555;
                border-radius: 8px;
            }
            .controls {
                margin: 10px 0;
                width: 70%;
                padding: 10px;
                background: #f0f0f0;
                border-radius: 5px;
                display: flex;
                gap: 10px;
                flex-wrap: wrap;
            }
            .container::after{
                display: flex;
                content: "";
                display: table;
                clear: both;
            }
            aside{
                display: flex;
                float: right;
                width: auto;
                background-color: #f0f0f0;
                padding: auto;
                margin: 0 auto;
                flex-direction: row;
            }
            #lista-poligonos {
                margin: 20px 0;
                padding: 10px;
                background: #fff;
                border-radius: 5px;
                max-height: 200px;
                overflow-y: auto;
            }
            .poligono-item {
                padding: 5px;
                margin: 5px 0;
                border-left: 5px solid;
            }
            #formulario {
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background: white;
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0 0 10px rgba(0,0,0,0.2);
                z-index: 1000;
                display: none;
            }
            .profile-picture {
                width: 40px;
                height: 40px;
                border-radius: 50%;
                cursor: pointer;
                object-fit: cover;
            }
        </style>
    </head>
    <body>
    <header>
        <nav>
            <img id="logotipo" src="imagenes/imageniatierra.png">
            <div class="logo"><a class="logo" href="index.php">Mapa Verde</a></div>
            <ul class="nav-links">
                <li><a href="index.php">Inicio</a></li>
                <li><a href="noticias.php">Noticias e Informacion</a></li>
                <li><a href="estadisticas.php">Estadisticas</a></li>
                <li><a href="manager.php">Panel de control</a></li>
                <?php if (isset($_SESSION['username'])): ?>
                <li>
                    <a href="perfil.php">
                        <img src="<?php echo isset($_SESSION['Imagenpfp']) ? htmlspecialchars($_SESSION['Imagenpfp'], ENT_QUOTES, 'UTF-8') : 'imagenes/usuario-default.png'; ?>" 
                            alt="Usuario" class="profile-picture">
                    </a>
                </li>
                <?php else: ?>
                <li><a href="login.php" class="login-btn">Login</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>


        <p>
        🌿 Mapa Verde – Plataforma Interactiva para la Gestión de Puntos Limpios
        Mapa Verde es una plataforma web interactiva diseñada con el objetivo de promover la sostenibilidad ambiental a través de la identificación, registro y gestión de puntos limpios. Esta herramienta digital permite a los usuarios visualizar en un mapa geográfico los espacios destinados a la recolección selectiva de residuos, zonas de reciclaje, áreas ecológicas y otros lugares de interés ambiental.    
        </p>
        <p>
        🗺️ Funcionalidad principal: Mapa interactivo
        La función central del sitio es un mapa interactivo basado en la biblioteca de código abierto Leaflet, que utiliza datos de OpenStreetMap para la visualización cartográfica. Al acceder al sitio, la aplicación detecta la ubicación actual del usuario mediante geolocalización (si se permite el permiso) y centra el mapa en ese punto, facilitando así una experiencia personalizada y contextualizada.
        </p>    
        <p>
        🛠️ Añadir nuevos puntos limpios
        Los usuarios pueden añadir nuevos puntos limpios mediante una interfaz intuitiva:
        Botón "Nuevo punto limpio": al hacer clic, se activa el modo de dibujo.
        Clics en el mapa: el usuario marca los vértices del área correspondiente al punto limpio.
        Doble clic: finaliza el dibujo del polígono.
        Formulario emergente: se solicita el nombre del lugar para identificar el punto limpio.
        Además, el usuario puede elegir un color para representar visualmente cada zona, lo cual facilita la distinción entre diferentes áreas en el mapa.
        </p>
        <p>
        🗑️ Visualización y gestión de puntos limpios
        Una vez que se ha añadido un punto limpio, este se muestra en el mapa con un polígono coloreado. Los usuarios pueden ver todos los puntos limpios registrados, y cada polígono incluye información sobre su nombre y color. Además, se proporciona una lista de todos los puntos limpios en la parte lateral del mapa, lo que permite una navegación rápida y eficiente.
        </p>
        <br></br>
            <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>


            <script src="javascript/mapa-db.js"></script>
            <div class="controls">
    <button onclick="iniciarDibujo()">Nuevo punto Limpio</button>
    <button class="color-btn" style="background: #ff000080" onclick="seleccionarColor(this)"></button>
    <button class="color-btn" style="background: #0000ff80" onclick="seleccionarColor(this)"></button>
    <button class="color-btn" style="background: #00ff0080" onclick="seleccionarColor(this)"></button>
    <button class="color-btn" style="background: #fffb00" onclick="seleccionarColor(this)"></button>
    <button onclick="limpiarTodo()">Limpiar Todo</button>
</div>

    <div id="formulario">
        <h3>Punto Limpio</h3>
        <input type="text" id="nombre-poligono" placeholder="Ej: Zona de peligro" required>
        <button onclick="guardarPoligono()">Guardar</button>
        <button onclick="cancelarDibujo()">Cancelar</button>
    </div>
    <div id="container"></div>
    <div id="map"></div>
    <div id="lista-poligonos">
    </div>

    <div id="valoraciones">
    <h3>📢 Valoraciones de Usuarios</h3>
    <form id="form-review" method="post">
        <label for="user_name">Nombre:</label><br>
        <input type="text" id="user_name" name="user_name" required><br><br>

        <label for="user_rating">Valoración (1 a 5):</label><br>
        <select id="user_rating" name="user_rating" required>
            <option value="">Selecciona una opción</option>
            <option value="1">⭐</option>
            <option value="2">⭐⭐</option>
            <option value="3">⭐⭐⭐</option>
            <option value="4">⭐⭐⭐⭐</option>
            <option value="5">⭐⭐⭐⭐⭐</option>
        </select><br><br>

        <label for="user_review">Comentario:</label><br>
        <textarea id="user_review" name="user_review" rows="4" cols="40" required></textarea><br><br>

        <button type="submit">Enviar Valoración</button>
    </form>

    <div id="lista-valoraciones">
        <h4>Últimas valoraciones:</h4>
        <script src="javascript/valoraciones.js"></script>
    </div>
    </div>


        <div id="chat-icon" class="chat-icon">
            <img src="imagenes/imageniatierra.png" alt="Chat IA">
        </div>

        <div id="chat-container" class="chat-container" style="display: none;">
            <div id="chat-messages"></div>
            <div class="chat-input">
                <input type="text" id="user-input" placeholder="Escribe tu mensaje...">
                <button id="send-btn">Enviar</button>
            </div>
            <div id="loading" style="display: none;">Cargando...</div>
        </div>

        <script src="javascript/cliente.js"></script>

        <div id="comments">
            
        </div>
        <footer>
            <p>&copy; 2024 Web Responsive. Hecho por Francisco Javier Gutierrez Ildefonso.</p>
        </footer>
    </body>
    </html>