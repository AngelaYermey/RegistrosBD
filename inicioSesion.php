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
            $redireccion = 'administrador/adminUsuario.php'; // Cambiar por la página de administrador
            $columna = 'cedula_admin';
            break;
        case 'profesor':
            $tabla = 'profesores';
            $redireccion = 'profesores/transcripcion.php'; // Cambiar por la página de profesor
            $columna = 'cedula_prof';
            break;
        case 'estudiante':
            $tabla = 'estudiantes';
            $redireccion = 'estudiantes/tablaClases.php'; // Cambiar por la página de estudiante
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
        <div class="card-danger">
            <p class="danger-message">¡Error!</br> Cédula o contraseña incorrecta.</p>
        </div>
        <script>
            // Redirigir al formulario de inicio de sesión 
            setTimeout(function() {
                window.location.href = "formularioIniciosesion.html"; // Ajusta la ruta según la ubicación del formulario de inicio de sesión
            }, 3000); 
        </script>';

       echo '<style>
       body {
        font-family: "Quicksand", sans-serif;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
        margin: 0;
      }
      
      .card-danger {
        width: 350px;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0px 0px 2px #fa1b1b;
        background-color: rgba(236, 226, 225, 0.964);
        color: #ba0f0f;
        text-align: center;
        cursor: pointer;
        position: relative;
      }
      
      .danger-message {
        font-size: 30px;
        margin-bottom: 20px;
      }
      
      .fa-times {
        -webkit-animation: blink-1 2s infinite both;
        animation: blink-1 2s infinite both;
      }
      
      @-webkit-keyframes blink-1 {
        0%, 50%, 100% {
            opacity: 1;
        }
        25%, 75% {
            opacity: 0;
        }
      }
      
      @keyframes blink-1 {
        0%, 50%, 100% {
            opacity: 1;
        }
        25%, 75% {
            opacity: 0;
        }
      }
';
 
}
