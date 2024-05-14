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
if (isset($_POST['btnCrearCuenta'])) {
    $con = new Conexion();
    $mysqli = $con->conectar();

    // Inicializar variables
    $cedula = $_POST['cedula'];
    $nombre = $_POST['nom'];
    $apellido = $_POST['ape'];
    $email = $_POST['correo'];
    $contraseña = $_POST['pass']; // Hashear la contraseña para almacenamiento seguro

    // Obtener la cédula del administrador de la sesión
    $admin_cedula = $_SESSION['usuario'];

    // Verificar qué tipo de usuario se está registrando
    $tipo_usuario = $_POST['tipo_usuario'];

    // Consultar si ya existe un usuario con la cédula proporcionada
    $resultado = $mysqli->query('SELECT cedula FROM ' . $tipo_usuario . ' WHERE cedula="' . $cedula . '"');

    // Verificar el número de filas devueltas por la consulta
    if ($resultado->num_rows > 0) {
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

        // Insertar el nuevo usuario en la tabla correspondiente según el tipo de usuario
        if ($tipo_usuario === 'estudiantes') {
            $facultad = $_POST['facultad'];
            $carrera = $_POST['carrera'];
            mysqli_query($mysqli, 'INSERT INTO estudiantes(cedula, nombre, apellido, email, facultad, carrera, contraseña, admin_cedula) VALUES ("' . $cedula . '", "' . $nombre . '", "' . $apellido . '", "' . $email . '", "' . $facultad . '", "' . $carrera . '", "' . $contraseña . '", "' . $admin_cedula . '")');
        } elseif ($tipo_usuario === 'profesores') {
            mysqli_query($mysqli, 'INSERT INTO profesores(cedula, nombre, apellido, email, contraseña, admin_cedula) VALUES ("' . $cedula . '", "' . $nombre . '", "' . $apellido . '", "' . $email . '", "' . $contraseña . '", "' . $admin_cedula . '")');
        }
        echo '<div class="card-success">
        <p class="success-message">Registrado correctamente</p>
    </div>';
        echo "<script>
        // Esperar 4 segundos antes de redirigir
        setTimeout(function() {
            // Redirigir a otra página
            window.location.href = 'formCrearcuenta.php';
        }, 4000); // 4000 milisegundos = 4segundos
    </script>";
    }

    // Cerrar la conexión
    mysqli_close($mysqli);
}