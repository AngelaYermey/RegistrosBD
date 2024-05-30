<?php
session_start();
include 'db_Conexion/conector.php'; // Incluir el archivo de conexión

if (isset($_POST['iniciar'])) {
    // conectar a la base de datos
    $con = new Conexion();
    $mysqli = $con->conectar();

    //Obtener las variables del formulario
    $cedula = $_POST['cedula'];
    $pass = $_POST['pass'];
    $tipo_usuario = $_POST['tipo_usuario'];

    $_SESSION['usuario'] = $cedula;

    // Determinar la tabla y la página de redireccionamiento según el tipo de usuario
    $tabla = '';
    $redireccion = '';

    switch ($tipo_usuario) {
        case 'administrador':
            $tabla = 'administradores';
            $redireccion = 'administrador/adminUsuario.html'; // Cambiar por la página de administrador
            $columna = 'cedula_admin';
            break;
        case 'profesor':
            $tabla = 'profesores';
            $redireccion = 'bienvenido.html'; // Cambiar por la página de profesor
            $columna = 'cedula_prof';
            break;
        case 'estudiante':
            $tabla = 'estudiantes';
            $redireccion = 'estudiantes/interfazClases.php'; // Cambiar por la página de estudiante
            $columna = 'cedula_estudiante';

            break;
        default:
            mostrarMensajeError();
            exit;
    }

    // Consultar si el usuario existe en la tabla correspondiente
    $resultado = $mysqli->query('SELECT * FROM ' . $tabla . ' WHERE ' . $columna . '="' . $cedula . '" AND contraseña="' . $pass . '"');

    if ($resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();
        $_SESSION['cedula'] = $fila[$columna];

        // Si el usuario es un estudiante, obtener el centro regional
        if ($tipo_usuario === 'estudiante') {
            $centroRegionalID = $fila['id_centroRegional'];
            $consultaCentroRegional = $mysqli->query('SELECT nombre_centro FROM centros_regionales WHERE id_centroRegional = ' . $centroRegionalID);
            $centroRegional = $consultaCentroRegional->fetch_assoc();
            $_SESSION['centro_regional'] = $centroRegional['nombre_centro'];
        }

        header('Location: ' . $redireccion);
        exit;
    } else {
        // Si el usuario no es válido, mostrar un mensaje de error y redirigir al formulario de inicio de sesión
        mostrarMensajeError();
        exit;
    }
}


// Función para mostrar mensaje de error y redirigir al formulario de inicio de sesión
function mostrarMensajeError()
{
    echo '    
        <div class="card">
            <p class="error-message">¡Error!</br> Cédula o contraseña incorrecta.</p>
        </div>
        <script>
            // Redirigir al formulario de inicio de sesión 
            setTimeout(function() {
                window.location.href = "formularioIniciosesion.html"; // Ajusta la ruta según la ubicación del formulario de inicio de sesión
            }, 3000); 
        </script>';
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
 
}
