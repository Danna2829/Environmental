<?php
require_once('conexionBD.php');
session_start();
error_reporting(0); // Desactiva todos los reportes de errores

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_actividad = $_POST['id_actividad'];
    $id_user = $_POST['id_user'];
    $codigo_actividad = $_POST['codigo_actividad'];
    $nombre = $_POST['nombre'];
    $preguntas_correctas = $_POST['preguntas_correctas'];
    $preguntas_incorrectas = $_POST['preguntas_incorrectas'];
    $puntuacion = $_POST['puntuacion'];

    // Aquí puedes conectarte a la base de datos y guardar los datos
    // Ejemplo:
    // $conn = new mysqli($servername, $username, $password, $dbname);
    // $sql = "INSERT INTO resultados (id_actividad, id_user, codigo_actividad, nombre, preguntas_correctas, preguntas_incorrectas, puntuacion) VALUES ('$id_actividad', '$id_user', '$codigo_actividad', '$nombre', '$preguntas_correctas', '$preguntas_incorrectas', '$puntuacion')";
    // $conn->query($sql);

    echo "Resultado guardado con éxito"; // Mensaje de éxito
} else {
    echo "Método no permitido";
}
?>
