<?php
session_start();

// Verifica si el usuario ha iniciado sesión como aprendiz
if (!isset($_SESSION['profile']) || $_SESSION['profile'] !== 'aprendiz') {
    header("Location: login.php");
    exit();
}

// Obtén los datos del perfil del aprendiz
$grade = $_SESSION['grade'];
$jornada = $_SESSION['jornada'];

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

// Función para obtener las materias asignadas al aprendiz según su grado y jornada
function obtenerMateriasAsignadas($grado, $jornada, $conn) {
    // Realiza la consulta a la base de datos para obtener las materias asignadas al aprendiz
    // Utiliza las variables $grado y $jornada en la consulta
    // El resultado debe ser un conjunto de filas que contengan las materias asignadas al aprendiz

    // Ejemplo de consulta:
    $query = "SELECT subjects.subject_name, timetable.hour, timetable.instructor
              FROM timetable
              INNER JOIN subjects ON timetable.subject_id = subjects.id
              WHERE timetable.grade = '$grado'
              AND timetable.jornada = '$jornada'";

    // Ejecuta la consulta y obtiene el resultado
    $result = $conn->query($query);

    // Verifica si hay resultados
    if ($result->num_rows > 0) {
        // Crea una variable para almacenar las asignaciones de materias
        $materiasAsignadas = "";

        // Itera sobre cada fila de resultados
        while ($row = $result->fetch_assoc()) {
            $materia = $row['subject_name'];
            $hora = $row['hour'];
            $instructor = $row['instructor'];

            // Agrega la asignación de materia al texto
            $materiasAsignadas .= "$materia<br>Hora: $hora<br>Instructor: $instructor<br><br>";
        }

        // Retorna las materias asignadas al aprendiz
        return $materiasAsignadas;
    } else {
        // Si no hay resultados, retorna un mensaje indicando que no hay asignaciones
        return "No se encontraron materias asignadas";
    }
}

// Resto del código...
?>

<h3>Materias Asignadas</h3>

<p>A continuación se muestran las materias asignadas para tu grado (<?php echo $grado; ?>) y jornada (<?php echo $jornada; ?>):</p>

<?php
// Obtiene y muestra las materias asignadas al aprendiz
echo obtenerMateriasAsignadas($grado, $jornada, $conn);
?>

<p><a href="aprendiz.php">Cerrar sesión</a></p>
