<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/estilo.css">
    <style>
       body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            align-items: center;
            max-width: 400px;
            max-width: 400px;
            width: 100%;
        }
        .login-container h2 {
            margin-bottom: 20px;
            font-size: 24px;
            text-align: center;
        }
        .login-form {
            max-width: 400px;
            margin: 0 auto;
            margin-top: 15px;
            padding: 20px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
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

    if (isset($_POST['Registrarse'])) {
        $user = trim($_POST['username']);
        $passw = $_POST['password'];
        $email = trim($_POST['email']);

        // Puedes validar el email aquí si lo deseas
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "Email no válido.";
            exit();
        }

        $hashedPassword = password_hash($passw, PASSWORD_DEFAULT);

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
        $stmt->bind_param("sss", $user, $hashedPassword, $email);

        if ($stmt->execute()) {
            $stmt->close();
            header("Location: login.php?registro=ok"); // Puedes mostrar un mensaje en login.php si quieres
            exit();
        } else {
            echo "Error: " . htmlspecialchars($conn->error);
        }
        $stmt->close();
    }
    $conn->close();
}
?>