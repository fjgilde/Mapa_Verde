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
                <?php if (isset($_SESSION['username'])): ?>
                    <li id="profile-container">
                        <a href="perfil.php">
                            <img src="<?php echo $_SESSION['PFP']; ?>" alt="Foto de perfil" id="profile-picture">
                        </a>
                    </li>
                <?php else: ?>
                    <li><a href="login.php" class="login-btn">Login</a></li>
                    <li><a href="registro.php" class="login-btn">Registro</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main class="login-main">        
        <form class="login-form" id="formulario" method="post">
            <div id="registroInicio" class="registroInicio">
                <h1 onclick="IniciarSesion()">Iniciar Sesión</h1>
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
            <div id="registro" name="registro"></div>
            <div class="forgot-link">
                <a href="forgot.php" class="Forgot">¿Olvidaste tu Contraseña?</a>
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
session_start();
require_once('db-connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['Iniciar_sesion'])) {
        $user = trim($_POST['username']);
        $passw = $_POST['password'];

        $stmt = $conn->prepare("SELECT * FROM list_user_pag WHERE Usuarios = ?");
        $stmt->bind_param("s", $user);
        $stmt->execute();
        $result = $stmt->get_result();

        $dummy_hash = '$2y$10$usesomesillystringforsalt$';

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $is_valid = password_verify($passw, $row['password']); // Usa el mismo nombre de columna que en el registro
        } else {
            $is_valid = password_verify($passw, $dummy_hash);
        }

        if ($is_valid && $result->num_rows > 0) {
            session_regenerate_id(true);
            $_SESSION['username'] = $row['Usuarios'];
            $_SESSION['Imagenpfp'] = $row['Imagenpfp'] ?? null;
            header("Location: index.php");
            exit();
        } else {
            echo "Credenciales inválidas.";
        }

        $stmt->close();
    }
    $conn->close();
}
?>