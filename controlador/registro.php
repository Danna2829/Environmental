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

    // Verificar si el usuario ya está registrado
    $consulta_bd = "SELECT * FROM usuarios WHERE documento=?";
    $stmt = $conn->prepare($consulta_bd);
    $stmt->bind_param("s", $documento_usr);
    $stmt->execute();
    $datos = $stmt->get_result();

    if ($datos->num_rows > 0) {
        echo "EL USUARIO YA SE ENCUENTRA REGISTRADO";
        header('Location: ../vista/index.html');
        exit;
    }

    // Insertar nuevo usuario en la tabla usuarios
    $consulta2_bd = "INSERT INTO usuarios (nick_name, documento, correo, contrasena, foto_perfil, rol) VALUES (?, ?, ?, ?, ?, 'aprendiz')";
    $stmt = $conn->prepare($consulta2_bd);
    $stmt->bind_param("sssss", $nickname_usr, $documento_usr, $correo_usr, $contraseña_encriptada, $foto_usr);

    if ($stmt->execute()) {
        $_SESSION['documento'] = $documento_usr;

        // Obtener el ID del nuevo usuario
        $user_id = $conn->insert_id;

        // Insertar valores por defecto en la tabla 'ludica'
        $consulta_ludica = "INSERT INTO ludica (id_user, especies_transladadasC, especies_transladadasI, puntaje, animales_muertos, basuraT1correctas, basuraT2correctas, basuraT3correctas, arbolesP) VALUES (?, 0, 0, 0, 0, 0, 0, 0, 0)";
        $stmt_ludica = $conn->prepare($consulta_ludica);
        $stmt_ludica->bind_param("i", $user_id);
        $stmt_ludica->execute();

        // Insertar valores por defecto en la tabla 'actividad'
        $consulta_actividad = "INSERT INTO actividad (id_user, preguntas_correctas, preguntas_incorrectas, puntuacion) VALUES (?, 0, 0, 0)";
        $stmt_actividad = $conn->prepare($consulta_actividad);
        $stmt_actividad->bind_param("i", $user_id);
        $stmt_actividad->execute();

        header('Location: ../vista/inicio_sesion.html');
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
