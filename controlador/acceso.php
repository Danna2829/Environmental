<?php
require_once('conexionBD.php');
session_start();
error_reporting(0); // Desactiva todos los reportes de errores


if (isset($_POST['btn_login']) && !empty($_POST['nick_name']) && !empty($_POST['password'])) {

    $nick_name_usr = trim($_POST['nick_name']);
    $passwd_usr = trim($_POST['password']);

    // Consulta para verificar el usuario
    $consulta_bd = "SELECT * FROM usuarios WHERE nick_name=?";
    $stmt = $conn->prepare($consulta_bd);
    $stmt->bind_param("s", $nick_name_usr);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();
        $contraseña_encriptada = $usuario['contrasena'];

        // Verificar la contraseña
        if (password_verify($passwd_usr, $contraseña_encriptada)) {
            // Guardar información del usuario en la sesión
            $_SESSION['documento'] = $usuario['documento']; // Puedes usar cualquier campo único
            $_SESSION['nick_name'] = $usuario['nick_name'];

            // Redirigir a la página de perfil de usuario
            header('Location: ../vista/cuenta_Usr.php');
            exit;
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "Usuario no encontrado.";
    }

    $stmt->close();
} else {
    echo '<script>
    alert("Por favor, complete todos los campos del formulario");
    window.history.go(-1);
    </script>';
    exit;
}
?>
