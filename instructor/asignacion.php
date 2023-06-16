<?php
session_start();

// Verifica si el usuario ha iniciado sesión como instructor
if (!isset($_SESSION['profile']) || $_SESSION['profile'] !== 'instructor') {
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

// Obtener la lista de perfiles de aprendices con sus nombres de usuario, grados y jornadas
$selectQuery = "SELECT id, username, grade, jornada FROM users WHERE profile='aprendiz'";
$result = $conn->query($selectQuery);

// Procesar el formulario de asignación de jornada
if (isset($_POST['assign'])) {
    $aprendices = $_POST['aprendices'];
    $jornada = $_POST['jornada'];

    // Actualizar la jornada de los aprendices seleccionados
    foreach ($aprendices as $aprendizId) {
        $updateQuery = "UPDATE users SET jornada='$jornada' WHERE id='$aprendizId'";
        $conn->query($updateQuery);
    }
}

// Obtener las jornadas únicas de los aprendices
$jornadaQuery = "SELECT DISTINCT jornada FROM users WHERE profile='aprendiz'";
$jornadaResult = $conn->query($jornadaQuery);
$jornadas = array();

if ($jornadaResult->num_rows > 0) {
    while ($row = $jornadaResult->fetch_assoc()) {
        $jornadas[] = $row['jornada'];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Perfil de Instructor</title>
    <link rel="stylesheet" href="../css/hor.css">
    <link rel="stylesheet" href=
    "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    
<div class="navbar">
        <div>
            <span>Instructor: <?php echo $_SESSION['username']; ?></span>
        </div>
        <div>
            <i class="fas fa-moon dark-mode-icon" onclick="toggleDarkMode()"></i>
            <a href="instructor.php"><i class="fas fa-arrow-left back-icon"></i></a>
            <a href="../login/logout.php"><i class="fas fa-sign-out-alt logout-icon"></i></a>
        </div>
    </div>
       
    <div class="aprendiz-list">
        <h3>Lista de Aprendices</h3>
        <form method="POST" action="">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $aprendizId = $row['id'];
                    $aprendizUsername = $row['username'];
                    $aprendizGrade = $row['grade'];
                    $aprendizJornada = $row['jornada'];

                    echo '<div class="aprendiz-item">';
                    echo '<input type="checkbox" name="aprendices[]" value="' . $aprendizId . '">';
                    echo '<span>Username: ' . $aprendizUsername . ', Grado: ' . $aprendizGrade . ', Jornada: ' . $aprendizJornada . '</span>';
                    echo '</div>';
                }
            } else {
                echo '<p>No se encontraron aprendices.</p>';
            }
            ?>
            <div class="assign-form">
                <label for="jornada">Asignar Jornada:</label>
                <select name="jornada" id="jornada">
                    <option value="Mañana">Mañana</option>
                    <option value="Tarde">Tarde</option>
                    <option value="Noche">Noche</option>
                </select>
                <br>
                <input type="submit" name="assign" value="Asignar Jornada">
            </div>
        </form>
    </div>

    <div class="content">
        <h3>Aprendices</h3>
        <div class="jornada-filter">
            <label for="jornada-filter">Filtrar por jornada:</label>
            <select name="jornada-filter" id="jornada-filter">
                <option value="">Todos</option>
                <?php
                foreach ($jornadas as $jornada) {
                    echo '<option value="' . $jornada . '">' . $jornada . '</option>';
                }
                ?>
            </select>
        </div>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $aprendizUsername = $row['username'];
                $aprendizGrade = $row['grade'];
                $aprendizJornada = $row['jornada'];

                echo '<div class="aprendiz-profile">';
                echo '<p>Username: ' . $aprendizUsername . '</p>';
                echo '<p>Grado: ' . $aprendizGrade . '</p>';
                echo '<p>Jornada: ' . $aprendizJornada . '</p>';
                echo '</div>';
            }
        } else {
            echo '<p>No se encontraron aprendices.</p>';
        }
        ?>
    </div>
    <script>
        // Función para alternar el modo oscuro
        const darkModeIcon = document.querySelector('.dark-mode-icon');
        const body = document.querySelector('body');
        
        darkModeIcon.addEventListener('click', () => {
            body.classList.toggle('dark-mode');
        });
    </script>
</body>
</html>


