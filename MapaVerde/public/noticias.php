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
        body {
    font-family: 'Georgia', serif;
    background-color: #ffffff;
    color: #1a1a1a;
    margin: 0;
    padding: 0;
}

.natgeo-news-container {
    max-width: 1100px;
    margin: 40px auto;
    padding: 0 20px;
    display: flex;
    flex-direction: column;
    gap: 50px;
}

.natgeo-article {
    display: flex;
    flex-direction: column;
    gap: 20px;
    border-bottom: 1px solid #e1e1e1;
    padding-bottom: 30px;
}

.natgeo-article-image img {
    width: 100%;
    height: auto;
    border-radius: 8px;
    object-fit: cover;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.natgeo-title {
    font-size: 2em;
    font-weight: bold;
    margin: 0;
    color: #000;
    line-height: 1.2;
}

.natgeo-date {
    font-size: 0.9em;
    color: #a38f00; /* Mostaza dorado */
    margin: 5px 0 15px;
    font-style: italic;
}

.natgeo-snippet {
    font-size: 1.1em;
    line-height: 1.6;
    color: #333;
    text-align: justify;
}

.natgeo-no-news {
    text-align: center;
    color: #777;
    font-size: 1.3em;
    margin-top: 50px;
}

@media (min-width: 768px) {
    .natgeo-article {
        flex-direction: row;
    }

    .natgeo-article-image {
        flex: 1;
    }

    .natgeo-article-content {
        flex: 2;
        padding-left: 30px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
}


    </style>
</head>
<body>
    <header>
        <nav>
            <img id="logotipo" src="imagenes/imageniatierra.png">
            <div class="logo">
                <a class="logo" href="index.php">Mapa Verde</a>
            </div>
            <ul class="nav-links">
                <li><a href="index.php">Inicio</a></li>
                <li><a href="noticias.php">Noticias e Informacion</a></li>
                <li><a href="estadisticas.php">Estadisticas</a></li>                
                <li><a href="manager.php">Panel de control</a></li>
                <li><a href="login.php" class="login-btn">Login</a></li>
            </ul>
        </nav>
    </header>

    <?php
    require_once 'db-connect.php';

    $sql = "SELECT * FROM noticias ORDER BY fecha DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<h2 style='color: #2b3d4f'>" . htmlspecialchars($row["titulo"]) . "</h2>";
            echo "<p>" . htmlspecialchars($row["contenido"]) . "</p>";
            echo "<small>" . htmlspecialchars($row["fecha"]) . "</small><hr>";

            if (!empty($row['imagen'])) {
                echo '<img id="imgnot" src="data:image/jpeg;base64,' . base64_encode($row['imagen']) . '">';
            } else {
                echo '<p>No hay imagen disponible.</p>';
            }
        }
    } else {
        echo "No hay noticias disponibles.";
    }

    ?>


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

    <footer>
        <p>&copy; 2024 Web Responsive. Hecho por Francisco Javier Gutierrez Ildefonso.</p>
    </footer>
</body>
</html>