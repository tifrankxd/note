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
    <a href="inicio.php" class="nav-link active">Inicio</a>
    <a href="horario.php" class="nav-link">Horario Asignado</a>
</nav>

<div class="container">
    <h1>Horario Asignado</h1>

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
                echo "<tr><td colspan='6'>No se encontraron horarios asignados.</td></tr>";
            }
            ?>
        </table>
    </center>

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
