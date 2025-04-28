<?php
if(!isset($_SESSION)) {
    include_once('db-connect.php');
    session_start();

    if (isset($_POST['editar_usuario'])) {
        include('db-connect.php');
    
        $usuario_a_editar = $_POST['usuario_a_editar'];
        $nuevo_nombre = $_POST['nuevo_nombre'];
        $nuevo_correo = $_POST['nuevo_correo'];
        $nueva_password = $_POST['nueva_password'];
    
        $q = "UPDATE list_user_pag 
              SET Usuarios = '$nuevo_nombre', 
                  Email = '$nuevo_correo', 
                  password = '$nueva_password' 
              WHERE Usuarios = '$usuario_a_editar'";
    
        if (!mysqli_query($conn, $q)) {
            echo "Error al editar los datos: " . mysqli_error($conn);
        } else {
            echo "<style>#editar_ok{display: inline-block;}</style>Editado correctamente <i class='bi bi-check-circle-fill'></i>";
        }
    }
}
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
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }    
        .form-container {
            max-width: 400px;
            margin: 0 auto;
            margin-top: 5px;
            padding: 20px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .btn {
            display: inline-block;
            width: 100%;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            color: #fff;
            background-color: #28a745;
            border: none;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #218838;
        }
        
    #imagePreview {
      max-width: 10%;
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
    <main>
    <div class="form-container">
        <h2>Datos Usuario</h2>
        <form action="insertar_datos.php" method="POST">

            <label for="fileInput">Foto de perfil</label>
            <input type="file" id="fileInput" accept="image/*">
            <div>
                <img id="imagePreview">
            </div>

            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" placeholder="Ingrese su nombre" required>
            </div>
            <div class="form-group">
                <label for="correo">Correo Electrónico</label>
                <input type="email" id="correo" name="correo" placeholder="Ingrese su correo" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" placeholder="Ingrese su contraseña" required>
            </div>
            <div class="form-group">

            <button type="submit" class="btn">Insertar Datos</button>
        </form>
    </div>
    </main>

  <script>
    const fileInput = document.getElementById('fileInput');
    const imagePreview = document.getElementById('imagePreview');

    fileInput.addEventListener('change', (event) => {
      const file = event.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
          imagePreview.src = e.target.result;
        };
        reader.readAsDataURL(file);
        fileInput.style.visibility = 'hidden';
      }
    });
  </script>


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
    
    <script src="cliente.js"></script>

    <footer>
        <p>&copy; 2024 Web Responsive. Hecho por Francisco Javier Gutierrez Ildefonso.</p>
    </footer>
</body>
</html>