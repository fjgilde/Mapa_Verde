<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot</title>
    <link rel="stylesheet" href="estilo.css">
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

            formulario = document.getElementById("formulario").innerHTML= newformulario;
        
        }
    </script>
</body>
</html>
<?php
if($_SERVER['REQUEST_METHOD'] == "POST"){
    $conn = new mysqli('localhost', 'root', '', 'userspag');

    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    if(isset($_POST['btn'])){
        $user = $_POST['usuario'];
        $email = $_POST['email'];

        $check = $conn->prepare("SELECT Usuarios FROM list_user_pag WHERE Usuarios = ? OR Email = ?");
        $check->bind_param("ss", $user, $email);
        $check->execute();
        $check->store_result();
        
        $check->close();
    }else{
        echo "No se encontro el usuario o el email";
    }

    if(isset($_POST['Enviar'])){
    $passw = $_POST['repnewpass'];
    $chpass = $conn->prepare("UPDATE list_user_pag SET password: .$passw. where $check");
    }else{
        echo "Contraseña no valida";
    }

    $conn->close();
}
?>