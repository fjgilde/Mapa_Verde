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
        #profile-container {
            display: inline-block;
            margin-left: 20px;
        }
        #profile-picture {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            object-fit: cover;
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
        $user = $_POST['username'];
        $passw = $_POST['password'];

        $stmt = $conn->prepare("SELECT * FROM list_user_pag WHERE Usuarios = ? AND Password = ?");
        $stmt->bind_param("ss", $user, $passw);

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION['username'] = $row['Usuarios'];
            $_SESSION['PFP'] = $row['ProfilePicture'];
            
            header("Location: index.php");
            die();
        } else {
            echo "Credenciales inválidas.";
        }

        $stmt->close();
    }
    $conn->close();
}
?>