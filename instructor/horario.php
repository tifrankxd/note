<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rist";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Insertar un nuevo horario para el aprendiz
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $grado_id = $_POST["grado"];
    $materia = $_POST["materia"];
    $dia = $_POST["dia"];
    $hora = $_POST["hora"];
    $instructor = $_POST["instructor"];

    $sql = "INSERT INTO horarios_aprendiz (grado_id, materia, dia, hora, instructor)
            VALUES ('$grado_id', '$materia', '$dia', '$hora', '$instructor')";

    if ($conn->query($sql) === true) {
        echo "Horario agregado correctamente.";
    } else {
        echo "Error al agregar el horario: " . $conn->error;
    }
}

// Consulta para obtener los horarios del aprendiz
$sql = "SELECT horarios_aprendiz.id, grados.nombre AS grado, horarios_aprendiz.materia, horarios_aprendiz.dia, horarios_aprendiz.hora, horarios_aprendiz.instructor
        FROM horarios_aprendiz
        INNER JOIN grados ON horarios_aprendiz.grado_id = grados.id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Horarios del Aprendiz</title>
    <link rel="stylesheet" href="../css/d.css">
    <link rel="stylesheet" href="../css/form.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/mode-dark.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>

 
    <div>
        <i class="fas fa-moon dark-mode-icon"></i>
        <a href="../login/logout.php"><i class="fas fa-sign-out-alt logout-icon"></i></a>
    </div>
</div>

<nav class="navbar">
  <a href="instructor.php" class="nav-link active">Inicio</a>
  <a href="horario.php" class="nav-link">Horario Asignacion</a>
</nav>

<div class="container">
    <h1>Horarios del Aprendiz</h1>

    <center>
        <table>
            <tr>
                <th>ID</th>
                <th>Grado</th>
                <th>Materia</th>
                <th>Día</th>
                <th>Hora</th>
                <th>Instructor</th>
            </tr>
            <?php
            // Mostrar los horarios del aprendiz en la tabla
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["grado"] . "</td>";
                    echo "<td>" . $row["materia"] . "</td>";
                    echo "<td>" . $row["dia"] . "</td>";
                    echo "<td>" . $row["hora"] . "</td>";
                    echo "<td>" . $row["instructor"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No se encontraron horarios.</td></tr>";
            }
            ?>
        </table>
    </center>

    <div class="add-horario-form">
        <h2>Agregar Horario</h2>
        <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
            <label for="grado">Grado:</label>
            <select name="grado" required>
                <option value="1">Grado 1</option>
                <option value="2">Grado 2</option>
                <!-- Agrega las opciones para los demás grados -->
            </select>

            <label for="materia">Materia:</label>
            <input type="text" name="materia" required>

            <label for="dia">Día:</label>
            <input type="text" name="dia" required>

            <label for="hora">Hora:</label>
            <input type="text" name="hora" required>

            <label for="instructor">Instructor:</label>
            <input type="text" name="instructor" required>

            <button type="submit">Agregar</button>
        </form>
    </div>

    <script>
        // Función para alternar el modo oscuro
        const darkModeIcon = document.querySelector('.dark-mode-icon');
        const body = document.querySelector('body');

        darkModeIcon.addEventListener('click', () => {
            body.classList.toggle('dark-mode');
        });
    </script>
</div>
 
</body>
</html>

<?php
// Cerrar la conexión a la base de datos
$conn->close();
?>