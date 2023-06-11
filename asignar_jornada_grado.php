<?php
session_start();

// Configura los detalles de conexión a la base de datos
$host = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "rest";

// Conecta a la base de datos
$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);
if ($conn->connect_error) {
    die("La conexión a la base de datos falló: " . $conn->connect_error);
}

// Obtén los datos del formulario
$aprendizID = $_POST['aprendiz_id'];
$jornada = $_POST['jornada'];
$gradoID = $_POST['grado'];

// Verifica si el aprendiz existe en la tabla "users"
$aprendizQuery = "SELECT * FROM users WHERE id='$aprendizID' AND profile='aprendiz'";
$aprendizResult = $conn->query($aprendizQuery);

if ($aprendizResult->num_rows > 0) {
    // El aprendiz existe, realiza la asignación de jornada y grado

    // Actualiza la jornada y grado del aprendiz en la tabla "users"
    $updateQuery = "UPDATE users SET jornada='$jornada', grado='$gradoID' WHERE id='$aprendizID'";
    if ($conn->query($updateQuery) === TRUE) {
        echo "Asignación exitosa.";
    } else {
        echo "Error al realizar la asignación: " . $conn->error;
    }
} else {
    echo "El ID del aprendiz no es válido o no corresponde a un perfil de aprendiz.";
}

// Redirige nuevamente a la vista del instructor
header("Location: instructor.php");
exit();
?>
