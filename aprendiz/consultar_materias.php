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

// Consulta para obtener las materias
$sql = "SELECT DISTINCT materia FROM horarios_aprendiz";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Consultar Materias</title>
    <link rel="stylesheet" href="../css/d.css">
    <link rel="stylesheet" href="../css/horario.css">
    <link rel="stylesheet" href="../css/table.css">
    <link rel="stylesheet" href="../css/consultar_materias.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
<div class="navbar">
    <div>
        <i class="fas fa-moon dark-mode-icon"></i>
        <a href="../login/logout.php"><i class="fas fa-sign-out-alt logout-icon"></i></a>
    </div>
</div>

<div class="navbar">
    <a href="inicio.php" class="active">Inicio</a>
    <a href="horario.php">Horarios</a>
    <a href="calificaciones.php">Calificaciones</a>
    <a href="consultar_materias.php">Consultar</a>
</div>

<div class="container">
    <h1>Consultar Materias</h1>

    <center>
        <table>
            <tr>
                <th>Materia</th>
            </tr>
            <?php
            // Mostrar las materias en la tabla
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["materia"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td>No se encontraron materias.</td></tr>";
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
