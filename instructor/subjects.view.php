<!DOCTYPE html>
<?php
require '../login/functions.php';
// Define quien tiene permiso en este archivo
$permisos = ['instructor'];
permisos($permisos);

// Consulta las secciones
$secciones = $conn->prepare("SELECT * FROM secciones");
$secciones->execute();
$secciones = $secciones->fetchAll();

// Consulta de grados
$grados = $conn->prepare("SELECT * FROM grados");
$grados->execute();
$grados = $grados->fetchAll();
?>
<html>
<head>
<title>Inicio | Registro de Notas</title>
    <meta name="description" content="" />
    <link rel="stylesheet" href="../css/form.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/mode-dark.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

</head>
<body>

<nav class="navbar">
  <a href="instructor.php" class="nav-link active">Inicio</a>
  <a href="alumnos.view.php" class="nav-link">Registrar Aprendiz</a>
  <a href="listadoalumnos.view.php" class="nav-link">Listado de Aprendiz</a>
  <a href="subjects.view.php" class="nav-link">Registrar Asignatura</a> <!-- New link for subjects -->
</nav>

<div class="body">
    <div class="panel">
            <h4>Registro de Asignaturas</h4> <!-- Updated title for subjects -->
            <form method="post" class="form" action="procesarsubject.php"> <!-- Updated action for subjects -->
                <label>Nombre</label><br> <!-- Updated label for subject name -->
                <input type="text" required name="nombre" maxlength="45"> <!-- Updated input name for subject -->
                <br>
                <label>Descripción</label><br> <!-- Added label for subject description -->
                <input type="text" required name="descripcion" maxlength="255"> <!-- Added input for subject description -->
                <br><br>
                <label>Grado</label><br>
                <select name="grado" required>
                    <?php foreach ($grados as $grado):?>
                        <option value="<?php echo $grado['id'] ?>"><?php echo $grado['nombre'] ?></option>
                    <?php endforeach;?>
                </select>
                <br><br>
                <label>Jornada</label><br>
                <?php foreach ($secciones as $seccion):?>
                    <input type="radio" name="seccion" required value="<?php echo $seccion['id'] ?>">Jornada <?php echo $seccion['nombre'] ?>
                <?php endforeach;?>
                <br><br>
                <button type="submit" name="insertar">Guardar</button> <button type="reset">Limpiar</button> <a class="btn-link" href="listadoasignaturas.view.php">Ver Listado</a> <!-- Updated link for subjects list -->
                <br><br>
                <!-- Mostrando los mensajes que recibe a través de los parámetros en la URL -->
                <?php
                if(isset($_GET['err']))
                    echo '<span class="error">Error al almacenar el registro</span>';
                if(isset($_GET['info']))
                    echo '<span class="success">Registro almacenado correctamente!</span>';
                ?>
            </form>
        <?php
        if(isset($_GET['err']))
            echo '<span class="error">Error al guardar</span>';
        ?>
    </div>
</div>

<div class="dark-mode-button">
  <i class="fas fa-moon"></i>
</div>
<script src="script.js"></script>
</body>
</html>
