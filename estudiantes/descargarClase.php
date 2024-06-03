<?php
// Iniciar la sesión
session_start();

// Verificar si el usuario está autenticado
$UsuarioEstudiante = $_SESSION['usuario'];
if ($UsuarioEstudiante == null || $UsuarioEstudiante == '') {
    header("Location: ../formularioIniciosesion.html"); // Redirigir si no está autenticado
    die();
}

// Incluir el archivo de conexión a la base de datos
include '../db_Conexion/conector.php';

// Establecer la conexión a la base de datos
$conexion_obj = new Conexion(); // Instanciar un objeto de conexión
$conn = $conexion_obj->conectar(); // Establecer la conexión a la base de datos

// Consulta SQL para obtener los datos de las clases
$sql = "SELECT 
            asignaturas.codigo_asignatura, 
            asignaturas.nombre AS nombre_asignatura,
            clases.tema_clase, 
            clases.texto_clase,
            profesores.nombre AS nombre_profesor,
            profesores.apellido AS apellido_profesor,
            clases.fecha
        FROM 
            clases 
        INNER JOIN 
            asignaturas ON clases.codigo_asignatura = asignaturas.codigo_asignatura 
        INNER JOIN 
            profesores ON clases.cedula_prof = profesores.cedula_prof 
        WHERE 
            clases.numero_aula IN (
                SELECT numero_aula FROM estudiantes WHERE cedula_estudiante = ?
            )
        ORDER BY 
            clases.fecha DESC";

$consulta = $conn->prepare($sql); // Preparar la consulta SQL
$consulta->bind_param("s", $UsuarioEstudiante); // Asignar el valor del parámetro

$consulta->execute(); // Ejecutar la consulta preparada
$result = $consulta->get_result(); // Obtener los resultados de la consulta

// Generar el archivo de texto
$filename = "Texto_clases.txt";
$file = fopen($filename, 'w'); // Abrir el archivo en modo escritura
while ($datos = $result->fetch_object()) {
    // Escribir los datos de la clase en el archivo
    fwrite($file, "Código Materia: " . $datos->codigo_asignatura . "\n");
    fwrite($file, "Nombre Materia: " . $datos->nombre_asignatura . "\n");
    fwrite($file, "Tema de la Clase: " . $datos->tema_clase . "\n");
    fwrite($file, "Fecha: " . $datos->fecha . "\n");
    fwrite($file, "Profesor: " . $datos->nombre_profesor . " " . $datos->apellido_profesor . "\n\n");
    fwrite($file, "Texto de la Clase:\n\n" . $datos->texto_clase);
}
fclose($file); // Cerrar el archivo después de escribir

// Descargar el archivo
header("Content-disposition: attachment; filename=$filename");
header("Content-type: application/octet-stream");
readfile($filename);

// Eliminar el archivo después de descargarlo
unlink($filename);
?>
