<?php
require_once('conexionBD.php');
session_start();

if (isset($_POST['btn_enviar']) && !empty($_POST['nick']) && !empty($_POST['documento']) && !empty($_POST['correo']) && !empty($_POST['passwords']) && !empty($_POST['rol'])) {

    $nickname_usr = trim($_POST['nick']);
    $documento_usr = trim($_POST['documento']);
    $correo_usr = trim($_POST['correo']);
    $passwd_usr = trim($_POST['passwords']);
    $rol_usr = trim($_POST['rol']);
    $foto_usr = $_FILES['foto']['name'];
    $foto_tmp = $_FILES['foto']['tmp_name'];
    $contraseña_encriptada = password_hash($passwd_usr, PASSWORD_DEFAULT);

    // Comprobar si el documento ya está registrado
    $consulta_bd = "SELECT * FROM usuarios WHERE documento=?";
    $stmt = $conn->prepare($consulta_bd);
    $stmt->bind_param("s", $documento_usr);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "El usuario ya se encuentra registrado.";
        exit;
    }

    // Preparar la consulta para insertar el nuevo usuario
    if ($foto_usr) {
        $foto_destino = "../recursos/img/" . $foto_usr;
        move_uploaded_file($foto_tmp, $foto_destino);
        $consulta2_bd = "INSERT INTO usuarios (nick_name, documento, correo, contrasena, foto_perfil, rol) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($consulta2_bd);
        $stmt->bind_param("ssssss", $nickname_usr, $documento_usr, $correo_usr, $contraseña_encriptada, $foto_usr, $rol_usr);
    } else {
        $consulta2_bd = "INSERT INTO usuarios (nick_name, documento, correo, contrasena, rol) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($consulta2_bd);
        $stmt->bind_param("sssss", $nickname_usr, $documento_usr, $correo_usr, $contraseña_encriptada, $rol_usr);
    }

    if ($stmt->execute()) {
        echo "Cuenta creada exitosamente.";
        header('Location: ../vista/administrador.php');
        exit;
    } else {
        echo "Error al crear la cuenta: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo '<script>
    alert("Por favor, complete todos los campos del formulario");
    window.history.go(-1);
    </script>';
    exit;
}
?>
