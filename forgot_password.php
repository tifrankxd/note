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

// Procesa el formulario de "Olvidé mi contraseña" cuando se envía
if (isset($_POST['forgot_password'])) {
    $username = $_POST['username'];

    // Verifica si el nombre de usuario existe en la base de datos
    $checkQuery = "SELECT * FROM users WHERE username='$username'";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult->num_rows == 1) {
        // Guarda el nombre de usuario en una variable de sesión para usarlo en la página de restablecimiento de contraseña
        $_SESSION['reset_username'] = $username;

        // Redirige al usuario a la página de restablecimiento de contraseña
        header("Location: reset_password.php");
        exit();
    } else {
        echo "No se encontró ninguna cuenta con ese nombre de usuario.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Olvidé mi contraseña</title>
    <link rel="stylesheet" href="t.css">
</head>
<body>
    <div class="container">
        <form method="POST" action="forgot_password.php" class="centered-form">
            <h2>Olvidé mi contraseña</h2>
            <label>Nombre de usuario:</label>
            <input type="text" name="username" required><br>
            <input type="submit" name="forgot_password" value="Restablecer contraseña">
            <p>¿Recuerdas tu contraseña? <a href="login.php">Inicia sesión aquí</a></p>
        </form>
    </div>
</body>
</html>



