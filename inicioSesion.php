<?php
session_start();
include 'conexiones\conector.php';

if (isset($_POST['iniciar'])) {
    $con = new Conexion();
    $mysqli = $con->conectar();

    $cedula = $_POST['cedula'];
    $pass = $_POST['pass'];
    $tipo_usuario = $_POST['tipo_usuario']; // Agregamos la obtención del tipo de usuario

    $tabla = ''; //almacena el nombre de la tabla según el tipo de usuario
    $redireccion = ''; // almacena la página de redireccion según el tipo de usuario

    // Determinar la tabla y la página de redireccionamiento según el tipo de usuario
    switch ($tipo_usuario) {
        case 'administrador':
            $tabla = 'administradores';
            $redireccion = 'formularioCrearcuenta.html'; // Cambiar por la página de administrador
            break;
        case 'profesor':
            $tabla = 'profesores';
            $redireccion = 'bienvenido.php'; // Cambiar por la página de profesor
            break;
        case 'estudiante':
            $tabla = 'estudiantes';
            $redireccion = 'bienvenido.php'; // Cambiar por la página de estudiante
            break;
        default:
            mostrarMensajeError();
            exit;
    }

    // Consultar si el usuario existe en la tabla correspondiente
    $resultado = $mysqli->query('SELECT cedula FROM ' . $tabla . ' WHERE cedula="' . $cedula . '" AND contraseña="' . $pass . '"');
    $fila = $resultado->fetch_assoc();

    if (!empty($fila['cedula'])) {
        // Si el usuario es válido, establecer sesión y redirigir
        $_SESSION['cedula'] = $fila['cedula'];
        header('Location: ' . $redireccion);
        exit;
    } else {
        mostrarMensajeError();
    }
}

// Función para mostrar mensaje de error y redirigir al formulario de inicio de sesión
function mostrarMensajeError() {
    echo '
        <style>
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
