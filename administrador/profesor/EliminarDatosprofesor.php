<?php
session_start();

$validar = $_SESSION['usuario'];

if ($validar == null || $validar == '') {
    header("Location: ../../index.php");
    die();
}

// Verifica si se ha enviado la cédula a eliminar
if (isset($_GET['cedProf'])) {
    // Obtiene la cédula a eliminar desde la URL
    $cedula = $_GET['cedProf'];

    // Incluye el archivo de conexión a la base de datos
    include '../../db_Conexion/conector.php';

    // Instancia un objeto de la clase Conexion
    $conexion_obj = new Conexion();

    // Establece la conexión a la base de datos
    $conn = $conexion_obj->conectar();

    // Prepara la consulta SQL para eliminar las clases asociadas al profesor
    $eliminar_clases = $conn->prepare("DELETE FROM clases WHERE cedula_prof = ?");
    $eliminar_clases->bind_param("s", $cedula);

    // Ejecuta la consulta para eliminar las clases asociadas al profesor
    if ($eliminar_clases->execute()) {
        // Ahora que las clases asociadas han sido eliminadas, puedes eliminar al profesor
        $eliminar_profesor = $conn->prepare("DELETE FROM profesores WHERE cedula_prof = ?");
        $eliminar_profesor->bind_param("s", $cedula);

        // Ejecuta la consulta para eliminar al profesor
        if ($eliminar_profesor->execute()) {
            // Si la eliminación es exitosa, redirecciona a la tabla de estudiantes
            echo "<script>window.location.href = 'tablaProfesor.php';</script>";
            exit();
        } else {
            // Si hay un error al eliminar al profesor, muestra un mensaje de error
            echo "<script>Swal.fire('Error al eliminar el profesor.', 'error');</script>";
        }
    } else {
        // Si hay un error al eliminar las clases asociadas al profesor, muestra un mensaje de error
        echo "<script>Swal.fire('Error al eliminar por clases asociadas al profesor.', 'error');</script>";
    }

    // Cierra la conexión a la base de datos
    $conn->close();
} else {
    // Si no se ha proporcionado la cédula del profesor a eliminar, muestra un mensaje de error
    echo "<script>Swal.fire('Error', 'No se ha proporcionado la cédula del estudiante a eliminar.', 'error');</script>";
}
?>
