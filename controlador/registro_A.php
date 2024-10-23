<?php

require_once('conexionBD.php');
session_start();

if (isset($_POST['btn_enviar']) && !empty($_POST['nick']) && !empty($_POST['documento']) && !empty($_POST['correo']) && !empty($_POST['passwords']) && !empty($_POST['foto'])) {

    $nickname_usr = trim($_POST['nick']);
    $documento_usr = trim($_POST['documento']);
    $correo_usr = trim($_POST['correo']);
    $passwd_usr = trim($_POST['passwords']);
    $foto_usr = trim($_POST['foto']);
    $contraseña_encriptada = password_hash($passwd_usr, PASSWORD_DEFAULT);

    // Consulta para verificar si el usuario ya está registrado
    $consulta_bd = "SELECT * FROM usuarios WHERE documento=?";
    $stmt = $conn->prepare($consulta_bd);
    $stmt->bind_param("s", $documento_usr);
    $stmt->execute();
    $datos = $stmt->get_result();

    if ($datos->num_rows > 0) {
        echo "EL USUARIO YA SE ENCUENTRA REGISTRADO";
        header('Location: ../vista/registro_A.html');
        exit;
    }

    // Consulta para insertar un nuevo usuario con rol 'administrador'
    $consulta2_bd = "INSERT INTO usuarios (nick_name, documento, correo, contrasena, foto_perfil, rol) VALUES (?, ?, ?, ?, ?, 'administrador')";
    $stmt = $conn->prepare($consulta2_bd);
    $stmt->bind_param("sssss", $nickname_usr, $documento_usr, $correo_usr, $contraseña_encriptada, $foto_usr);

    if ($stmt->execute()) {
        $_SESSION['documento'] = $documento_usr;
        header('Location: ../vista/inicio_sesion_A.html');
        exit;
    } else {
        echo "Error al registrar el usuario. Inténtalo de nuevo.";
    }

} else {
    echo '<script>
    alert("Por favor, complete todos los campos del formulario");
    window.history.go(-1);
    </script>';
    exit;
}

?>
