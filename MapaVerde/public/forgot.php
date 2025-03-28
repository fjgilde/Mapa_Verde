<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">Mapa verde</div>
            <ul class="nav-links">
                <li><a href="index.html">Inicio</a></li>
                <li><a href="login.php" class="login-btn">Login</a></li>
            </ul>
        </nav>
    </header>

    <form class="login-form" id="formulario" method="post">
    <br>
    <div>
        <label for='Usuario'>Nombre de usuario: </label>
        <input type='text' id='usuario' name='usuario'>    
    </div>
    <br>
    <div>
        <label for='email'>Email: </label>
        <input type='email' id='email' name='email'>    
    </div>
    <br>
    <button type="submit" id="btn" name="btn" onclick="eliminarform()">Enviar Codigo al email</button>
    </form>


    <footer>
        <p>&copy; 2024 Web Responsive. Hecho por Francisco Javier Gutierrez Ildefonso.</p>
    </footer>
    <script>
        let formulario = document.getElementById("formulario")
        function eliminarform(){
        let newformulario = `<form class="login-form" id="formulario" method="POST">
        <div>
        <label>Nueva Contraseña: </label>
        <input type="password" id="newpass" name="newpass">
        </div>
        <br>
        <div>
        <label>Repetir Contraseña: </label>
        <input type="password" id="repnewpass" name="repnewpass">
        </div>
        <br>
        <button id="Enviar" name="Enviar" type="submit">Enviar</button>
        </form>`;

            formulario.innerHTML= newformulario;
        }
        function validarpassw(){
            let newpass = document.getElementById("newpass");
            let repnewpass = document.getElementById("repnewpass");

                let newformulario = `<form class="login-form" id="formulario" method="post">
                 <br>
                <div>
                <label for='Usuario'>Nombre de usuario: </label>
                <input type='text' id='usuario' name='usuario'>    
                </div>
                <br>
                <div>
                <label for='email'>Email: </label>
                <input type='email' id='email' name='email'>    
                </div>
                <br>
                <button type="submit" id="btn" name="btn" onclick="eliminarform()">Enviar Codigo al email</button>
                </form>`;
                formulario.innerHTML= newformulario;
            
        }
    </script>
</body>
</html>
<?php
require_once('db-connect.php');
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $passw = $_POST['repnewpass'];
    $newpass = $_POST['newpass'];
    $user = $_POST['usuario'];
    $email = $_POST['email'];

    if (isset($_POST['btn'])) {
        $check = $conn->prepare("SELECT Usuarios FROM list_user_pag WHERE Usuarios = ? OR Email = ?");
        $check->bind_param("ss", $user, $email);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            echo "Usuario encontrado. Por favor, introduzca la nueva contraseña.";
        } else {
            echo "No se encontró el usuario o el email.";
        }

        $check->close();
    }

    if (isset($_POST['Enviar'])) {
        if ($newpass !== $passw) {
            echo "Las contraseñas no coinciden.";
        } else {
            $hashed_password = password_hash($newpass, PASSWORD_DEFAULT);
            $chpass = $conn->prepare("UPDATE list_user_pag SET password = ? WHERE Usuarios = ? OR Email = ?");
            $chpass->bind_param("sss", $hashed_password, $user, $email);

            if ($chpass->execute()) {
                echo "Contraseña actualizada con éxito.";
            } else {
                echo "Error al actualizar la contraseña.";
            }

            $chpass->close();
        }
    }

    $conn->close();
}
?>