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
    <link rel="stylesheet" href="../css/ini.css">
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
            <a href="../login/index.html"><i class="fas fa-sign-out-alt logout-icon"></i></a>
        </div>
    </div>

    
    <div class="grid-container">
    <a href="alumnos.view.php" class="card">
    <div class="card-border"></div>
    <div class="card-content">
        <i class="fas fa-tasks"></i>
        <h2>Asignar Jornada y Registrar</h2>
    </div>
</a>


<a href="notas.php" class="card">
    <div class="card-border"></div>
    <div class="card-content">
        <i class="fas fa-star"></i>
        <h2>Notas y Consultas</h2>
    </div>
</a>


<a href="subjects.view.php" class="card horario">
    <div class="card-border"></div>
    <div class="card-content">
        <i class="fas fa-check-circle"></i>
        <i class="fas fa-book"></i>
        <h2>Registrar Materias</h2>
    </div>
</a>



    <div class="container">
        <input type="checkbox" id="btn-mas">
        <div class="redes">
        <a href="mp3.mp3.mp3" class="music-icon" onclick="playMusic()">
  <i class="fas fa-music"></i>
</a>

<a href="../setting/forgot_password.php" class="fa fa-lock"></a>

<a href="../setting/social.html" class="social-link">
        <i class="fas fa-users"></i>
    </a>
        </div>
        <div class="btn-mas">
            <label for="btn-mas" class="fa fa-plus"></label>
        </div>
    </div>


<script>
  function playMusic() {
    var musicPlayer = document.getElementById("musicPlayer");
    musicPlayer.play();
  }
</script>

    <script>
        // Función para alternar el modo oscuro
        const darkModeIcon = document.querySelector('.dark-mode-icon');
        const body = document.querySelector('body');
        
        darkModeIcon.addEventListener('click', () => {
            body.classList.toggle('dark-mode');
        });
    </script>
    <audio controls autoplay >
        <source src="mp3.mp3.mp3" type="audio/mpeg">
    </audio>
</body>
</html>



