<?php

include '../db_Conexion/conector.php';
session_start();

// Obtener los datos enviados desde el cliente
$data = json_decode(file_get_contents('php://input'), true);

// Verificar si se recibieron todos los datos necesarios
if (isset($data['codigo'], $data['tema'], $data['numeroAula'], $data['transcripcion'])) {
    // Sanitizar y obtener los datos del formulario
    $codigo = htmlspecialchars($data['codigo']);
    $tema = htmlspecialchars($data['tema']);
    $numAula = htmlspecialchars($data['numeroAula']);
    $transcripcion = htmlspecialchars($data['transcripcion']);
    // Establecer la zona horaria a Panamá
    date_default_timezone_set('America/Panama');
    // Obtener la fecha actual en formato MySQL
    $fecha = date('Y-m-d H:i:s');

    // Conectar a la base de datos
    $con = new Conexion();
    $mysqli = $con->conectar();

    // Obtener la cédula con sesión
    $prof_cedula = $_SESSION['usuario'];

    // Consultar si ya existe
    $resultado = $mysqli->query('SELECT codigo_asignatura FROM asignaturas WHERE codigo_asignatura="' . $codigo . '"');
    $result = $mysqli->query('SELECT numero_aula FROM aula WHERE numero_aula="' . $numAula . '"');

    if ($result->num_rows > 0 && $resultado->num_rows > 0) {
        $stmt = $mysqli->prepare("INSERT INTO clases (codigo_asignatura, numero_aula, cedula_prof, tema_clase, texto_clase, fecha) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $codigo, $numAula, $prof_cedula, $tema, $transcripcion, $fecha);

        // Ejecutar la consulta de inserción
        if ($stmt->execute()) {
            echo json_encode(array("success" => true, "message" => "Guardado correctamente."));
        } else {
            echo json_encode(array("success" => false, "message" => "Ocurrió un error al guardar la transcripción: " . $stmt->error));
        }

        $stmt->close();
    } else {
        // El número de aula no existe, enviar un mensaje de error
        echo json_encode(array("success" => false, "message" => "El código no existe."));
    }

} else {
    // Si no se enviaron todos los datos necesarios, retornar un mensaje de error en formato JSON
    echo json_encode(array("success" => false, "message" => "No se han recibido todos los datos necesarios para guardar la transcripción."));
}
?>
