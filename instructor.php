<!DOCTYPE html>
<html>
<head>
    <title>Perfil de Instructor</title>
</head>
<body>
    <h2>Bienvenido, Instructor!</h2>
    <p>Contenido exclusivo para instructores.</p>

    <h3>Asignar Jornada y Grado</h3>
    <form method="POST" action="asignar_jornada_grado.php">
        <label for="aprendiz_id">ID del Aprendiz:</label>
        <input type="text" id="aprendiz_id" name="aprendiz_id" required><br><br>

        <label for="jornada">Jornada:</label>
        <select id="jornada" name="jornada">
            <option value="mañana">Mañana</option>
            <option value="tarde">Tarde</option>
        </select><br><br>

        <label for="grado">Grado:</label>
        <select id="grado" name="grado">
            <?php
            // Conecta a la base de datos
            $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);
            if ($conn->connect_error) {
                die("La conexión a la base de datos falló: " . $conn->connect_error);
            }

            // Obtiene los grados de la tabla "grades"
            $gradesQuery = "SELECT * FROM grades";
            $gradesResult = $conn->query($gradesQuery);

            if ($gradesResult->num_rows > 0) {
                while ($row = $gradesResult->fetch_assoc()) {
                    echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                }
            }
            ?>
        </select><br><br>

        <input type="submit" name="asignar" value="Asignar">
    </form>

    <p><a href="logout.php">Cerrar sesión</a></p>
</body>
</html>
