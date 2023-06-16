<?php
session_start();

// Verifica si el usuario ha iniciado sesión como instructor
if (!isset($_SESSION['username']) || $_SESSION['profile'] !== 'instructor') {
    // Si el usuario no ha iniciado sesión o no es un instructor, redirige al formulario de inicio de sesión
    header("Location: ../login/login.php");
    exit();
}

// Configura los detalles de conexión a la base de datos
$host = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "rest";

// Establece la conexión a la base de datos
$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);
if ($conn->connect_error) {
    die("La conexión a la base de datos falló: " . $conn->connect_error);
}

// Procesa el formulario de calificación
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['learner_id'], $_POST['semester_id'], $_POST['grade'])) {
        $learnerId = $_POST['learner_id'];
        $semesterId = $_POST['semester_id'];
        $grade = $_POST['grade'];

        // Verifica si el aprendiz y el semestre existen en la base de datos
        $checkQuery = "SELECT id FROM learners WHERE id = '$learnerId'";
        $resultCheck = $conn->query($checkQuery);

        if ($resultCheck->num_rows > 0) {
            // Inserta la calificación en la tabla semesters
            $insertQuery = "INSERT INTO semesters (learner_id, instructor, semester_id, grade) VALUES ('$learnerId', '{$_SESSION['username']}', '$semesterId', '$grade')";
            $conn->query($insertQuery);

            echo "Calificación exitosa.";
        } else {
            echo "El aprendiz no existe.";
        }
    } else {
        echo "Error: Faltan campos requeridos en el formulario.";
    }
}

// Consulta los datos de los aprendices y los semestres
$queryLearners = "SELECT * FROM learners";
$resultLearners = $conn->query($queryLearners);

$querySemesters = "SELECT * FROM semesters";
$resultSemesters = $conn->query($querySemesters);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Calificar Aprendices</title>
</head>
<body>
    <h2>Calificar Aprendices</h2>
    
    <form method="POST" action="">
        <label for="learner_id">Aprendiz:</label>
        <select name="learner_id">
            <?php
            if ($resultLearners->num_rows > 0) {
                while ($row = $resultLearners->fetch_assoc()) {
                    echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                }
            } else {
                echo '<option value="">No hay aprendices disponibles</option>';
            }
            ?>
        </select><br><br>

        <label for="semester_id">Semestre:</label>
        <select name="semester_id">
            <?php
            if ($resultSemesters->num_rows > 0) {
                while ($row = $resultSemesters->fetch_assoc()) {
                    echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                }
            } else {
                echo '<option value="">No hay semestres disponibles</option>';
            }
            ?>
        </select><br><br>

        <label for="grade">Calificación:</label>
        <input type="text" name="grade"><br><br>

        <input type="submit" value="Calificar">
    </form>

    <?php
    // Cierra la conexión a la base de datos
    $conn->close();
    ?>
</body>
</html>

