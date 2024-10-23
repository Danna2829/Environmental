<?php
require_once('../controlador/conexionBD.php');
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['documento'])) {
    header('Location: ../vista/inicio_sesion.html');
    exit;
}

$documento_usr = $_SESSION['documento'];

// Eliminar la cuenta del usuario
$query = "DELETE FROM usuarios WHERE documento=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $documento_usr);
$stmt->execute();

// Cerrar sesión y redirigir a la página principal
session_destroy();
header('Location: ../index.html');
exit;
?>
