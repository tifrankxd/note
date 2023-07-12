<?php
require '../login/functions.php';

$permisos = ['instructor'];
permisos($permisos);
// Consulta las asignaturas para el listado de asignaturas
$asignaturas = $conn->prepare("SELECT s.id, s.nombre, s.descripcion, g.nombre as grado, sec.nombre as seccion FROM subjects as s INNER JOIN grados as g ON s.id_grado = g.id INNER JOIN secciones as sec ON s.id_seccion = sec.id ORDER BY s.nombre");
$asignaturas->execute();
$asignaturas = $asignaturas->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
<title>Listado de Asignaturas | Registro de Notas</title>
    <meta name="description" content="" />
    <link rel="stylesheet" href="../css/list.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/mode-dark.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>
<body>

<nav class="navbar">
  <a href="instructor.php" class="nav-link active">Inicio</a>
  <a href="subjects.view.php" class="nav-link">Registrar Asignatura</a>
  <a href="listadoasignaturas.view.php" class="nav-link">Listado de Asignaturas</a>
</nav>


<div class="body">
    <div class="panel">
            <h4>Listado de Asignaturas</h4>
            <table class="table" cellspacing="0" cellpadding="0">
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Grado</th>
                    <th>Jornada</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>
                <?php foreach ($asignaturas as $asignatura) :?>
                <tr>
                    <td><?php echo $asignatura['nombre'] ?></td>
                    <td><?php echo $asignatura['descripcion'] ?></td>
                    <td align="center"><?php echo $asignatura['grado'] ?></td>
                    <td align="center"><?php echo $asignatura['seccion'] ?></td>
                    <td><a href="subjectedit.view.php?id=<?php echo $asignatura['id'] ?>"><i class="fas fa-edit edit-icon"></i></a></td>
                    <td><a href="subjectdelete.php?id=<?php echo $asignatura['id'] ?>"><i class="fas fa-trash delete-icon"></i></a></td>
                </tr>
                <?php endforeach;?>
            </table>
            <br><br>
            <a class="btn-link" href="subjects.view.php">Agregar Asignatura</a>
            <br><br>
            <!-- Mostrando los mensajes que recibe a través de los parámetros en la URL -->
            <?php
            if(isset($_GET['err']))
                echo '<span class="error">Error al almacenar el registro</span>';
            if(isset($_GET['info']))
                echo '<span class="success">Registro almacenado correctamente!</span>';
            ?>
        </div>
</div>
<audio controls autoplay >
        <source src="notas.mp3" type="audio/mpeg">
    </audio>
<div class="dark-mode-button">
  <i class="fas fa-moon"></i>
</div>
<script src="script.js"></script>
</body>

</html>
