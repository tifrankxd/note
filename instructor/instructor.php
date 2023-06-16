<?php
session_start();

// Verifica si el usuario ha iniciado sesión como instructor
if (!isset($_SESSION['username']) || $_SESSION['profile'] !== 'instructor') {
    // Si el usuario no ha iniciado sesión o no es un instructor, redirige al formulario de inicio de sesión
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Perfil de Instructor</title>
    <link rel="stylesheet" href="../css/d.css">
    <link rel="stylesheet" href="../css/ins.css">
    <link rel="stylesheet" href=
    "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
<div class="navbar">
        <div>
           <span>Bienvenido, Instructor: <?php echo $_SESSION['username']; ?></span></span>
        </div>
        <div>
            <i class="fas fa-moon dark-mode-icon"></i>
            <a href="../login/logout.php"><i class="fas fa-sign-out-alt logout-icon"></i></a>
        </div>
    </div>

    
    <div class="grid-container">
    <a href="asignacion.php" class="card">
    <div class="card-border"></div>
    <div class="card-content">
        <i class="fas fa-tasks"></i>
        <h2>Asignar Jornada</h2>
    </div>
</a>


        <a href="grado.php" class="card">
    <div class="card-border"></div>
    <div class="card-content">
        <i class="fas fa-graduation-cap"></i>
        <h2>Grados y Jornada</h2>
    </div>
</a>


<a href="horario.php" class="card horario">
    <div class="card-border"></div>
    <div class="card-content">
        <i class="fas fa-clock"></i>
        <h2>Horario Instructor</h2>
    </div>
</a>


        <a href="calificar.php" class="card">
            <div class="card-border"></div>
            <div class="card-content">
                <h2>Tarjeta 4</h2>
            </div>
        </a>

        <a href="vista5.html" class="card">
            <div class="card-border"></div>
            <div class="card-content">
                <h2>Tarjeta 5</h2>
            </div>
        </a>

        <a href="vista6.html" class="card">
            <div class="card-border"></div>
            <div class="card-content">
                <h2>Tarjeta 6</h2>
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



