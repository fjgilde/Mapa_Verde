<?php

$conn = new mysqli('localhost', 'root', '', 'userspag');

if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

?>