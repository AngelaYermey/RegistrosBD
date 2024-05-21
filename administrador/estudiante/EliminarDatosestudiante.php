<?php
session_start();
error_reporting(0);

$validar = $_SESSION['usuario'];

if ($validar == null || $validar = '') {
  header("Location: ../../formularioIniciosesion.html");
  die();
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Confirmar Eliminación</title>
  <!-- CSS de Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container d-flex justify-content-center align-items-center vh-100">
  <div class="alert alert-info alert-dismissible fade show" role="alert" style="max-width: 500px;">
      ¿Estás seguro de que deseas eliminar este registro?
      <form method="post"><br>
          <center>
          <button type="submit" name="eliminar" class="btn btn-danger">Sí, eliminar</button>
          <a href="tablaEstudiante.php" class="btn btn-secondary">Cancelar</a>
          </center>
      </form>
  </div>
</div>

<!-- JS de Bootstrap (opcional, solo si necesitas funcionalidades como el cierre de las alertas) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Maneja la solicitud POST para eliminar el registro del estudiante
if(isset($_POST['eliminar'])){
    // Verifica si se ha enviado la cédula del estudiante a eliminar
    if(isset($_GET['cedEst'])) {
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
        if($eliminar_estudiante->execute()) {
            // Si la eliminación es exitosa, redirecciona a la tabla de estudiantes
            header("Location: tablaEstudiante.php");
            exit();
        } else {
            // Si hay un error, muestra un mensaje de error
            echo "Error al eliminar el estudiante.";
        }

        // Cierra la conexión a la base de datos
        $conn->close();
    } else {
        // Si no se ha proporcionado la cédula del estudiante a eliminar, muestra un mensaje de error
        echo "No se ha proporcionado la cédula del estudiante a eliminar.";
    }
}
?>
