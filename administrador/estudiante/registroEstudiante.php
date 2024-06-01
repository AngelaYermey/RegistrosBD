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

if (isset($_POST['btnCrear'])) {
    // Inicializar variables
    $nombre = $_POST['nom'];
    $apellido = $_POST['ape'];
    $cedula = $_POST['cedula'];
    $correo = $_POST['correo'];
    $facultad = $_POST['facultad'];
    $carrera = $_POST['carrera'];
    $año = $_POST['año'];
    $centro_regional = $_POST['id_centroRegional'];
    $aula = $_POST['aula'];
    $contraseña = $_POST['pass'];

    // Obtener la cédula del administrador de la sesión
    $admin_cedula = $_SESSION['usuario'];

    // Verificar si ya existe un usuario con la cédula proporcionada
    $stmt = $mysqli->prepare("SELECT cedula_estudiante FROM estudiantes WHERE cedula_estudiante = ?");
    $stmt->bind_param("s", $cedula);
    $stmt->execute();
    $result = $stmt->get_result();
   
    // Verificar el número de filas devueltas por la consulta
    if ($result->num_rows > 0) {
        echo '<div class="alert alert-danger"></div>';
        echo '<div class="card-success">
        <p class="success-message">Error: Ya existe una cuenta registrada con esta cédula</p>
    </div>';
        echo "<script>
        // Esperar 4 segundos antes de redirigir
        setTimeout(function() {
            // Redirigir a otra página
            window.location.href = 'formCrearcuenta.html';
        }, 4000); // 4000 milisegundos = 4 segundos
    </script>";
    } else {
        // Insertar nuevo usuario en la tabla de estudiantes
        $stmt = $mysqli->prepare("INSERT INTO estudiantes (nombre, apellido, cedula_estudiante, email, facultad, carrera, año, id_centroRegional, numero_aula, contraseña, cedula_admin) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssssss", $nombre, $apellido, $cedula, $correo, $facultad, $carrera, $año, $centro_regional, $aula, $contraseña, $admin_cedula);
        if ($stmt->execute()) {
            echo '<div class="card-success">
       <p class="success-message">Registrado correctamente</p>
   </div>';
            echo "<script>
       // Esperar 4 segundos antes de redirigir
       setTimeout(function() {
           // Redirigir a otra página
           window.location.href = 'formCrearcuentaEstudiante.php';
       }, 3500); 
   </script>";
        } else {
            echo '<div class="card-success">
            <p class="success-message">Ocurrio un error al registrar el usuario</p>
        </div>';
                 echo "<script>
            // Esperar 4 segundos antes de redirigir
            setTimeout(function() {
                // Redirigir a otra página
                window.location.href = 'formCrearcuentaEstudiante.php';
            }, 3300);
        </script>";
           
        }
        $stmt->close();
    }

    // Cerrar la conexión
    mysqli_close($mysqli);
}
