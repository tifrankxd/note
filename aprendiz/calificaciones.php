<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rist";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta SQL para obtener las notas de los aprendices
$sql = "SELECT alumnos.nombres, alumnos.apellidos, materias.nombre AS materia, notas.nota, notas.observaciones
        FROM notas
        INNER JOIN alumnos ON notas.id_alumno = alumnos.id
        INNER JOIN materias ON notas.id_materia = materias.id";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Notas de Aprendices</title>
    
    <link rel="stylesheet" href="../css/d.css">
     
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
         table {
    border-collapse: collapse;
    width: 100%;
  }
  
  th, td {
    padding: 8px;
    text-align: left;
    border-bottom: 1px solid #ddd;
  }
  
  th {
    background-color: #4caf50;
    color: white;
  }
  
  tr:nth-child(even) {
    background-color: #99A3A4;
  }
  
  tr:hover {
    background-color: #ffd700;
  }
  
  .container {
    background-image: url("../IMG/estudiante.jpg");
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }
    </style>
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
  <a href="calificaciones.php">calificaciones</a>
  <a href="consultar_materias.php">consulta</a>
</div>
<div class="container">
<h1>Notas de Aprendices</h1>


    <table>
        <tr>
            <th>Aprendiz</th>
            <th>Materia</th>
            <th>Nota</th>
            <th>Observaciones</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["nombres"] . " " . $row["apellidos"] . "</td>";
                echo "<td>" . $row["materia"] . "</td>";
                echo "<td>" . $row["nota"] . "</td>";
                echo "<td>" . $row["observaciones"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No hay notas disponibles.</td></tr>";
        }
        ?>
    </table>
    
    

    <?php
    $conn->close();
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
