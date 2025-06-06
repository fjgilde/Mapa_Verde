<?php
include('db-connect.php');
session_start();

$error = '';
$showPasswordForm = false;

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['Buscar'])) {
        $user = $_POST['usuario'] ?? '';
        $email = $_POST['email'] ?? '';

        $check = $conn->prepare("SELECT Usuarios FROM list_user_pag WHERE Usuarios = ? AND Email = ?");
        $check->bind_param("ss", $user, $email);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $_SESSION['reset_user'] = $user;
            $_SESSION['reset_email'] = $email;
            $showPasswordForm = true;
        } else {
            $error = "Usuario o email incorrectos";
        }
        $check->close();
    } 
    elseif (isset($_POST['Enviar'])) {
        $newpass = $_POST['newpass'] ?? '';
        $repnewpass = $_POST['repnewpass'] ?? '';
        
        if ($newpass !== $repnewpass) {
            $error = "Las contraseñas no coinciden";
            $showPasswordForm = true;
        } else {
            $chpass = $conn->prepare("UPDATE list_user_pag SET password = ? WHERE Usuarios = ? AND Email = ?");
            $chpass->bind_param("sss", $newpass, $_SESSION['reset_user'], $_SESSION['reset_email']);

            if ($chpass->execute()) {
                $error = "Contraseña actualizada correctamente";
                unset($_SESSION['reset_user']);
                unset($_SESSION['reset_email']);
                $showPasswordForm = false;
            } else {
                $error = "Error al actualizar contraseña";
                $showPasswordForm = true;
            }
            $chpass->close();
        }
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>
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
            <img id="logotipo" src="imagenes/imageniatierra.png">
            <div class="logo"><a class="logo" href="index.php">Mapa Verde</a></div>
            <ul class="nav-links">
                <li><a href="index.php">Inicio</a></li>
                <li><a href="login.php" class="login-btn">Login</a></li>
                <li><a href="registro.php" class="login-btn">Registro</a></li>
            </ul>
        </nav>
    </header>

    <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>

    <?php if (!$showPasswordForm): ?>
    <form class="login-form" method="post">
        <div>
            <label for='usuario'>Nombre de usuario: </label>
            <input type='text' id='usuario' name='usuario' required>
        </div>
        <br>
        <div>
            <label for='email'>Email: </label>
            <input type='email' id='email' name='email' required>
        </div>
        <br>
        <button type="submit" name="Buscar">Enviar Código</button>
    </form>
    <?php else: ?>
    <form class="login-form" method="post">
        <div>
            <label>Nueva Contraseña: </label>
            <input type="password" name="newpass" required>
        </div>
        <br>
        <div>
            <label>Repetir Contraseña: </label>
            <input type="password" name="repnewpass" required>
        </div>
        <br>
        <button type="submit" name="Enviar">Actualizar Contraseña</button>
    </form>
    <?php endif; ?>

    <footer>
        <p>&copy; 2024 Web Responsive. Hecho por Francisco Javier Gutierrez Ildefonso.</p>
    </footer>
</body>
</html>