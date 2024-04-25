<?php
error_reporting(E_ALL);
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

include 'conexiones/conector.php';
if (isset($_POST['crear'])) {
    $con = new Conexion();
    $mysqli = $con->conectar();

    // Inicializar variables
    $cedula = $_POST['cedula'];
    $nombre = $_POST['nom'];
    $apellido = $_POST['ape'];
    $email = $_POST['correo'];
    $contraseña = password_hash($_POST['pass'], PASSWORD_DEFAULT); // Hashear la contraseña para almacenamiento seguro

    // Verificar qué tipo de usuario se está registrando
    $tipo_usuario = $_POST['tipo_usuario'];

    // Consultar si ya existe un usuario con la cédula proporcionada
    $resultado = $mysqli->query('SELECT cedula FROM ' . $tipo_usuario . ' WHERE cedula="' . $cedula . '"');
    $fila = $resultado->fetch_assoc();

    // Si no existe un usuario con esa cédula, proceder con el registro
    if (empty($fila['cedula'])) {
        // Insertar el nuevo usuario en la tabla correspondiente según el tipo de usuario
        if ($tipo_usuario === 'estudiantes') {
            $facultad = $_POST['facultad'];
            $carrera = $_POST['carrera'];

            mysqli_query($mysqli,  'INSERT INTO estudiantes(cedula, nombre, apellido, email, facultad, carrera, contraseña) VALUES ("' . $cedula . '", "' . $nombre . '", "' . $apellido . '", "' . $email . '", "' . $facultad . '", "' . $carrera . '", "' . $contraseña . '")');
        } elseif ($tipo_usuario === 'profesores') {

            mysqli_query($mysqli,  'INSERT INTO profesores(cedula, nombre, apellido, email, contraseña) VALUES ("' . $cedula . '", "' . $nombre . '", "' . $apellido . '", "' . $email . '", "' . $contraseña . '")');
        }

        // Mostrar mensaje de éxito y redirigir al usuario a la página de inicio de sesión
        echo '<div class="card-success">
        <p class="success-message">Cuenta creada correctamente</p>
    </div>';
        echo "<script>
    // Esperar 5 segundos antes de redirigir
    setTimeout(function() {
        // Redirigir a otra página
        window.location.href = 'FormularioInicioSesion.html';
    }, 5000); // 5000 milisegundos = 5 segundos
</script>";
        // Cerrar la conexión
        mysqli_close($mysqli);
    } else {
        // Si ya existe un usuario con esa cédula, mostrar un mensaje de error
        echo '<div class="card-success">
        <p class="success-message">Ya existe una cuenta registrada</p>
    </div>';
        echo "<script>
    // Esperar 5 segundos antes de redirigir
    setTimeout(function() {
        // Redirigir a otra página
        window.location.href = 'FormularioCrearCuenta.html';
    }, 5000); // 5000 milisegundos = 5 segundos
</script>";
    }
}
