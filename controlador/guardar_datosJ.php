<?php
// Incluir el archivo de conexión y empezar la sesión
require_once('../controlador/conexionBD.php');
session_start();

// Verificar que se hayan enviado todos los datos
if (isset($_POST['id_user'], $_POST['especies_transladadasC'], $_POST['especies_transladadasI'], $_POST['puntaje'], $_POST['animales_muertos'], $_POST['basuraT1correctas'], $_POST['basuraT2correctas'], $_POST['basuraT3correctas'], $_POST['arbolesP'])) {
    
    // Obtener los datos enviados desde el juego
    $id_user = $_POST['id_user'];
    $especies_transladadasC = $_POST['especies_transladadasC'];
    $especies_transladadasI = $_POST['especies_transladadasI'];
    $puntaje = $_POST['puntaje'];
    $animales_muertos = $_POST['animales_muertos'];
    $basuraT1correctas = $_POST['basuraT1correctas'];
    $basuraT2correctas = $_POST['basuraT2correctas'];
    $basuraT3correctas = $_POST['basuraT3correctas'];
    $arbolesP = $_POST['arbolesP'];

    // Verificar si el usuario ya tiene datos en la tabla ludica
    $sql_check = "SELECT * FROM ludica WHERE id_user = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("i", $id_user);
    $stmt_check->execute();
    $result = $stmt_check->get_result();

    if ($result->num_rows > 0) {
        // Si el usuario ya tiene datos, actualizar la entrada
        $sql_update = "UPDATE ludica SET 
                        especies_transladadasC = ?, 
                        especies_transladadasI = ?, 
                        puntaje = ?, 
                        animales_muertos = ?, 
                        basuraT1correctas = ?, 
                        basuraT2correctas = ?, 
                        basuraT3correctas = ?, 
                        arbolesP = ? 
                       WHERE id_user = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("iiiiiiiii", $especies_transladadasC, $especies_transladadasI, $puntaje, $animales_muertos, $basuraT1correctas, $basuraT2correctas, $basuraT3correctas, $arbolesP, $id_user);
        $stmt_update->execute();

        if ($stmt_update->affected_rows > 0) {
            echo "Datos actualizados correctamente.";
        } else {
            echo "Error al actualizar los datos.";
        }

    } else {
        // Si no hay datos, insertar una nueva entrada
        $sql_insert = "INSERT INTO ludica (id_user, especies_transladadasC, especies_transladadasI, puntaje, animales_muertos, basuraT1correctas, basuraT2correctas, basuraT3correctas, arbolesP) 
                       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("iiiiiiiii", $id_user, $especies_transladadasC, $especies_transladadasI, $puntaje, $animales_muertos, $basuraT1correctas, $basuraT2correctas, $basuraT3correctas, $arbolesP);
        $stmt_insert->execute();

        if ($stmt_insert->affected_rows > 0) {
            echo "Datos guardados correctamente.";
        } else {
            echo "Error al guardar los datos.";
        }
    }

} else {
    echo "Faltan datos.";
}

// Cerrar la conexión
$conn->close();
?>
