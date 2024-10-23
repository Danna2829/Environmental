<?php
$servername = "localhost";
$username = "root"; // Nombre de usuario de MySQL
$password = ""; // Contraseña de MySQL
$database = "ea"; // Nombre de la base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Comprobar la conexión
// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Cerrar la conexión
//$conn->close();
?>
