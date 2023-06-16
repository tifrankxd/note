<?php
session_start();

// Verifica si el usuario ha iniciado sesión como instructor
if (!isset($_SESSION['username']) || $_SESSION['profile'] !== 'instructor') {
    // Si el usuario no ha iniciado sesión o no es un instructor, redirige al formulario de inicio de sesión
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

// Consulta los aprendices y sus grados asignados
$query = "SELECT users.username, users.grade, users.jornada
          FROM users
          WHERE users.profile = 'aprendiz'";
$result = $conn->query($query);

// Cierra la conexión a la base de datos
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Grados de Aprendices</title>
    <link rel="stylesheet" href="../css/d.css">
    <link rel="stylesheet" href="../css/grado.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
   
    <script>
        // Función para alternar el modo oscuro
        function toggleDarkMode() {
            const body = document.querySelector('body');
            body.classList.toggle('dark-mode');
        }
    </script>
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

    <div class="container">
  <div class="hexagon-container">
    <div class="hexagon" onclick="transformHexagon(this)">
      <div class="hexagon-front"></div>
      <div class="hexagon-back"></div>
      <a > esta pagina es gratis</a>
    </div>
  </div>
  
    <table class="table">
      <tr>
        <th class="aprendiz">Aprendiz</th>
        <th class="jornada">Jornada</th>
        <th class="grado">Grado</th>
      </tr>

      <?php
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo '<tr>';
          echo '<td>' . $row['username'] . '</td>';
          echo '<td>' . $row['jornada'] . '</td>';
          echo '<td>' . $row['grade'] . '</td>';
          echo '</tr>';
        }
      } else {
        echo '<tr><td colspan="3">No hay aprendices registrados.</td></tr>';
      }
      ?>
    </table>
    <div class="hexagon-container">
    <div class="hexagon" onclick="transformHexagon(this)">
      <div class="hexagon-front"></div>
      <div class="hexagon-back"></div>
    </div>
  </div>
    
  <div class="loading-container">
    <h3>Loading<span class="loading-dots"></span></h3>
    <div class="loading-bar"></div>
  </div>
</div>


<script>function transformHexagon(hexagon) {
  hexagon.classList.toggle('pro');
}

</script>
</body>
</html>


