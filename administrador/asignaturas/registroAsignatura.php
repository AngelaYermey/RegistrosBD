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

include '../../db_Conexion/conector.php';

session_start();
$con = new Conexion();
$mysqli = $con->conectar();

if (isset($_POST['btn_ingDatos'])) {

    // Inicializar variables
    $nombre = $_POST['nombre'];
    $codigo = $_POST['codigo'];
    $centro_regional = $_POST['id_centroRegional'];

    // Obtener la cédula del administrador de la sesión
    $admin_cedula = $_SESSION['usuario'];

    // Verificar si ya existe un usuario con la cédula proporcionada
    $stmt = $mysqli->prepare("SELECT codigo_asignatura FROM asignaturas WHERE codigo_asignatura = ?");

    $stmt->bind_param("s", $codigo);
    $stmt->execute();
    $result = $stmt->get_result();
   
    // Verificar el número de filas devueltas por la consulta
    if ($result->num_rows > 0) {
        echo '<div class="alert alert-danger"></div>';
        echo '<div class="card-success">
        <p class="success-message">Error: Ya existe registrado</p>
    </div>';
        echo "<script>
        // Esperar 4 segundos antes de redirigir
        setTimeout(function() {
            // Redirigir a otra página
            window.location.href = 'asignaturas.php';
        }, 4000); // 4000 milisegundos = 4 segundos
    </script>";
    } else {
        // Insertar nuevo usuario en la tabla de estudiantes
        $stmt = $mysqli->prepare("INSERT INTO asignaturas (codigo_asignatura, nombre, id_centroRegional, cedula_admin) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $codigo, $nombre, $centro_regional, $admin_cedula);
        if ($stmt->execute()) {
            echo '<div class="card-success">
       <p class="success-message">Registrado correctamente</p>
   </div>';
            echo "<script>
       // Esperar 4 segundos antes de redirigir
       setTimeout(function() {
           // Redirigir a otra página
           window.location.href = 'Asignaturas.php';
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
