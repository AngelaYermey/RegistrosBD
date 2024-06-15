<?php

if (isset($_POST["btnModificar"])) {
    // Recoger los datos del formulario
   // error_reporting(E_ALL);
    //ini_set('display_errors', 1); 

    $nombre = $_POST['nom'];
    $apellido = $_POST['ape'];
    $cedulaNueva = $_POST['nueva_cedula'];
    $cedulaAntigua = $_POST['cedAntigua'];
    $correo = $_POST['correo'];
    $facultad = $_POST['facultad'];
    $carrera = $_POST['carrera'];
    $año = $_POST['año'];
    $centro_regional = $_POST['id_centroRegional'];
    $aula = $_POST['aula'];
    $contraseña = $_POST['pass'];

    $con = new Conexion();
    $mysqli = $con->conectar();

    // Consultar si el aula existe
    $sql_aula = "SELECT * FROM aula WHERE numero_aula = ?";
    $stmt_aula = $mysqli->prepare($sql_aula);
    $stmt_aula->bind_param("s", $aula);
    $stmt_aula->execute();
    $result_aula = $stmt_aula->get_result();
    
    // Verificar si se encontró el aula
    if ($result_aula->num_rows == 0) {
        ?>
        <div class="alert alert-danger" role="alert">
            <?php echo "El aula ingresada no existe"; ?>
        </div>
        <?php
        exit; // Finalizar la ejecución del script después de mostrar el mensaje
    }

    // Construir la consulta SQL para actualizar los datos del estudiante
    $sql_update = "UPDATE estudiantes SET nombre=?, apellido=?, cedula_estudiante=?, email=?, facultad=?, carrera=?, id_centroRegional=?, año=?, numero_aula=?, contraseña=? WHERE cedula_estudiante=?";

    // Preparar la consulta
    $stmt = $mysqli->prepare($sql_update);

    // Verificar si la preparación de la consulta fue exitosa
    if ($stmt) {
        // Asociar los parámetros
        $stmt->bind_param("sssssssssss", $nombre, $apellido, $cedulaNueva, $correo, $facultad, $carrera, $centro_regional, $año,  $aula, $contraseña, $cedulaAntigua);
        // Ejecutar la consulta
        $stmt->execute();
        // Verificar si se realizó alguna actualización
        if ($mysqli->affected_rows > 0) {
           ?>
            <center>
                <div class="alert alert-success" role="alert">
                    <?php echo "Registro actualizado correctamente"; ?>
                </div>
            </center>
            <script>
                setTimeout(function() {
                    window.location.href = 'tablaEstudiante.php';
                }, 2900);
            </script>
        <?php
            exit; // Finalizar la ejecución del script después de la redirección
        } else {
        ?>
            <div class="alert alert-warning" role="alert">
                <?php echo "No se realizó ninguna actualización en el registro"; ?>
            </div>
        <?php
        }
    } else {
        ?>
        <div class="alert alert-danger" role="alert">
            <?php echo "Error al preparar la consulta: " . $mysqli->error; ?>
        </div>
         <script>
                setTimeout(function() {
                    window.location.href = 'tablaEstudiante.php';
                }, 2900);
            </script>
    <?php
    }

    // Cerrar la conexión
    $mysqli->close();
} 

?>
