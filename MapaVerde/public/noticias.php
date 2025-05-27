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
    font-family: Arial, Helvetica, sans-serif;
    margin: 0;
    padding: 0;
    line-height: 1.6;
    background-color:rgb(255, 255, 255);
}


header {
    background: #2b3d4f;
    color: #27ae60;
    padding: 10px 20px;
}

header nav {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
}

#logotipo {
    height: 50px;
    margin-right: 20px;
}

.logo a {
    color: #00ff37;
    font-size: 1.5em;
    text-decoration: none;
    font-weight: bold;
}

.nav-links {
    list-style: none;
    display: flex;
    gap: 15px;
    margin: 0;
    padding: 0;
}

.nav-links li a {
    color: white;
    text-decoration: none;
    padding: 5px 10px;
    transition: background 0.3s, color 0.3s;
}

.nav-links li a:hover {
    background: white;
    color: #2b3d4f;
    border-radius: 5px;
}

p {
    margin: 0 20px;
    text-align: justify;
}

img#imgnot {
    display: block;
    max-width: 40%;
    height: auto;
    margin: 10px 20px;
    float: left;
}

hr {
    border: 0;
    height: 1px;
    background: #ccc;
}

#user-input {
    flex: 1;
    padding: 10px;
    border: none;
    outline: none;
}

#send-btn {
    background: #2b3d4f;
    color: white;
    padding: 10px;
    border: none;
    cursor: pointer;
}


footer {
    margin-top: 20px;
    text-align: center;
    background: #2b3d4f;
    color: white;
    padding: 10px 0;
}


@media (max-width: 768px) {
    .nav-links {
        flex-direction: column;
        gap: 10px;
        text-align: center;
    }

    #imgnot {
        max-width: 80%;
    }

    .chat-container {
        width: 90%;
        bottom: 100px;
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