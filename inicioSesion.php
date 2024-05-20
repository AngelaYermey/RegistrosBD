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
            break;
        case 'profesor':
            $tabla = 'profesores';
            $redireccion = 'bienvenido.html'; // Cambiar por la página de profesor
            break;
        case 'estudiante':
            $tabla = 'estudiantes';
            $redireccion = 'bienvenido.html'; // Cambiar por la página de estudiante
            break;
        default:
            mostrarMensajeError();
            exit;
    }

    // Consultar si el usuario existe en la tabla correspondiente
    $resultado = $mysqli->query('SELECT cedula_admin FROM ' . $tabla . ' WHERE cedula_admin="' . $cedula . '" AND contraseña="' . $pass . '"');
    $fila = $resultado->fetch_assoc();

    // Si el usuario es válido, establecer la sesión y redirigir
    if (!empty($fila['cedula_admin'])) {
        $_SESSION['cedula'] = $fila['cedula_admin'];
        header('Location: ' . $redireccion);
        exit;
    }else{
        // Si el usuario no es válido, mostrar un mensaje de error y redirigir al formulario de inicio de sesión
        mostrarMensajeError();
    }
}

// Función para mostrar mensaje de error y redirigir al formulario de inicio de sesión
function mostrarMensajeError() {
    echo '
        <style>
            /* Estilos CSS aquí */
        </style>
        <div class="card">
            <p class="error-message">¡Error!</br> Cédula o contraseña incorrecta.</p>
        </div>
        <script>
            // Redirigir al formulario de inicio de sesión 
            setTimeout(function() {
                window.location.href = "formularioIniciosesion.html"; // Ajusta la ruta según la ubicación del formulario de inicio de sesión
            }, 3000); 
        </script>';
}
?>
