<?php

require_once('conexionBD.php');

// Asegúrate de que todas las variables se obtienen correctamente
$documento_usr = trim($_POST['documento']);
$foto_usr = trim($_POST['foto_perfil']);
$correo_usr = trim($_POST['correo']);

if (isset($_POST['btn_enviar']) && !empty($documento_usr) && !empty($foto_usr) && !empty($correo_usr)) {

    // Consultas SQL
    $consulta_bd = "SELECT documento, foto_perfil, correo FROM usuarios WHERE documento = ?";

    // Preparar la consulta
    if ($stmt = $conn->prepare($consulta_bd)) {
        $stmt->bind_param('s', $documento_usr);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            $arreglo_bd = $resultado->fetch_assoc();

            // Asignar variables a la base de datos
            $documentoBD = $arreglo_bd['documento'];    
            $fotoBD = $arreglo_bd['foto_perfil'];
            $correoBD = $arreglo_bd['correo'];

            // Comparar datos y actualizar si es necesario
            if ($documentoBD == $documento_usr && $fotoBD == $foto_usr && $correoBD == $correo_usr) {
                echo "No se realizarán cambios. La información es idéntica.";
                header('Location: ../vista/actividades.html');
                exit;
            } else {
                // Ejecutar la sentencia de actualización SQL
                $actualizacion = "UPDATE usuarios SET correo = ?, documento = ?, foto_perfil = ? WHERE documento = ?";

                // Preparar la consulta de actualización
                if ($stmt = $conn->prepare($actualizacion)) {
                    $stmt->bind_param('ssss', $correo_usr, $documento_usr, $foto_usr);
                    $stmt->execute();

                    if ($stmt->affected_rows > 0) {
                        echo "Datos actualizados correctamente.";
                    } else {
                        echo "No se realizaron cambios.";
                    }

                    $stmt->close();
                } else {
                    echo "Error al preparar la consulta de actualización.";
                }
            }
        } else {
            echo "No se encontró el usuario con el nickname proporcionado.";
        }

        $stmt->close();
    } else {
        echo "Error al preparar la consulta de selección.";
    }
} else {
    echo "Por favor, complete todos los campos del formulario.";
}

$conn->close();
?>
