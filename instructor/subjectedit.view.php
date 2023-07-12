<!DOCTYPE html>
<?php
require '../login/functions.php';
$permisos = ['instructor'];
permisos($permisos);
if(isset($_GET['id'])) {

    $id_subject = $_GET['id'];

    $subject = $conn->prepare("SELECT * FROM subjects WHERE id = ".$id_subject);
    $subject->execute();
    $subject = $subject->fetch();

    // Consulta las secciones
    $secciones = $conn->prepare("SELECT * FROM secciones");
    $secciones->execute();
    $secciones = $secciones->fetchAll();

    // Consulta de grados
    $grados = $conn->prepare("SELECT * FROM grados");
    $grados->execute();
    $grados = $grados->fetchAll();

} else {
    Die('Ha ocurrido un error');
}
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
    <a href="subjects.view.php" class="nav-link">Registrar Asignatura</a>
    <a href="listadosubjects.view.php" class="nav-link">Listado de Asignaturas</a>
</nav>

<div class="body">
    <div class="panel">
        <h4>Edición de Asignatura</h4>
        <form method="post" class="form" action="procesarsubjects.php">
            <!-- Colocamos un campo oculto que tiene el id del subject -->
            <input type="hidden" value="<?php echo $subject['id']?>" name="id">
            <label>Nombre</label><br>
            <input type="text" required name="nombre" value="<?php echo $subject['nombre']?>" maxlength="45">
            <br>
            <label>Descripción</label><br>
            <textarea required name="descripcion"><?php echo $subject['descripcion']?></textarea>
            <br><br>
            <label>Grado</label><br>
            <select name="grado" required>
                <?php foreach ($grados as $grado):?>
                    <option value="<?php echo $grado['id'] ?>" <?php if($subject['id_grado'] == $grado['id']) { echo "selected";} ?> ><?php echo $grado['nombre'] ?></option>
                <?php endforeach;?>
            </select>
            <br><br>
            <label>Jornada</label><br>
            <?php foreach ($secciones as $seccion):?>
                <input type="radio" name="seccion" <?php if($subject['id_seccion'] == $seccion['id']) { echo "checked";} ?> required value="<?php echo $seccion['id'] ?>"> Jornada <?php echo $seccion['nombre'] ?>
            <?php endforeach;?>
            <br><br>
            <button type="submit" name="modificar">Guardar Cambios</button> <a class="btn-link" href="listadosubjects.view.php">Ver Listado</a>
            <br><br>
            <!-- Mostrando los mensajes que recibe a través de los parámetros en la URL -->
            <?php
            if(isset($_GET['err']))
                echo '<span class="error">Error al editar el registro</span>';
            if(isset($_GET['info']))
                echo '<span class="success">Registro modificado correctamente!</span>';
            ?>
        </form>
    </div>
</div>

<div class="dark-mode-button">
    <i class="fas fa-moon"></i>
</div>
<script src="script.js"></script>

</body>
</html>
