<?php
session_start();

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

// Procesa el formulario de registro cuando se envía
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $profile = $_POST['profile'];

    // Verifica si el nombre de usuario ya está en uso
    $checkQuery = "SELECT * FROM users WHERE username='$username'";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult->num_rows > 0) {
        // El nombre de usuario ya está en uso
        echo "El nombre de usuario ya está en uso. Por favor, elige otro.";
    } else {
        // Inserta el nuevo usuario en la base de datos
        $insertQuery = "INSERT INTO users (username, password, profile) VALUES ('$username', '$password', '$profile')";
        if ($conn->query($insertQuery) === TRUE) {
            // Registro exitoso, redirige al usuario a la página de inicio de sesión
            header("Location: login.php");
            exit();
        } else {
            echo "Error al registrar el usuario: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registro</title>
    <link rel="stylesheet" href="register.css">
</head>
<body>
<div class="bgAnimation" id="bgAnimation">
        <div class="backgroundAmim"></div>
    </div>
    <form method="POST" action="register.php">
    <h2>Registro</h2>
        <label>Nombre de usuario:</label>
        <input type="text" name="username" required><br><br>
        
        <label>Contraseña:</label>
        <input type="password" name="password" required><br><br>
        
        <label>Perfil:</label>
        <select name="profile">
            <option value="instructor">Instructor</option>
            <option value="aprendiz">Aprendiz</option>
        </select><br><br>
        
        <input type="submit" name="register" value="Registrar">

        <p class="form-link"><a href="login.php">Inicia sesión aquí</a></p>
    </form>
    
    <script src="script.js"></script>
</body>
</html>



