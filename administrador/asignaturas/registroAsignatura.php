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

include '../../db_Conexion/conector.php';

session_start();
$con = new Conexion();
$mysqli = $con->conectar();

if (isset($_POST['btn_ingDatos'])) {

  // Inicializar variables
  $nombre = $_POST['nombre'];
  $codigo = $_POST['codigo'];
  $centro_regional = $_POST['id_centroRegional'];

  // Obtener la cédula del administrador de la sesión
  $admin_cedula = $_SESSION['usuario'];

  // Verificar si ya existe un usuario con la cédula proporcionada
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
        // Esperar 4 segundos antes de redirigir
        setTimeout(function() {
            // Redirigir a otra página
            window.location.href = 'asignaturas.php';
        }, 4000); // 4000 milisegundos = 4 segundos
    </script>";
  } else {
    // Insertar nuevo usuario en la tabla de estudiantes
    $stmt = $mysqli->prepare("INSERT INTO asignaturas (codigo_asignatura, nombre, id_centroRegional, cedula_admin) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $codigo, $nombre, $centro_regional, $admin_cedula);
    if ($stmt->execute()) {
      echo '<div class="card-success">
       <p class="success-message">Registrado correctamente</p>
   </div>';
      echo "<script>
       // Esperar 4 segundos antes de redirigir
       setTimeout(function() {
           // Redirigir a otra página
           window.location.href = 'asignaturas.php';
       }, 4000); // 4000 milisegundos = 4 segundos
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
            }, 4000); // 4000 milisegundos = 4 segundos
        </script>";
    }
    $stmt->close();
  }

  // Cerrar la conexión
  mysqli_close($mysqli);
}
