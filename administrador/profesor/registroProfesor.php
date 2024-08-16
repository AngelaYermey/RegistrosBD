<?php
echo '<style>
body {
    font-family: "Quicksand", sans-serif;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;
    margin: 0;
    background-color: #f4f4f9; /* Fondo general */
}

/* Estilo base para las tarjetas de alerta */
.card {
    width: 450px; /* Ancho de la tarjeta */
    padding: 40px;
    border-radius: 12px; /* Bordes redondeados */
    box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1); /* Sombra pronunciada */
    text-align: center;
    position: relative;
    margin-top: 20px; 
}


.card-success {
    background-color: #e7f5ff; /* Fondo azul claro */
    border-left: 6px solid #2358d3; /* Borde izquierdo*/
    color: #2358d3; /* Color del texto */
}

/* Estilo para la tarjeta de error */
.card-danger {
    background-color: #fdecea; /* Fondo rojo claro */
    border-left: 6px solid #d9534f; /* Borde izquierdo grueso */
    color: #d9534f; /* Color del texto */
}

/* Estilo para los mensajes dentro de las tarjetas */
.card-success .success-message,
.card-danger .danger-message {
    font-size: 28px; 
    font-weight: bold; 
    margin-bottom: 25px; 
}

/*iconos en las tarjetas */
.card .icon {
    font-size: 60px; /* tamaño del icono */
    margin-bottom: 20px; 
}

/* Color para el icono de éxito */
.card-success .icon {
    color: #2358d3; /* Azul */
}

/* Color para el icono de error */
.card-danger .icon {
    color: #d9534f; /* Rojo */
}

/* Media query para dispositivos móviles */
@media (max-width: 480px) {
    .card {
        width: 95%; /* Ajuste de ancho para pantallas pequeñas */
        padding: 30px; /* Ajuste del padding */
    }

    .card .icon {
        font-size: 50px; /* Reducción del tamaño del icono  */
    }

    .card-success .success-message,
    .card-danger .danger-message {
        font-size: 24px; /* Ajuste del tamaño del texto  */
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
  $stmt = $mysqli->prepare('SELECT cedula_prof FROM profesores WHERE cedula_prof = ?');
  $stmt->bind_param('s', $cedula);
  $stmt->execute();
  $resultado = $stmt->get_result();

  // Verificar si ya existe el usuario
  if ($resultado->num_rows > 0) {
    echo '<div class="card card-danger">
            <p class="danger-message">Error: Ya existe una cuenta registrada con esta cédula</p>
          </div>';
  } else {
    $stmt = $mysqli->prepare('INSERT INTO profesores (cedula_prof, nombre, apellido, email, contraseña, cedula_admin) VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->bind_param('ssssss', $cedula, $nombre, $apellido, $email, $contraseña, $admin_cedula);
    $stmt->execute();
    echo '<div class="card card-success">
    <p class="success-message">Registrado correctamente</p>
  </div>';
  } 
  $stmt->close();
  $mysqli->close();
  sleep(3); // Espera 3 segundos
  header("Location: formCrearcuentaProfesor.php");
  exit(); // Asegurarse de que el script se detiene después de la redirección

  // Cerrar la conexión
 
  
}
