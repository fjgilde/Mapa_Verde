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
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque tempore tenetur maxime saepe laborum nisi dignissimos adipisci rem, architecto, iure aliquid obcaecati illum totam! Totam reiciendis sunt similique asperiores ducimus.
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempora, voluptate cumque? Maiores beatae, debitis soluta quis saepe facilis aliquam! Eos modi expedita accusantium hic officiis sint neque perferendis distinctio itaque.
    </p>
    <p>
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque tempore tenetur maxime saepe laborum nisi dignissimos adipisci rem, architecto, iure aliquid obcaecati illum totam! Totam reiciendis sunt similique asperiores ducimus.
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempora, voluptate cumque? Maiores beatae, debitis soluta quis saepe facilis aliquam! Eos modi expedita accusantium hic officiis sint neque perferendis distinctio itaque.
    </p>
    <aside>
        <h3>Noticias Importantes</h3>
        <p>
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque tempore tenetur maxime saepe laborum nisi dignissimos adipisci rem, architecto, iure aliquid obcaecati illum totam! Totam reiciendis sunt similique asperiores ducimus.
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempora, voluptate cumque? Maiores beatae, debitis soluta quis saepe facilis aliquam! Eos modi expedita accusantium hic officiis sint neque perferendis distinctio itaque.
        </p>
    </aside>
    </div>

    <p>
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque tempore tenetur maxime saepe laborum nisi dignissimos adipisci rem, architecto, iure aliquid obcaecati illum totam! Totam reiciendis sunt similique asperiores ducimus.
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempora, voluptate cumque? Maiores beatae, debitis soluta quis saepe facilis aliquam! Eos modi expedita accusantium hic officiis sint neque perferendis distinctio itaque.
    </p>
    <br></br>
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>


        <script src="javascript/mapa-db.js"></script>
<div class="controls">
    <button onclick="iniciarDibujo()">Nuevo punto Limpio</button>
    <button class="color-btn" style="background: #ff000080" onclick="seleccionarColor('#ff000080')"></button>
    <button class="color-btn" style="background: #0000ff80" onclick="seleccionarColor('#0000ff80')"></button>
    <button class="color-btn" style="background: #00ff0080" onclick="seleccionarColor('#00ff0080')"></button>
    <button class="color-btn" style="background: #fffb00" onclick="seleccionarColor('#fffb00')"></button>
    <button onclick="limpiarTodo()">Limpiar Todo</button>
</div>

<div id="formulario">
    <h3>Punto Limpio</h3>
    <input type="text" id="nombre-poligono" placeholder="Ej: Zona de peligro" required>
    <button onclick="guardarPoligono()">Guardar</button>
    <button onclick="cancelarDibujo()">Cancelar</button>
    <button onclick="eliminarPoligono()">Eliminar</button>
</div>
<div id="container"></div>
<div id="map"></div>
<div id="lista-poligonos">

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