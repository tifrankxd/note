<?php
require '../login/functions.php';

$permisos = ['instructor'];
permisos($permisos);
//consulta los alumnos para el listaddo de alumnos
$alumnos = $conn->prepare("select a.id, a.num_lista, a.nombres, a.apellidos, a.genero, b.nombre as grado, c.nombre as seccion from alumnos as a inner join grados as b on a.id_grado = b.id inner join secciones as c on a.id_seccion = c.id order by a.apellidos");
$alumnos->execute();
$alumnos = $alumnos->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
<title>Listado de Alumnos | Registro de Notas</title>
    <meta name="description" content="" />
    <link rel="stylesheet" href="../css/list.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/mode-dark.css">
    <link rel="stylesheet" 
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

</head>
<body>

<nav class="navbar">
  <a href="instructor.php" class="nav-link active">Inicio</a>
  <a href="alumnos.view.php" class="nav-link">Registrar Aprendiz</a>
  <a href="listadoalumnos.view.php" class="nav-link">Listado de Aprendiz</a>
</nav>


<div class="body">
    <div class="panel">
            <h4>Listado de Alumnos</h4>
            <table class="table" cellspacing="0" cellpadding="0">
                <tr>
                    <th>No de<br>Matricula</th><th>Apellidos</th><th>Nombres</th><th>Genero</th><th>Grado</th><th> Jornada</th>
                    <th>Editar</th><th>Eliminar</th>
                </tr>
                <?php foreach ($alumnos as $alumno) :?>
                <tr>
                    <td align="center"><?php echo $alumno['num_lista'] ?></td><td><?php echo $alumno['apellidos'] ?></td>
                    <td><?php echo $alumno['nombres'] ?></td><td align="center"><?php echo $alumno['genero'] ?></td>
                    <td align="center"><?php echo $alumno['grado'] ?></td><td align="center"><?php echo $alumno['seccion'] ?></td>
                    <td><a href="alumnoedit.view.php?id=<?php echo $alumno['id'] ?>"><i class="fas fa-edit edit-icon"></i></a></td>
<td><a href="alumnodelete.php?id=<?php echo $alumno['id'] ?>"><i class="fas fa-trash delete-icon"></i></a></td>

                    
                </tr>
                <?php endforeach;?>
            </table>
                <br><br>

                <a class="btn-link" href="alumnos.view.php">Agregar Alumno</a>
                <br><br>
                <!--mostrando los mensajes que recibe a traves de los parametros en la url-->
                <?php
                if(isset($_GET['err']))
                    echo '<span class="error">Error al almacenar el registro</span>';
                if(isset($_GET['info']))
                    echo '<span class="success">Registro almacenado correctamente!</span>';
                ?>


        </div>
</div>

<div class="dark-mode-button">
  <i class="fas fa-moon"></i>
</div>
<script src="script.js"></script>
</body>

</html>