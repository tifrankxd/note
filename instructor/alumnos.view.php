<!DOCTYPE html>
<?php
require '../login/functions.php';
//Define queienes tienen permiso en este archivo
$permisos = ['instructor'];
permisos($permisos);
//consulta las secciones
$secciones = $conn->prepare("select * from secciones");
$secciones->execute();
$secciones = $secciones->fetchAll();

//consulta de grados
$grados = $conn->prepare("select * from grados");
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
            <h4>Registro de Alumnos</h4>
            <form method="post" class="form" action="procesaralumno.php">
                <label>Nombres</label><br>
                <input type="text" required name="nombres" maxlength="45">
                <br>
                <label>Apellidos</label><br>
                <input type="text" required name="apellidos" maxlength="45">
                <br><br>
                <label>No de Lista</label><br>
                <input type="number" min="1" class="number" name="numlista">
                <br><br>
                <label>Sexo</label><br><input required type="radio" name="genero" value="M"> Masculino
                <input type="radio" name="genero" required value="F"> Femenino
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
                <button type="submit" name="insertar">Guardar</button> <button type="reset">Limpiar</button> <a class="btn-link" href="listadoalumnos.view.php">Ver Listado</a>
                <br><br>
                <!--mostrando los mensajes que recibe a traves de los parametros en la url-->
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