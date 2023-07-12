<?php
session_start();

// Verifica si el usuario ha iniciado sesión como aprendiz
if (!isset($_SESSION['username']) || $_SESSION['profile'] !== 'aprendiz') {
    // Si el usuario no ha iniciado sesión o no es un aprendiz, redirige al formulario de inicio de sesión
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Perfil de Aprendiz</title>
    <link rel="stylesheet" href="../css/d.css">
    <link rel="stylesheet" href="../css/aprendiz.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <div class="navbar">
        <div>
            <span>Bienvenido, Aprendiz: <?php echo $_SESSION['username']; ?></span>
        </div>
        <div>
            <i class="fas fa-moon dark-mode-icon"></i>
            <a href="../login/logout.php"><i class="fas fa-sign-out-alt logout-icon"></i></a>
        </div>
    </div>

    <div class="grid-container">
         
        

        <a href="calificaciones.php" class="card">
            <div class="card-border"></div>
            <div class="card-content">
                <i class="fas fa-star"></i>
                <h2>Calificaciones</h2>
            </div>
        </a>

         

        <a href="horario.php" class="card">
            <div class="card-border"></div>
            <div class="card-content">
                <i class="fas fa-tasks"></i>
                <h2>Horarios</h2>
            </div>
        </a>

        

        <a href="consultar_materias.php" class="card">
            <div class="card-border"></div>
            <div class="card-content">
                <i class="fas fa-user"></i>
                <h2>Consultar</h2>
            </div>
        </a>
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
