<?php
require '../login/functions.php';

if ($_SESSION['profile'] == 'instructor') {
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        try {
            $id_asignatura = $_GET['id'];
            $asignatura = $conn->prepare("DELETE FROM subjects WHERE id = " . $id_asignatura);
            $asignatura->execute();
            header('location: listadoasignaturas.view.php');
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    } else {
        die('Ha ocurrido un error');
    }
} else {
    header('location: inicio.view.php?err=1');
}
?>
