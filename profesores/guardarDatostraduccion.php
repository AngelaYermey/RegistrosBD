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

    // Preparar la consulta para verificar si el número de aula existe
    $stmt_count = $mysqli->prepare("SELECT COUNT(*) AS count FROM asignaturas WHERE codigo_asignatura = ?;
    SELECT COUNT(*) AS count FROM aula WHERE numero_aula = ?");
    $stmt_count->bind_param("s", $codigo, $numAula);
    $stmt_count->execute();
    $result = $stmt_count->get_result();
    
    // Verificar si el número de aula existe
    if ($result > 0) {
        // El número de aula existe, procede con la inserción
        $stmt = $mysqli->prepare("INSERT INTO clases (codigo_asignatura, numero_aula, cedula_prof, tema_clase, texto_clase, fecha) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $codigo, $numAula, $prof_cedula, $tema, $transcripcion, $fecha);

        // Ejecutar la consulta de inserción
        if ($stmt_insert->execute()) {
            // Si la inserción fue exitosa, enviar una respuesta JSON con éxito
            echo json_encode(array("success" => true, "message" => "Guardado correctamente."));
        } else {
            // Si hubo un error en la inserción, enviar una respuesta JSON con el mensaje de error
            echo json_encode(array("success" => false, "message" => "Ocurrió un error al guardar la transcripción: " . $stmt_insert->error));
        }

        // Cerrar la consulta de inserción
        $stmt_insert->close();
    } else {
        // El número de aula no existe, enviar un mensaje de error
        echo json_encode(array("success" => false, "message" => "El codigo no existe."));
    }

} else {
    // Si no se enviaron todos los datos necesarios, retornar un mensaje de error en formato JSON
    echo json_encode(array("success" => false, "message" => "No se han recibido todos los datos necesarios para guardar la transcripción."));
}
