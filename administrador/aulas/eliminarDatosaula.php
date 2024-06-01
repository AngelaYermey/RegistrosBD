<?php
session_start();
error_reporting(0);

$validar = $_SESSION['usuario'];

if ($validar == null || $validar =='') {
  header("Location: ../../formularioIniciosesion.html");
  die();
}

// Verifica si se ha enviado el código de la asignatura a eliminar
if (isset($_GET['codigoAula'])) {
    // Obtiene el código de la asignatura a eliminar desde la URL
    $codigoAsig = $_GET['codigoAula'];

    // Incluye el archivo de conexión a la base de datos
    include '../../db_Conexion/conector.php';

    // Instancia un objeto de la clase Conexion
    $conexion_obj = new Conexion();

    // Establece la conexión a la base de datos
    $conn = $conexion_obj->conectar();

    // Prepara la consulta SQL para eliminar las clases asociadas a la asignatura
    $eliminar_clases = $conn->prepare("DELETE FROM clases WHERE codigo_asignatura = ?");
    $eliminar_clases->bind_param("s", $codigoAsig);

    // Ejecuta la consulta para eliminar las clases asociadas a la asignatura
    if ($eliminar_clases->execute()) {
        // Ahora que las clases asociadas han sido eliminadas, puedes eliminar la asignatura
        $eliminar_asignatura = $conn->prepare("DELETE FROM asignaturas WHERE codigo_asignatura = ?");
        $eliminar_asignatura->bind_param("s", $codigoAsig);

        // Ejecuta la consulta para eliminar la asignatura
        if ($eliminar_asignatura->execute()) {
            // Si la eliminación es exitosa, redirecciona a la tabla de asignaturas
            echo "<script>window.location.href = 'tablaAsignatura.php';</script>";
            exit();
        } else {
            // Si hay un error al eliminar la asignatura, muestra un mensaje de error
            echo "<script>alert('Error al eliminar la asignatura.');</script>";
        }
    } else {
        // Si hay un error al eliminar las clases asociadas a la asignatura, muestra un mensaje de error
        echo "<script>alert('Error al eliminar las clases asociadas a la asignatura.');</script>";
    }

    // Cierra la conexión a la base de datos
    $conn->close();
} else {
    // Si no se ha proporcionado el código de la asignatura a eliminar, muestra un mensaje de error
    echo "<script>alert('No se ha proporcionado el código de la asignatura a eliminar.');</script>";
}
?>


?>
