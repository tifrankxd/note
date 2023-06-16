<?php
session_start();

// Verifica si el usuario ha iniciado sesión como aprendiz
if (!isset($_SESSION['profile']) || $_SESSION['profile'] !== 'aprendiz') {
    header("Location: login.php");
    exit();
}

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

// Obtiene la asignación de grado y jornada para el aprendiz actual
$id = $_SESSION['id'];
$selectQuery = "SELECT grade_id, jornada, username FROM users WHERE id='$id'";
$result = $conn->query($selectQuery);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $gradeId = $row['grade_id'];
    $jornada = $row['jornada'];
    $username = $row['username'];
} else {
    $gradeId = "No asignado";
    $jornada = "No asignada";
    $username = "";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Perfil de Aprendiz</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* Estilos para el navbar */
        .navbar {
            background-color: #333;
            color: #fff;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .navbar a {
            color: #fff;
            text-decoration: none;
            margin-right: 10px;
        }

        .navbar .logout-icon,
        .navbar .dark-mode-icon {
            color: #fff;
            cursor: pointer;
            margin-left: 10px;
        }

        .grade-button {
            background-color: <?php echo ($gradeId !== 'No asignado') ? 'green' : 'red'; ?>;
            color: #fff;
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div>
            <span>Profile: <?php echo $username; ?></span>
        </div>
        <div>
            <a href="logout.php"><i class="fas fa-sign-out-alt logout-icon"></i></a>
        </div>
    </div>

    <h2>Bienvenido, Aprendiz!</h2>
    <p>Contenido exclusivo para aprendices.</p>
    <p>Grado asignado: <button class="grade-button"><?php echo $gradeId; ?></button></p>
    <p>Jornada asignada: <?php echo $jornada; ?></p>
    <p><a href="calendario.php">Cerrar sesión</a></p>
    <h3>Ver Mi Asignación</h3>

<form method="GET" action="">
    <label for="grado">Grado:</label>
    <select name="grado">
        <option value="Primero">Primero</option>
        <option value="Segundo">Segundo</option>
        <option value="Tercero">Tercero</option>
        <option value="Cuarto">Cuarto</option>
        <option value="Quinto">Quinto</option>
        <option value="Sexto">Sexto</option>
    </select><br><br>

    <label for="dia">Día:</label>
    <select name="dia">
        <option value="Lunes">Lunes</option>
        <option value="Martes">Martes</option>
        <option value="Miércoles">Miércoles</option>
        <option value="Jueves">Jueves</option>
        <option value="Viernes">Viernes</option>
    </select><br><br>

    <label for="hora">Hora:</label>
    <select name="hora">
        <option value="8:00 AM">8:00 AM</option>
        <option value="9:00 AM">9:00 AM</option>
        <option value="10:00 AM">10:00 AM</option>
        <option value="11:00 AM">11:00 AM</option>
        <option value="12:00 PM">ALMUERZO</option>
        <option value="1:00 PM">1:00 PM</option>
        <option value="2:00 PM">2:00 PM</option>
    </select><br><br>

    <input type="submit" name="verAsignacion" value="Ver Asignación">
</form>
<?php
if (isset($_GET['verAsignacion'])) {
    $grado = $_GET['grado'];
    $dia = $_GET['dia'];
    $hora = $_GET['hora'];

    $asignacionQuery = "SELECT subjects.subject_name, timetable.instructor
                        FROM timetable
                        INNER JOIN subjects ON timetable.subject_id = subjects.id
                        WHERE timetable.grade = '$grado'
                        AND timetable.day = '$dia'
                        AND timetable.hour = '$hora'";
    $asignacionResult = $conn->query($asignacionQuery);

    if ($asignacionResult->num_rows > 0) {
        $row = $asignacionResult->fetch_assoc();
        $materia = $row['subject_name'];
        $instructor = $row['instructor'];

        echo '<h4>Asignación:</h4>';
        echo '<p>Materia: ' . $materia . '</p>';
        echo '<p>Instructor: ' . $instructor . '</p>';
    } else {
        echo '<p>No se encontró ninguna asignación para el grado, día y hora seleccionados.</p>';
    }
}
?>

</body>
</html>



