<?php
session_start();

// Configura los detalles de conexión a la base de datos
$host = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "rist";

// Conecta a la base de datos
$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);
if ($conn->connect_error) {
    die("La conexión a la base de datos falló: " . $conn->connect_error);
}

// Verifica si el nombre de usuario se ha guardado en la variable de sesión
if (isset($_SESSION['reset_username'])) {
    $username = $_SESSION['reset_username'];

    // Procesa el formulario de restablecimiento de contraseña cuando se envía
    if (isset($_POST['reset_password'])) {
        $newPassword = $_POST['new_password'];

        // Actualiza la contraseña en la base de datos para el usuario correspondiente
        $updateQuery = "UPDATE users SET password='$newPassword' WHERE username='$username'";
        if ($conn->query($updateQuery) === TRUE) {
            echo "¡Contraseña restablecida exitosamente!";
            // Elimina la variable de sesión
            unset($_SESSION['reset_username']);
            // Redirige al usuario a la página "logon.php"
            header("Location: login.php");
            exit();
        } else {
            echo "Error al restablecer la contraseña: " . $conn->error;
        }
    }
} else {
    // Si no se ha guardado el nombre de usuario en la variable de sesión, redirige al usuario al formulario de "Olvidé mi contraseña"
    header("Location: forgot_password.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Restablecer contraseña</title>
    <link rel="stylesheet" href="../css/reset.css">
</head>
<body>
    <div class="container">
    <form method="POST" action="reset_password.php" class="centered-form">
    <h2>Restablecer contraseña</h2>
        <label>Nueva contraseña:</label>
        <input type="password" name="new_password" required><br><br>
        <input type="submit" name="reset_password" value="Restablecer contraseña">
        <p>¿Recuerdas tu contraseña? <a href="login.php">Inicia sesión aquí</a></p>
    </form>
    </div>
</body>
</html>

