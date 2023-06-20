<?php
// iniciamos la sesion
session_start();

// esta pregunta la debe hacer en todos los archivos para validar que antes el usuario haya iniciado sesion
if (isset($_SESSION['username'])) {
    // Cookie is not being set here anymore

    // Importamos el archivo que contiene la variable de conexión a la base de datos
    require '../conn/connection.php';

    // para verificar que tiene acceso a un archivo
    function permisos($permisos)
    {
        if (!in_array($_SESSION['profile'], $permisos)) {
            http_response_code(403);
            header('location:inicio.view.php?err=1');
        }
    }

    function existeNota($id_alumno, $id_materia, $conn)
    {
        $nota = $conn->prepare("select * from notas where id_materia = '$id_materia' and id_alumno = '$id_alumno'");
        $nota->execute();
        // si devuelve una fila significa que la nota ya es
        $nota = $nota->rowCount();
        return $nota;
    }
} else {
    http_response_code(403);
    header('location:index.php?err=2');
    exit(); // Added exit() to prevent executing the rest of the code if session is not set
}
?>
