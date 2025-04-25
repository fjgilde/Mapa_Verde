<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noticias</title>
    <link rel="stylesheet" href="css/estilo.css">
    <style>
        body{
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: auto;
        }
        img{
            margin-top: auto;
            padding: auto;
            width: auto;
            height: auto;
        }
    </style>
</head>
<body>
    <header>
        <nav>
        <img id="logotipo" src="imagenes/imageniatierra.png"><div class="logo"><a class="logo" href="index.php">Mapa Verde</a></div>
            <ul class="nav-links">
                <li><a href="index.php">Inicio</a></li>
                <li><a href="noticias.php">Noticias e Informacion</a></li>
                <li><a href="estadisticas.php">Estadisticas</a></li>
                <li><a href="login.php" class="login-btn">Login</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <div id="noticias1" tabindex="1">
            <p>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque tempore tenetur maxime saepe laborum nisi dignissimos adipisci rem, architecto, iure aliquid obcaecati illum totam! Totam reiciendis sunt similique asperiores ducimus.
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempora, voluptate cumque? Maiores beatae, debitis soluta quis saepe facilis aliquam! Eos modi expedita accusantium hic officiis sint neque perferendis distinctio itaque.
            </p>
        </div>
        
    </main>
    <?php
    require_once ('db-connect.php');
    $sql = "SELECT * FROM noticias ORDER BY fecha DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<h2 style='color: #2b3d4f'>" . $row["titulo"] . "</h2>";
        echo "<p>" . $row["contenido"] . "</p>";
        echo "<small>" . $row["fecha"] . "</small><hr>";
    }
    } else {
    echo "No hay noticias disponibles.";
    }

    $resultado = $conn->query("SELECT imagen FROM noticias");

    while ($fila = $resultado->fetch_assoc()) {
    echo '<img src="data:image/jpeg;base64,' . base64_encode($fila['imagen']) . '">';
    }

    $conn->close();
    ?>
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

    <footer>
        <p>&copy; 2024 Web Responsive. Hecho por Francisco Javier Gutierrez Ildefonso.</p>
    </footer>
</body>
</html>