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

// Procesa el formulario de inicio de sesión cuando se envía
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Consulta la base de datos para verificar las credenciales del usuario
    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        // El inicio de sesión fue exitoso
        $row = $result->fetch_assoc();
        $_SESSION['username'] = $row['username'];
        $_SESSION['profile'] = $row['profile'];

        // Redirige al usuario a la página correspondiente según su perfil
        if ($row['profile'] == 'instructor') {
            header("Location: ../instructor/instructor.php");
            exit();
        } elseif ($row['profile'] == 'aprendiz') {
            header("Location: ../aprendiz/inicio.php");
            exit();
        }
    } else {
        // Las credenciales son inválidas
        echo "<style>";
        echo ".error-message {";
        echo "    position: fixed;";
        echo "    top: 50%;";
        echo "    left: 50%;";
        echo "    transform: translate(-50%, -50%);";
        echo "    padding: 20px;";
        echo "    background-color: #f44336;";
        echo "    color: white;";
        echo "    font-size: 18px;";
        echo "    font-weight: bold;";
        echo "    animation: shake 0.5s ease-in-out;";
        echo "    animation-fill-mode: forwards;";
        echo "}";
        echo ".fade-out {";
        echo "    animation: fadeOut 2s linear forwards;";
        echo "}";
        echo "@keyframes shake {";
        echo "    0% { transform: translate(-50%, -50%) rotate(0deg); }";
        echo "    20% { transform: translate(-50%, -50%) rotate(-5deg); }";
        echo "    40% { transform: translate(-50%, -50%) rotate(5deg); }";
        echo "    60% { transform: translate(-50%, -50%) rotate(-5deg); }";
        echo "    80% { transform: translate(-50%, -50%) rotate(5deg); }";
        echo "    100% { transform: translate(-50%, -50%) rotate(0deg); }";
        echo "}";
        echo "@keyframes fadeOut {";
        echo "    0% { opacity: 1; }";
        echo "    100% { opacity: 0; }";
        echo "}";
        echo "</style>";
        echo "<div class='error-message fade-out'>Nombre de usuario o contraseña incorrectos</div>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="notebook.png" type="image/png">

</head>
<body>
    <div class="bgAnimation" id="bgAnimation">
        <div class="backgroundAmim"></div>
    </div>
    <form class="login-form" method="POST" action="login.php" >
        <div class="form-header">
            <h2>Iniciar sesión</h2>
        </div>
        <div class="form-group">
            <label for="username">USUARIO:</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">CONTRASEÑA:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <input type="submit" name="submit" value="Iniciar sesión" class="submit-btn">
        <p class="form-link"><a href="register.php">Regístrate aquí</a></p>
        <p class="form-link"><a href="forgot_password.php">Restablecer contraseña</a></p>
    </form>
    <audio controls autoplay >
        <source src="epic.mp3" type="audio/mpeg">
    </audio>
    <script src="script.js"></script>
</body>
</html>





