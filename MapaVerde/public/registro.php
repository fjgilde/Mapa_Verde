<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/estilo.css">
    <style>
        .registroInicio {
            display: flex; 
            gap: 20px
        }
    </style>
</head>
<body>
    <header>
        <nav>
        <img id="logotipo" src="imagenes/imageniatierra.png"><div class="logo"><a class="logo" href="index.php">Mapa Verde</a></div>
            <ul class="nav-links">
                <li><a href="index.php">Inicio</a></li>
                <li><a href="login.php" class="login-btn">Login</a></li>
            </ul>
        </nav>
    </header>

    <main class="login-main">        
        <form class="login-form" id="formulario" method="post">
            <div id="registroInicio" class="registroInicio">
                <h1 onclick="RegistrarsePag()">Registrarse</h1>
            </div>
            <div class="form-group">
                <label for="username">Usuario:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <br>
            <div id="form-button-container">
                <button type="submit" id="Registrarse" name="Registrarse">Registrate</button>
            </div>
            <div id="registro" name="registro"></div>
            <div class="forgot-link">
                <a href="forgot.php" class="Forgot">¿Olvidaste tu Contraseña?</a>
            </div>
            <div>
            <input type="checkbox" required> Acepto los términos y condiciones
            <a href="#" id="enlace">Ver políticas</a>
            </div>
        </form>
    </main>

    <div id="terminos"></div>


    <footer>
        <p>&copy; 2024 Web Responsive. Hecho por Francisco Javier Gutierrez Ildefonso.</p>
    </footer>
</body>
</html>

<?php
require_once('db-connect.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if(isset($_POST['Registrarse'])) {
        $user = $_POST['username'];
        $passw = $_POST['password'];
        $email = $_POST['email'];

        $check = $conn->prepare("SELECT Usuarios FROM list_user_pag WHERE Usuarios = ? OR Email = ?");
        $check->bind_param("ss", $user, $email);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            echo "El usuario o email ya existe.";
            $check->close();
            exit();
        }

        $stmt = $conn->prepare("INSERT INTO list_user_pag (Usuarios, Password, Email) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $user, $passw, $email);

        if ($stmt->execute()) {
            echo "<style>#registro{display: inline-block;}</style>Registro correctamente <i class='bi bi-check-circle-fill'></i>";
            header(header: "Location: login.php");
        } else {
            echo "Error: " . $conn->error;
        }
        $stmt->close();
    }
    $conn->close();
}
?>