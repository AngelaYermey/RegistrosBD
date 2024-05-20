<?php
echo '<style>
body {
   font-family: Arial, sans-serif;
   display: flex;
   align-items: center;
   justify-content: center;
   height: 100vh;
   margin: 0;
   background-color: #FFFFFF; /* Blanco para el fondo */
}

.card {
   width: 350px;
   padding: 30px;
   border-radius: 12px;
   background-color: #FDF0D5; 
   color: #333; /* Texto oscuro */
   text-align: center;
   box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1); /* Sombra suave */
}

.card p {
   font-size: 30px; /* Tamaño de fuente más grande para el título */
   margin-bottom: 20px; /* Espacio adicional debajo del título */
}

.error-message {
   color: #EF233C; /* Rojo oscuro */
   font-weight: bold;
}

.card-success {
   width: 350px;
   padding: 30px;
   border-radius: 12px;
   background-color: #EDF2F4;
   color: #780000; /* Rojo oscuro */
   text-align: center;
   box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1); /* Sombra suave */
}

.success-message {
   color: #C1121F; /* Rojo oscuro */
   font-weight: bold;
}
</style>
';

include '../db_Conexion/conector.php';

session_start();
if (isset($_POST['btnCrear'])) {
    $con = new Conexion();
    $mysqli = $con->conectar();

    // Inicializar variables
    $nombre = $_POST['nom'];
    $apellido = $_POST['ape'];
    $cedula = $_POST['cedula'];
    $correo = $_POST['correo'];
    $facultad = $_POST['facultad'];
    $carrera = $_POST['carrera'];
    $año = $_POST['año'];
    $centro_regional = $_POST['cr'];
    $contraseña = $_POST['pass'];

    // Obtener la cédula del administrador de la sesión
    $admin_cedula = $_SESSION['usuario'];

    // Verificar si ya existe un usuario con la cédula proporcionada
    $stmt = $conn->prepare("SELECT cedula_estudiante FROM estudiantes WHERE cedula_estudiante = ?");
    $stmt->bind_param("s", $cedula);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar el número de filas devueltas por la consulta
    if ($resul->num_rows > 0) {
        echo '<div class="alert alert-danger"></div>';
        echo '<div class="card-success">
        <p class="success-message">Error: Ya existe una cuenta registrada con esta cédula</p>
    </div>';
        echo "<script>
        // Esperar 4 segundos antes de redirigir
        setTimeout(function() {
            // Redirigir a otra página
            window.location.href = 'formCrearcuenta.html';
        }, 4000); // 4000 milisegundos = 4 segundos
    </script>";
    } else {

        // Insertar nuevo usuario en la tabla de estudiantes
        $stmt = $conn->prepare("INSERT INTO estudiantes (nombre, apellido, cedula_estudiante, correo, facultad, carrera, año, centro_regional, contraseña, admin_cedula) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssss", $nombre, $apellido, $cedula, $correo, $facultad, $carrera, $año, $centro_regional, $contraseña, $admin_cedula);
        if ($stmt->execute()) {
            echo '<div class="card-success">
       <p class="success-message">Registrado correctamente</p>
   </div>';
            echo "<script>
       // Esperar 4 segundos antes de redirigir
       setTimeout(function() {
           // Redirigir a otra página
           window.location.href = 'formCrearcuentaEstudiante.php';
       }, 4000); // 4000 milisegundos = 4 segundos
   </script>";
        } else {
            echo "Error al registrar usuario: " . $stmt->error;
        }
        $stmt->close();
    }

    // Cerrar la conexión
    mysqli_close($mysqli);
}
