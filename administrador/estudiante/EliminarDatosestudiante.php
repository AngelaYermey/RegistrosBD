<?php
session_start();
error_reporting(0);

$validar = $_SESSION['usuario'];

if ($validar == null || $validar =='') {
  header("Location: ../../index.php");
  die();
}

  // Verifica si se ha enviado la cédula del estudiante a eliminar
  if (isset($_GET['cedEst'])) {
    // Obtiene la cédula del estudiante a eliminar desde la URL
    $cedula = $_GET['cedEst'];

    // Incluye el archivo de conexión a la base de datos
    include '../../db_Conexion/conector.php';

    // Instancia un objeto de la clase Conexion
    $conexion_obj = new Conexion();

    // Establece la conexión a la base de datos
    $conn = $conexion_obj->conectar();

    // Prepara la consulta SQL para eliminar el estudiante con la cédula especificada
    $eliminar_estudiante = $conn->prepare("DELETE FROM estudiantes WHERE cedula_estudiante = ?");

    // Vincula el parámetro de la consulta
    $eliminar_estudiante->bind_param("s", $cedula);

    // Ejecuta la consulta
    if ($eliminar_estudiante->execute()) {
      // Si la eliminación es exitosa, redirecciona a la tabla de estudiantes
      echo "<script>window.location.href = 'tablaEstudiante.php';</script>";
      exit();
    } else {
      // Si hay un error, muestra un mensaje de error
      echo "<script>Swal.fire('Error', 'Error al eliminar el estudiante.', 'error');</script>";
    }

    // Cierra la conexión a la base de datos
    $conn->close();
  } else {
    // Si no se ha proporcionado la cédula del estudiante a eliminar, muestra un mensaje de error
    echo "<script>Swal.fire('Error', 'No se ha proporcionado la cédula del estudiante a eliminar.', 'error');</script>";
  }

?>
