<?php
echo '<style>
body {
    font-family: Arial, sans-serif;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;
    margin: 0;
  }
  
  .card-success {
    width: 350px;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0px 0px 2px #6ad151;
    background-color: rgba(225, 238, 230, 0.964);
    color: #62ce60;
    text-align: center;
    cursor: pointer;
    position: relative;
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
  
  .success-message, .danger-message {
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
</style>
';

// Incluir el archivo de conexión a la base de datos
include '../../db_Conexion/conector.php';

// Iniciar sesión
session_start();

// Verificar si se ha enviado el formulario para crear una cuenta
if (isset($_POST['btnCrearCuenta'])) {
    // Crear una instancia de la clase Conexion para establecer la conexión a la base de datos
    $con = new Conexion();
    $mysqli = $con->conectar();

    // Inicializar variables con los datos enviados desde el formulario
    $cedula = $_POST['cedula'];
    $nombre = $_POST['nom'];
    $apellido = $_POST['ape'];
    $email = $_POST['correo'];
    $contraseña = $_POST['pass']; // Hashear la contraseña para almacenamiento seguro

    // Obtener la cédula del administrador de la sesión
    $admin_cedula = $_SESSION['usuario'];

    // Consultar si ya existe un usuario con la cédula proporcionada
    $resultado = $mysqli->query('SELECT cedula_prof FROM profesores WHERE cedula_prof="' . $cedula . '"');

    // Verificar el número de filas devueltas por la consulta
    if ($resultado->num_rows > 0) {
        // Mostrar mensaje de error si ya existe un usuario con la cédula proporcionada
        echo '<div class="alert alert-danger"></div>';
        echo '<div class="card-success">
        <p class="success-message">Error: Ya existe una cuenta registrada con esta cédula</p>
    </div>';
        echo "<script>
        // Esperar 4 segundos antes de redirigir
        setTimeout(function() {
            // Redirigir a otra página
            window.location.href = 'formCrearcuentaProfesor.html';
        }, 4000); // 4000 milisegundos = 4 segundos
    </script>";
    } else {
        // Insertar un nuevo registro en la tabla profesores con los datos proporcionados
        mysqli_query($mysqli, 'INSERT INTO profesores(cedula_prof, nombre, apellido, email, contraseña, cedula_admin) VALUES ("' . $cedula . '", "' . $nombre . '", "' . $apellido . '", "' . $email . '", "' . $contraseña . '", "' . $admin_cedula . '")');
        
        // Mostrar mensaje de éxito después de registrar al nuevo profesor
        echo '<div class="card-success">
        <p class="success-message">Registrado correctamente</p>
    </div>';
        echo "<script>
        // Esperar 4 segundos antes de redirigir
        setTimeout(function() {
            // Redirigir a otra página
            window.location.href = 'formCrearcuentaProfesor.php';
        }, 4000); // 4000 milisegundos = 4 segundos
    </script>";
    }

    // Cerrar la conexión
    mysqli_close($mysqli);
}
?>
