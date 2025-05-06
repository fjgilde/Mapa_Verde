<?php
session_start();
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
            padding: auto;
            background-color: #f4f4f4;
        }
        header nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: #4CAF50;
            padding: 10px 20px;
        }
        header nav .logo a {
            color: white;
            text-decoration: none;
            font-size: 24px;
            font-weight: bold;
        }
        header nav ul {
            list-style: none;
            display: flex;
            gap: 15px;
        }
        header nav ul li a {
            color: white;
            text-decoration: none;
            font-size: 18px;
        }
        #formulario {
            max-width: 600px;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        input, textarea, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #45a049;
        }
        footer {
            text-align: center;
            padding: 10px 0;
            background-color: #333;
            color: white;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <div class="logo">
                <a href="index.php">Mapa Verde</a>
            </div>
            <ul class="nav-links">
                <li><a href="index.php">Inicio</a></li>
                <li><a href="noticias.php">Noticias e Información</a></li>
                <li><a href="estadisticas.php">Estadísticas</a></li>
                <?php if (isset($_SESSION['usuario'])): ?>
                    <li><a href="logout.php" class="logout-btn">Cerrar Sesión</a></li>
                <?php else: ?>
                    <li><a href="login.php" class="login-btn">Login</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <?php if (isset($_SESSION['usuario'])): ?>
        <form id="formulario" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="titulo">Título:</label>
                <input type="text" id="titulo" name="titulo" required>
            </div>
            <div class="form-group">
                <label for="contenido">Contenido:</label>
                <textarea id="contenido" name="contenido" rows="5" required></textarea>
            </div>
            <div class="form-group">
                <label for="imagen">Imagen:</label>
                <input type="file" id="imagen" name="imagen" accept="image/*" required>
            </div>
            <button type="submit" name="Enviar">Enviar</button>
        </form>

        <?php
        require_once 'db-connect.php';

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Enviar'])) {
            $titulo = $conn->real_escape_string($_POST['titulo']);
            $contenido = $conn->real_escape_string($_POST['contenido']);

            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
                $tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif'];
                $imagenTipo = $_FILES['imagen']['type'];

                if (!in_array($imagenTipo, $tiposPermitidos)) {
                    echo "Error: Solo se permiten imágenes (JPEG, PNG, GIF).";
                    exit;
                }

                $imagenContenido = addslashes(file_get_contents($_FILES['imagen']['tmp_name']));

                $sql = "INSERT INTO noticias (titulo, contenido, imagen) VALUES ('$titulo', '$contenido', '$imagenContenido')";

                if ($conn->query($sql) === TRUE) {
                    echo "Noticia subida exitosamente.";
                } else {
                    echo "Error al insertar la noticia: " . $conn->error;
                }
            } else {
                echo "Error: No se pudo subir la imagen.";
            }
        }
        ?>
    <?php else: ?>
        <p style="text-align: center; margin-top: 20px;">Por favor, inicia sesión para acceder a esta funcionalidad.</p>
    <?php endif; ?>

    <footer>
        <p>&copy; 2025 Web Responsive. Hecho por Francisco Javier Gutiérrez Ildefonso.</p>
    </footer>
</body>
</html>