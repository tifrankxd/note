

<!DOCTYPE html>
<html>
<head>
    <title>Horario del Instructor</title>
    <link rel="stylesheet" href="../css/hor.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    
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

    // Procesa el formulario de asignación de horarios
    if (isset($_POST['assign'])) {
        $materia = $_POST['materia'];
        $dia = $_POST['dia'];
        $hora = $_POST['hora'];
        $grado = $_POST['grado'];

        // Verifica si la hora seleccionada está ocupada por otro instructor
        $checkQuery = "SELECT * FROM timetable WHERE hour = '$hora' AND day = '$dia'";
        $resultCheck = $conn->query($checkQuery);

        if ($resultCheck->num_rows > 0) {
            // La hora está ocupada, muestra un mensaje de error
            echo '<p style="color: red;">La hora seleccionada está ocupada por otro instructor. Por favor, elige otra hora.</p>';
        } else {
            // Verifica si la materia seleccionada existe en la tabla subjects
            $checkSubjectQuery = "SELECT id FROM subjects WHERE subject_name = '$materia'";
            $resultSubjectCheck = $conn->query($checkSubjectQuery);

            if ($resultSubjectCheck->num_rows == 0) {
                // Si la materia no existe, la agrega a la tabla subjects
                $insertSubjectQuery = "INSERT INTO subjects (subject_name) VALUES ('$materia')";
                $conn->query($insertSubjectQuery);
            }

            // Inserta el horario en la tabla timetable
            $insertQuery = "INSERT INTO timetable (subject_id, instructor, hour, day, grade) VALUES ((SELECT id FROM subjects WHERE subject_name = '$materia'), '{$_SESSION['username']}', '$hora', '$dia', '$grado')";
            $conn->query($insertQuery);

            // Redirecciona al horario.php para evitar el reenvío del formulario
            header("Location: horario.php");
            exit();
        }
    }

    // Procesa el formulario de edición de materias
    if (isset($_POST['edit_subject'])) {
        $subjectId = $_POST['subject_id'];
        $newSubjectName = $_POST['new_subject_name'];

        // Actualiza el nombre de la materia en la tabla subjects
        $updateSubjectQuery = "UPDATE subjects SET subject_name = '$newSubjectName' WHERE id = '$subjectId'";
        $conn->query($updateSubjectQuery);

        // Redirecciona al horario.php para evitar el reenvío del formulario
        header("Location: horario.php");
        exit();
    }

    // Consulta las materias existentes
    $querySubjects = "SELECT * FROM subjects";
    $resultSubjects = $conn->query($querySubjects);
    ?>

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
     
    <h2>Horario del Instructor</h2>
    

   
    <form method="POST" action="">
      <h3>Asignar Horario</h3>
        <label for="materia">Materia:</label>
        <select name="materia">
            <option value="Matemáticas">Matemáticas</option>
            <option value="Lengua Castellana">Lengua Castellana</option>
            <option value="Humanidades Inglés">Humanidades Inglés</option>
            <option value="Ciencias Naturales">Ciencias Naturales</option>
            <option value="Ciencias Sociales">Ciencias Sociales</option>
            <option value="Tecnología e Informática">Tecnología e Informática</option>
            <option value="Educación Artística">Educación Artística</option>
            <option value="Ética y Religión">Ética y Religión</option>
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
            <?php
            $jornada = "";
            $horas = array('8:00 AM', '9:00 AM', '10:00 AM', '11:00 AM', 
            'ALMUERZO', '1:00 PM', '2:00 PM' ,'3:00PM');
            foreach ($horas as $hora) {
                if ($hora >= '7:00 AM' && $hora <= '11:59 AM') {
                    $jornada = "Mañana";
                } else {
                    $jornada = "Tarde";
                }
                echo '<option value="' . $hora . '">' . $hora . '</option>';
            }
            ?>
        </select><br><br>

        <label for="grado">Grado:</label>
        <select name="grado">
            <option value="Primero">Primero</option>
            <option value="Segundo">Segundo</option>
            <option value="Tercero">Tercero</option>
            <option value="Cuarto">Cuarto</option>
            <option value="Quinto">Quinto</option>
            <option value="Sexto">Sexto</option>
        </select><br><br>

        <input type="submit" name="assign" value="Asignar">
    </form>
    </div>

    <?php
    // Consulta los horarios asignados al instructor
    $queryHorarios = "SELECT timetable.id, subjects.subject_name, timetable.hour, timetable.day, timetable.grade
                      FROM timetable
                      INNER JOIN subjects ON timetable.subject_id = subjects.id
                      WHERE timetable.instructor = '{$_SESSION['username']}'";
    $resultHorarios = $conn->query($queryHorarios);
    ?>

</div>
</div>
</div>
<div class="table-container">
    <h3>Mis Horarios</h3>
    <table>
        <tr>
            <th>Materia</th>
            <th>Hora</th>
            <th>Día</th>
            <th>Grado</th>
        </tr>
        <?php
        if ($resultHorarios->num_rows > 0) {
            while ($row = $resultHorarios->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row['subject_name'] . '</td>';
                echo '<td>' . $row['hour'] . '</td>';
                echo '<td>' . $row['day'] . '</td>';
                echo '<td>' . $row['grade'] . '</td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="4">No tienes horarios asignados.</td></tr>';
        }
        ?>
    </table>
<div>
    <h3>Editar Materias</h3>
    <table>
        <tr>
            <th>Materia</th>
            <th>Editar</th>
        </tr>
        <?php
        if ($resultSubjects->num_rows > 0) {
            while ($row = $resultSubjects->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row['subject_name'] . '</td>';
                echo '<td>';
                echo '<form method="POST" action="">';
                echo '<input type="hidden" name="subject_id" value="' . $row['id'] . '">';
                echo '<input type="text" name="new_subject_name" placeholder="Nuevo nombre de la materia">';
                echo '<button type="submit" name="edit_subject" style="border: none; background: none; cursor: pointer;"><i class="fas fa-edit"></i></button>';
                echo '</form>';
                echo '</td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="2">No hay materias registradas.</td></tr>';
        }
        ?>
    </table>

    <?php
    // Cierra la conexión a la base de datos
    $conn->close();
    ?>
    <script>
        // Función para alternar el modo oscuro
        function toggleDarkMode() {
            const body = document.querySelector('body');
            body.classList.toggle('dark-mode');
        }
    </script>
   
</body>
</html>





    
