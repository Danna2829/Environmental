<?php
require_once('conexionBD.php');
session_start();

error_reporting(0); // Desactiva todos los reportes de errores

// Verificar si el usuario está autenticado
if (!isset($_SESSION['documento'])) {
    header('Location: ../vista/inicio_sesion.html');
    exit;
}

$documento_usr = $_SESSION['documento'];

if (isset($_POST['btn_enviar'])) {
    $correo_usr = trim($_POST['correo']);
    $clave_ingresada = trim($_POST['passwords']);
    
    // Consultar la contraseña actual en la base de datos
    $query = "SELECT contrasena FROM usuarios WHERE documento=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $documento_usr);
    $stmt->execute();
    $stmt->bind_result($contrasena_db);
    $stmt->fetch();
    $stmt->close();

    // Verificar la contraseña
    if (password_verify($clave_ingresada, $contrasena_db)) {
        if (!empty($correo_usr)) {
            $foto_usr = $_FILES['foto']['name'];
            $foto_tmp = $_FILES['foto']['tmp_name'];

            // Preparar la consulta de actualización
            if ($foto_usr) {
                $foto_destino = "../recursos/img/" . $foto_usr;
                move_uploaded_file($foto_tmp, $foto_destino);
                $update_query = "UPDATE usuarios SET correo=?, foto_perfil=? WHERE documento=?";
                $stmt = $conn->prepare($update_query);
                $stmt->bind_param("sss", $correo_usr, $foto_usr, $documento_usr);
            } else {
                $update_query = "UPDATE usuarios SET correo=? WHERE documento=?";
                $stmt = $conn->prepare($update_query);
                $stmt->bind_param("ss", $correo_usr, $documento_usr);
            }

            if ($stmt->execute()) {
                $_SESSION['mensaje'] = "Perfil actualizado correctamente.";
            } else {
                $_SESSION['mensaje'] = "Error al actualizar el perfil: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $_SESSION['mensaje'] = "Por favor, complete todos los campos del formulario.";
        }
    } else {
        $_SESSION['mensaje'] = "Clave incorrecta. No se puede modificar el perfil.";
    }
}

header('Location: ../vista/cuenta_Usr.php');
exit;
?>
