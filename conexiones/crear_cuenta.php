<?php

echo '<style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            background-color: #007bff; /* Azul brillante */
            color: #fff; /* Texto blanco */
        }

        .card {
            width: 300px;
            padding: 20px;
            border-radius: 8px;
            background-color: #ffffff; /* Fondo blanco */
            color: #007bff; /* Texto azul */
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Sombra suave */
        }

        .error-message {
            color: #dc3545; /* Rojo oscuro */
            font-weight: bold;
        }

        .card-success {
            width: 300px;
            padding: 20px;
            border-radius: 8px;
            background-color: #ffffff; /* Fondo blanco */
            color: #28a745; /* Texto verde */
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Sombra suave */
        }

        .success-message {
            color: #28a745; /* Verde */
            font-weight: bold;
        }
    </style>';



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
        echo "<script>
        // Esperar 4 segundos antes de redirigir
        setTimeout(function() {
            // Redirigir a otra página
            window.location.href = 'conexiones/inicio_sesion.php';
        }, 3000); // 4000 milisegundos = 4 segundos
    </script>";
        echo '<script language="javascript">alert("Cuenta creada correctamente");window.location.href="/conexiones/inicio_sesion.php";</script>';
        // Cerrar la conexión
        mysqli_close($mysqli);
    } else {
        // Si ya existe un usuario con esa cédula, mostrar un mensaje de error
        echo '<script language="javascript">alert("Ya tiene una cuenta registrada");</script>';
    }
}
?>