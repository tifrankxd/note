<?php
session_start();

// Verifica si el usuario ha iniciado sesión como aprendiz
if (!isset($_SESSION['username']) || $_SESSION['profile'] !== 'aprendiz') {
    // Si el usuario no ha iniciado sesión o no es un aprendiz, redirige al formulario de inicio de sesión
    header("Location: login.php");
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

// Obtiene la asignación de grado y jornada del usuario actual
$userId = $_SESSION['id'];
$query = "SELECT g.grade_name, u.jornada FROM users u
          INNER JOIN grades g ON u.grade_id = g.id
          WHERE u.id = '$userId' AND u.profile = 'aprendiz'";
$result = $conn->query($query);
$row = $result->fetch_assoc();

// Cierra la conexión a la base de datos
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Asignación de Grado y Jornada</title>
    <link rel="stylesheet" href="d.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        .container {
            max-width: 600px;
            margin: 0 auto;
        }

        .profile-info {
            margin-bottom: 20px;
        }

        .profile-info h2 {
            margin-bottom: 5px;
        }

        .profile-info p {
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="profile-info">
            <h2>Asignación de Grado y Jornada</h2>
            <p>Bienvenido, <?php echo $_SESSION['username']; ?></p>
        </div>

        <?php if ($row) : ?>
            <div class="profile-info">
                <h3>Tu asignación:</h3>
                <p>Grado: <?php echo $row['grade_name']; ?></p>
                <p>Jornada: <?php echo $row['jornada']; ?></p>
            </div>
        <?php else : ?>
            <p>No se ha asignado un grado y jornada.</p>
        <?php endif; ?>

        <p><a href="logout.php">Cerrar sesión</a></p>
    </div>
</body>
</html>
