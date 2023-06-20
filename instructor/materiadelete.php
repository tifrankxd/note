<?php
require '../login/functions.php';
if ($_SESSION['profile'] == 'instructor') {
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        try {
            $id_materia = $_GET['id'];
            $materia = $conn->prepare("DELETE FROM materias WHERE id = " . $id_materia);
            $materia->execute();
            header('location:listadomaterias.view.php');
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    } else {
        die('Ha ocurrido un error');
    }
} else {
    header('location:inicio.view.php?err=1');
}
?>
