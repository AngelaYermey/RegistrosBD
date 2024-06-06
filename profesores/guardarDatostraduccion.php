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

    // Consultar si la asignatura y el aula existen
    $stmtAsignatura = $mysqli->prepare('SELECT codigo_asignatura FROM asignaturas WHERE codigo_asignatura = ?');
    $stmtAsignatura->bind_param('s', $codigo);
    $stmtAsignatura->execute();
    $resultAsignatura = $stmtAsignatura->get_result();

    $stmtAula = $mysqli->prepare('SELECT numero_aula FROM aula WHERE numero_aula = ?');
    $stmtAula->bind_param('s', $numAula);
    $stmtAula->execute();
    $resultAula = $stmtAula->get_result();

    // Verificar si la asignatura y el aula existen
    if ($resultAsignatura->num_rows > 0 && $resultAula->num_rows > 0) {
        // Insertar la clase en la base de datos
        $stmtInsert = $mysqli->prepare("INSERT INTO clases (codigo_asignatura, numero_aula, cedula_prof, tema_clase, texto_clase, fecha) VALUES (?, ?, ?, ?, ?, ?)");
        $stmtInsert->bind_param("ssssss", $codigo, $numAula, $prof_cedula, $tema, $transcripcion, $fecha);

        // Ejecutar la consulta de inserción
        if ($stmt->execute()) {
            // Envía una respuesta JSON indicando que la operación fue exitosa
            echo json_encode(array("success" => true, "message" => "Guardado correctamente."));
        } else {
            // Envía una respuesta JSON con el mensaje de error
            echo json_encode(array("success" => false, "message" => "Ocurrió un error al guardar la transcripción: " . $stmt->error));
        }

        $stmt->close();
    } else {
        // Envía una respuesta JSON indicando que el número de aula o código de asignatura no existe
        echo json_encode(array("success" => false, "message" => "El número de aula o código de asignatura no existe."));
    }
} else {
    // Si no se enviaron todos los datos necesarios, envía una respuesta JSON con un mensaje de error
    echo json_encode(array("success" => false, "message" => "No se han recibido todos los datos necesarios"));
}
