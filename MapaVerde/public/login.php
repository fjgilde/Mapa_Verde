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
            <div class="logo">Mapa verde</div>
            <ul class="nav-links">
                <li><a href="index.php">Inicio</a></li>
                <li><a href="login.php" class="login-btn">Login</a></li>
            </ul>
        </nav>
    </header>

    <main class="login-main">        
        <form class="login-form" id="formulario" method="post">
            <div id="registroInicio" class="registroInicio">
                <h1 onclick="IniciarSesion()">Iniciar Sesión</h1>
                <h1>O</h1>
                <h1 onclick="RegistrarsePag()">Registrarse</h1>
            </div>
            <div class="form-group">
                <label for="username">Usuario:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group" id="textoreg">
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <br>
            <div id="form-button-container">
                <button type="submit" id="Iniciar_sesion" name="Iniciar_sesion">Iniciar sesión</button>
            </div>
            <div class="forgot-link">
                <a href="forgot.php" class="Forgot">¿Olvidaste tu Contraseña?</a>
            </div>
        </form>
    </main>

    <div id="terminos"></div>

    <footer>
        <p>&copy; 2024 Web Responsive. Hecho por Francisco Javier Gutierrez Ildefonso.</p>
    </footer>

    <script>
        function RegistrarsePag() {
            document.getElementById('textoreg').innerHTML = `
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            `;
            
            document.getElementById('form-button-container').innerHTML = `
                <button type="submit" id="Registrarse" name="Registrarse">Registrarse</button>
            `;
            
            document.getElementById('terminos').innerHTML = `
                <input type="checkbox" required> Acepto los términos y condiciones
                <a href="#" id="enlace">Ver políticas</a>
            `;
        }

        function IniciarSesion() {
            document.getElementById('textoreg').innerHTML = '';
            document.getElementById('terminos').innerHTML = '';
            
            document.getElementById('form-button-container').innerHTML = `
                <button type="submit" id="Iniciar_sesion" name="Iniciar_sesion">Iniciar sesión</button>
            `;
        }
    </script>
</body>
</html>

<?php
require_once('db-connect.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['Iniciar_sesion'])) {
        $user = $_POST['username'];
        $passw = $_POST['password'];

        $stmt = $conn->prepare("SELECT Password FROM list_user_pag WHERE Usuarios = ?");
        $stmt->bind_param("s", $user);
        $stmt->execute();
        $stmt->bind_result($hashed_password);
        $stmt->fetch();

        if (password_verify($passw, $hashed_password)) {
            echo "Inicio de sesión exitoso.";
        } else {
            echo "Credenciales inválidas.";
        }
        $stmt->close();
    } elseif (isset($_POST['Registrarse'])) {
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

        $hashed_password = password_hash($passw, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO list_user_pag (Usuarios, Password, Email) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $user, $hashed_password, $email);

        if ($stmt->execute()) {
            echo "Registro exitoso. Ahora puedes iniciar sesión.";
        } else {
            echo "Error: " . $conn->error;
        }
        $stmt->close();
    }
    $conn->close();
}
?>