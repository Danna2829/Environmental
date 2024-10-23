<?php
session_start();
require_once('conexionBD.php'); // Asegúrate de que la ruta a tu archivo de conexión sea correcta

// Consulta SQL para obtener todos los registros de la tabla 'usuarios'
$sql4 = "SELECT * FROM usuarios";
$datosBD = mysqli_query($conn, $sql4);

// Verificar si se obtuvieron resultados
if (mysqli_num_rows($datosBD) > 0) {
    // Iterar a través de los resultados
    while ($arreglop = mysqli_fetch_assoc($datosBD)) {
        // Generar el contenido HTML dentro de PHP
        echo '<tr>';
        echo '<td><input type="checkbox" name="seleccion[]" value="' . htmlspecialchars($arreglop['nick_name']) . '"></td>';
        // Mostrar la foto de perfil. Asumiendo que la columna 'foto_perfil' contiene una URL o ruta válida a la imagen.
        echo '<td><img src="' . htmlspecialchars($arreglop['foto_perfil']) . '" alt="Foto de perfil" style="width: 50px; height: 50px; object-fit: cover;"></td>';
        echo '<td>' . htmlspecialchars($arreglop['nick_name']) . '</td>';
        echo '<td><a href="actualizar.php?id_es=' . urlencode($arreglop['nick_name']) . '">MODIFICAR</a></td>';
        echo '<td><a href="eliminar.php?id_es=' . urlencode($arreglop['nick_name']) . '">ELIMINAR</a></td>';
        echo '</tr>';
    }
} else {
    // Si no hay resultados
    echo '<tr><td colspan="5">No hay datos disponibles</td></tr>';
}
?>
