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

include '../../db_Conexion/conector.php';

session_start();
$con = new Conexion();
$mysqli = $con->conectar();

if (isset($_POST['btn_ingDatos'])) {

  // Inicializar variables
  $nombre = $_POST['nomAsignatura'];
  $codigo = $_POST['codAsignatura'];

  // Verificar si ya existe
  $stmt = $mysqli->prepare("SELECT codigo_asignatura FROM asignaturas WHERE codigo_asignatura = ?");

  $stmt->bind_param("s", $codigo);
  $stmt->execute();
  $result = $stmt->get_result();

  // Verificar el número de filas devueltas por la consulta
  if ($result->num_rows > 0) {
    echo '<div class="card-danger">
        <p class="danger-message">Error: Ya existe registrado</p>
    </div>';
    echo "<script>
        setTimeout(function() {
            // Redirigir a otra página
            window.location.href = 'asignaturas.php';
        }, 2900); 
    </script>";
  } else {
    // Insertar nuevo usuario en la tabla de estudiantes
    $stmt = $mysqli->prepare("INSERT INTO asignaturas (codigo_asignatura, nombre) VALUES (?, ?)");
    $stmt->bind_param("ss", $codigo, $nombre);
    if ($stmt->execute()) {
      echo '<div class="card-success">
       <p class="success-message">Registrado correctamente</p>
   </div>';
      echo "<script>
       // Esperar 4 segundos antes de redirigir
       setTimeout(function() {
           window.location.href = 'asignaturas.php';
       }, 2800);
   </script>";
    } else {
      echo '<div class="card-danger">
            <p class="danger-message">Error al registrar usuario</p>
        </div>';
      echo "<script>
            // Esperar 4 segundos antes de redirigir
            setTimeout(function() {
                // Redirigir a otra página
                window.location.href = 'asignaturas.php';
            }, 2900);
        </script>";
    }
    $stmt->close();
  }

  // Cerrar la conexión
  mysqli_close($mysqli);
}
