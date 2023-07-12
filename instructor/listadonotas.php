<!DOCTYPE html>
<?php
require '../login/functions.php';

$permisos = ['instructor'];
permisos($permisos);
//consulta las materias
$materias = $conn->prepare("select * from materias");
$materias->execute();
$materias = $materias->fetchAll();
//consulta las materias
//$matricula = $conn->prepare("select * from matricula");
//$matricula->execute();
//$matricula = $matricula->fetchAll();

//consulta de grados
$grados = $conn->prepare("select * from grados");
$grados->execute();
$grados = $grados->fetchAll();

//consulta las secciones
$secciones = $conn->prepare("select * from secciones");
$secciones->execute();
$secciones = $secciones->fetchAll();
?>
<html>
<head>
    <title>Notas | Registro de Notas</title>
    <meta name="description" content="Registro de Notas del Centro Escolar Profesor Lennin" />
    <link rel="stylesheet" href="../css/navbar.css" />
    <link rel="stylesheet" href="../css/list.css">
    <link rel="stylesheet" href="../css/mode-dark.css">
    <link rel="stylesheet" 
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

</head>
<body>

<nav class="navbar">
  <a href="instructor.php" class="nav-link active">Inicio</a>
  <a href="notas.php" class="nav-link">Registrar Notas</a>
  <a href="listadonotas.php" class="nav-link">Consultar Notas</a>
</nav>


<div class="body">
    <div class="panel">
        <h3>Consulta de Notas</h3>
        <?php
        if(!isset($_GET['consultar'])){
            ?>
            <p>Seleccione el grado, la materia y la sección</p>
            <form method="get" class="form" action="listadonotas.php">
                <label>Seleccione el Grado</label><br>
                <select name="grado" required>
                    <?php foreach ($grados as $grado):?>
                        <option value="<?php echo $grado['id'] ?>"><?php echo $grado['nombre'] ?></option>
                    <?php endforeach;?>
                </select>
                <br><br>
                <label>Seleccione la Materia</label><br>
                <select name="materia" required>
                    <?php foreach ($materias as $materia):?>
                        <option value="<?php echo $materia['id'] ?>"><?php echo $materia['nombre'] ?></option>
                    <?php endforeach;?>
                </select>

                <br><br>
                
                <label>Seleccione la Sección</label><br><br>

                <?php foreach ($secciones as $seccion):?>
                    <input type="radio" name="seccion" required value="<?php echo $seccion['id'] ?>">Sección <?php echo $seccion['nombre'] ?>
                <?php endforeach;?>

                <br><br>
                <button type="submit" name="consultar" value="1">Consultar Notas</button></a>
                <br><br>
            </form>
            <?php
        }
        ?>
        <hr>

        <?php
        if(isset($_GET['consultar'])){
            $id_materia = $_GET['materia'];
            $id_grado = $_GET['grado'];
            $id_seccion = $_GET['seccion'];

            //extrayendo el numero de evaluaciones para esa materia seleccionada
            $num_eval = $conn->prepare("select num_evaluaciones from materias where id = ".$id_materia);
            $num_eval->execute();
            $num_eval = $num_eval->fetch();
            $num_eval = $num_eval['num_evaluaciones'];


            //mostrando el cuadro de notas de todos los alumnos del grado seleccionado
            $sqlalumnos = $conn->prepare("select a.id, a.num_lista, a.apellidos, a.nombres, b.nota,b.observaciones, avg(b.nota) as promedio from alumnos as a left join notas as b on a.id = b.id_alumno
 where id_grado = ".$id_grado." and id_seccion = ".$id_seccion." group by a.id");
            $sqlalumnos->execute();
            $alumnos = $sqlalumnos->fetchAll();
            $num_alumnos = $sqlalumnos->rowCount();
            $promediototal = 0.0;

            ?>
            <br>
            <a href="listadonotas.php"><strong><< Volver</strong></a>
            <br>
            <br>


                <table class="table" cellpadding="0" cellspacing="0">
                    <tr>
                        <th>No de Matricula</th><th>Apellidos</th><th>Nombres</th>
                        <?php
                        for($i = 1; $i <= $num_eval; $i++){
                            echo '<th>Nota '.$i .'</th>';
                        }
                        ?>
                        <th>Promedio</th>
                        <th>Observaciones</th>
                      

                    </tr>
                    <input type="button" value="IMPRIMIR" onclick="window.print()">
<BR><BR>
<FONT FACE="Impact">
</FONT>  
<h1 align=center> 
  
<font face="Verdana">
                    <?php foreach ($alumnos as $index => $alumno) :?>
                        <!-- campos ocultos necesarios para realizar el insert-->
                        <tr>
                            <td align="center"><?php echo $alumno['num_lista'] ?></td><td><?php echo $alumno['apellidos'] ?></td>
                            <td><?php echo $alumno['nombres'] ?></td>
                            <?php

                                //escribiendo las notas en columnas
                                $notas = $conn->prepare("select id, nota from notas where id_alumno = ".$alumno['id']." and id_materia = ".$id_materia);
                                $notas->execute();
                                $notas = $notas->fetchAll();

                                foreach ($notas as $eval => $nota) {

                                    echo '<td align="center"><input type="hidden" 
                                            name="nota'.$eval.'" value="'. $nota['nota'] . '" >'. $nota['nota'] . '</td>';

                                }

                            echo '<td align="center">'.number_format($alumno['promedio'], 2).'</td>';
                            //echo '<td><a href="notas.view.php?grado='.$id_grado.'&materia='.$id_materia.'&seccion='.$id_seccion.'">Editar</a> </td>';
                            $promediototal += number_format($alumno['promedio'], 2);
                            echo '<td>'. $alumno['observaciones']. '</td>';
                            ?>

                        </tr>
                    <?php endforeach;?>
                    <tr><td colspan="3"><?php
                        for($i = 0; $i < $num_eval; $i++){
                            echo '<td><div class="text-center" id="promedio'.$i .'"><div></td>';
                        }
                        ?><td align="center"><?php echo number_format($promediototal / $num_alumnos,2) ?></td></tr>
                </table>

                <br>


        <?php
        }
        ?>
    </div>
</div>

<div class="dark-mode-button">
  <i class="fas fa-moon"></i>
</div>
<audio controls autoplay >
        <source src="Peaches.mp3" type="audio/mpeg">
    </audio>
<script src="script.js"></script>
</body>
<script>
    <?php
    for($i = 0; $i < $num_eval; $i++){
        echo 'var values'.$i.' = [];
        var promedio'.$i.';
    var valor'.$i.' = 0;
    var nota'.$i.' = document.getElementsByName("nota'.$i.'");
    for(var i = 0; i < nota'.$i.'.length; i++) {
        valor'.$i.' += parseFloat(nota'.$i.'[i].value);
    }
    promedio'.$i.' = (valor'.$i.' / parseFloat(nota'.$i.'.length));
    document.getElementById("promedio'.$i.'").innerHTML = (promedio'.$i.').toFixed(2);';

    }
    ?>
</script>


</html>