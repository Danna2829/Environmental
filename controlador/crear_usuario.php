<?php
require_once('conexionBD.php');
session_start();

if (isset($_POST['edit-btn'])) {
    // Recoger y sanitizar los datos del formulario
    $nombre_usr = trim($_POST['nombre']);
    $documento_usr = trim($_POST['documento']);
    $correo_usr = trim($_POST['correo']);
    $passwd_usr = trim($_POST['password']);
    $rol_usr = trim($_POST['rol']);
    
    // Comprobar que todos los campos no estén vacíos
    if (!empty($nombre_usr) && 
        !empty($documento_usr) && 
        !empty($correo_usr) && 
        !empty($passwd_usr) && 
        !empty($rol_usr) && 
        isset($_FILES['foto']) && 
        $_FILES['foto']['error'] == 0) {

        // Encriptar la contraseña
        $contraseña_encriptada = password_hash($passwd_usr, PASSWORD_DEFAULT);

        // Manejo de la foto de perfil
        $foto_usr = $_FILES['foto']['name'];
        $ruta_temp = $_FILES['foto']['tmp_name'];
        $ruta_destino = 'uploads/' . basename($foto_usr);

        // Subir el archivo
        if (move_uploaded_file($ruta_temp, $ruta_destino)) {
            // Verificar si el documento ya está registrado
            $consulta_bd = "SELECT * FROM usuarios WHERE documento='$documento_usr'";
            $datos = mysqli_query($conn, $consulta_bd);

            if (mysqli_num_rows($datos) > 0) {
                echo "EL USUARIO YA SE ENCUENTRA REGISTRADO";
                header('Location: ../vista/administrador.php');
                exit;
            }

            // Insertar el nuevo usuario en la base de datos
            $consulta2_bd = "INSERT INTO usuarios (nombre, documento, correo, contrasena, rol, foto_perfil) VALUES ('$nombre_usr', '$documento_usr', '$correo_usr', '$contraseña_encriptada', '$rol_usr', '$foto_usr')";
            $almacenar = mysqli_query($conn, $consulta2_bd);

            // Comprobar si se insertó correctamente
            if ($almacenar) {
                $_SESSION['documento'] = $documento_usr;
                header('Location: ../vista/administrador.php');
                exit;
            } else {
                echo "Error al registrar el usuario: " . mysqli_error($conn);
            }
        } else {
            echo "Error al subir la foto. Inténtalo de nuevo.";
        }
    } else {
        echo '<script>
        alert("Por favor, complete todos los campos del formulario");
        window.history.go(-1);
        </script>';
        exit;
    }
} else {
    echo "Método de solicitud no permitido.";
}
?>
