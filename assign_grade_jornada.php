<?php
session_start();

// Verificar si el usuario ha iniciado sesión como instructor
if ($_SESSION['profile'] !== 'instructor') {
    header("Location: login.php");
    exit();
}

// Verificar si se ha enviado el formulario de asignar grado y jornada
if (isset($_POST['assign_grade_jornada'])) {
    $user_id = $_POST['user_id'];
    $grade_id = $_POST['grade_id'];
    $jornada = $_POST['jornada'];

    // Actualizar la información de grado y jornada en la tabla users
    $updateQuery = "UPDATE users SET grade_id='$grade_id', jornada='$jornada' WHERE id='$user_id'";
    if ($conn->query($updateQuery) === TRUE) {
        echo "Grado y jornada asignados exitosamente al usuario.";
    } else {
        echo "Error al asignar grado y jornada: " . $conn->error;
    }
}
?>

