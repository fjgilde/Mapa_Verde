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
        #imgnot{
            max-width: 35%;
            height: auto;
            margin-top: 10px;
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

    <?php
    require_once 'db-connect.php';
    $sql = "SELECT * FROM noticias ORDER BY fecha DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<h2 style='color: #2b3d4f'>" . $row["titulo"] . "</h2>";
        echo "<p>" . $row["contenido"] . "</p>";
        echo "<small>" . $row["fecha"] . "</small><hr>";

        $resultado = $conn->query("SELECT imagen FROM noticias WHERE id = " . $row["id"]);

        while ($fila = $resultado->fetch_assoc()) {
        echo '<img id="imgnot" src="data:image/jpeg;base64,' . base64_encode($fila['imagen']) . '">';
            }
    }
    } else {
    echo "No hay noticias disponibles.";
    }


    $conn->close();
    ?>
    <form id="formulario" method="post">
        <div class="form-group">
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" required>
        </div>
        <div class="form-group">
            <label for="contenido">Contenido:</label>
            <textarea id="contenido" name="contenido" required></textarea>
        </div>
        <div class="form-group">
            <label for="imagen">Imagen:</label>
            <input type="file" id="imagen" name="imagen" accept="image/*" required> 
        </div>
        <button type="submit" id="Enviar" name="Enviar">Enviar</button>
    </form>
    <?php
    if (isset($_POST['Enviar'])) {

    if (isset($_FILES['imagen']['tmp_name']) && is_uploaded_file($_FILES['imagen']['tmp_name'])) {
        $imagen = $_FILES['imagen']['tmp_name'];
        $imgContent = file_get_contents($imagen);
        $titulo = $_POST['titulo'];
        $contenido = $_POST['contenido'];

        $sql = "INSERT INTO noticias (titulo, contenido, imagen, fecha) VALUES (?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $titulo, $contenido, $imgContent);

        if ($stmt->execute()) {
            echo "Noticia publicada correctamente.";
        } else {
            echo "Error: {$stmt->error}";
        }
    
        $stmt->close();
    } else {
        echo "Error: No se pudo cargar la imagen.";
    }
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