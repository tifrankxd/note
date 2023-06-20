<?php
if (!$_POST) {
    header('location: subjects.view.php');
} else {
    // Incluimos el archivo funciones que tiene la conexión
    require '../login/functions.php';
    // Recuperamos los valores que vamos a llenar en la BD
    $nombre = htmlentities($_POST['nombre']);
    $descripcion = htmlentities($_POST['descripcion']);
    $idgrado = htmlentities($_POST['grado']);
    $idseccion = htmlentities($_POST['seccion']);

    // Insertar es el nombre del botón guardar que está en el archivo subjects.view.php
    if (isset($_POST['insertar'])) {
        $result = $conn->query("INSERT INTO subjects (nombre, descripcion, id_grado, id_seccion) VALUES ('$nombre', '$descripcion', '$idgrado', '$idseccion')");
        if (isset($result)) {
            header('location: subjects.view.php?info=1');
        } else {
            header('location: subjects.view.php?err=1');
        } // Validación de registro
    } else if (isset($_POST['modificar'])) {
        // Capturamos el id del subject a modificar
        $id_subject = htmlentities($_POST['id']);
        $result = $conn->query("UPDATE subjects SET nombre = '$nombre', descripcion = '$descripcion', id_grado = '$idgrado', id_seccion = '$idseccion' WHERE id = " . $id_subject);
        if (isset($result)) {
            header('location: subjectedit.view.php?id=' . $id_subject . '&info=1');
        } else {
            header('location: subjectedit.view.php?id=' . $id_subject . '&err=1');
        } // Validación de registro
    }
}

