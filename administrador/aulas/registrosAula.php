<?php
echo '<style>
body {
    font-family: "Tauri", sans-serif;
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
</style>';

include '../../db_Conexion/conector.php';
session_start();

// Verificar si se ha enviado el formulario
if (isset($_POST['btn_ingDatos'])) {

    // Establecer conexión a la base de datos
    $con = new Conexion();
    $mysqli = $con->conectar();

    // Obtener los datos del formulario
    $aula = $_POST['CodAula'];
    $centro_regional = $_POST['id_centroRegional'];

    // Obtener la cédula del administrador de la sesión
    $admin_cedula = $_SESSION['usuario'];

    // Consultar si el aula ya existe
    $stmt = $mysqli->prepare("SELECT numero_aula FROM aula WHERE numero_aula = ?");
    $stmt->bind_param("s", $aula);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si ya existe el aula
    if ($result->num_rows > 0) {
        echo '<div class="card-danger alert-danger">
        <p class="danger-message">¡Error! Ya existe registrado.</p>
        <i class="fa fa-times"></i>
    </div>';
        echo "<script>
        // Esperar 4 segundos antes de redirigir
        setTimeout(function() {
            // Redirigir a otra página
            window.location.href = 'formAulas.php';
        }, 3300);
    </script>";
        
    } else {
        // Insertar el nuevo aula en la tabla
        $stmt = $mysqli->prepare("INSERT INTO aula (numero_aula, id_centroRegional) VALUES (?, ?)");
        $stmt->bind_param("ss", $aula, $centro_regional);

        if ($stmt->execute()) {
            echo '<div class="card-success alert-simple alert-success">
            <p class="success-message greencross">Registrado correctamente</p>
            <i class="fa fa-times"></i>
        </div>';
                 echo "<script>
            // Esperar 4 segundos antes de redirigir
            setTimeout(function() {
                // Redirigir a otra página
                window.location.href = 'formAulas.php';
            }, 3300);
        </script>";
        } else {
            echo '<div class="card-danger alert-danger">
            <p class="danger-message">¡Error! No se pudo completar el registro.</p>
            <i class="fa fa-times"></i>
        </div>';
            echo "<script>
            // Esperar 4 segundos antes de redirigir
            setTimeout(function() {
                // Redirigir a otra página
                window.location.href = 'formAulas.php';
            }, 3300);
        </script>";
        }
    }

    // Cerrar la conexión
    $stmt->close();
    $mysqli->close();
}
?>
