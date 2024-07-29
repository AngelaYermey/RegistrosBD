<?php
// Iniciar la sesión si no está iniciada (en caso de que aún no esté iniciada)
session_start();

// Verificar si el usuario está autenticado
$UsuarioEstudiante = $_SESSION['usuario'];
if ($UsuarioEstudiante == null || $UsuarioEstudiante == '') {
    header("Location: ../formularioIniciosesion.html"); // Redirigir si no está autenticado
    die();
}

// Incluir el archivo de conexión a la base de datos
include '../db_Conexion/conector.php';

// Obtener el ID de la clase desde los parámetros GET
if (isset($_GET['id'])) {
    $id_clase = $_GET['id'];

    // Establecer la conexión a la base de datos
    $conexion_obj = new Conexion();
    $conn = $conexion_obj->conectar();

    // Consulta SQL para obtener los datos de la clase específica
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
                clases.id = ?";
    
    $consulta = $conn->prepare($sql);
    $consulta->bind_param("i", $id_clase);
    $consulta->execute();
    $result = $consulta->get_result();

    if ($result->num_rows > 0) {
        // Generar el archivo de texto para descargar
        $filename = "Texto_Clase.txt";
        $file = fopen($filename, 'w');
        $datos = $result->fetch_object();

        // Escribir los datos de la clase en el archivo
        fwrite($file, "Código Materia: " . $datos->codigo_asignatura . "\n");
        fwrite($file, "Nombre Materia: " . $datos->nombre_asignatura . "\n");
        fwrite($file, "Tema de la Clase: " . $datos->tema_clase . "\n");
        fwrite($file, "Fecha: " . $datos->fecha . "\n");
        fwrite($file, "Profesor: " . $datos->nombre_profesor . " " . $datos->apellido_profesor . "\n\n");
        fwrite($file, "Texto de la Clase:\n\n" . $datos->texto_clase);

        fclose($file);

        // Descargar el archivo
        header("Content-disposition: attachment; filename=$filename");
        header("Content-type: application/octet-stream");
        readfile($filename);

        // Eliminar el archivo después de descargarlo
        unlink($filename);
    } else {
        echo "No se encontraron datos para la clase seleccionada.";
    }

    // Cerrar la conexión
    $conn->close();
} else {
    echo "No se especificó un ID de clase válido.";
}
?>
