<?php

echo '<style>
body {
    font-family: "Quicksand", sans-serif;
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

session_start();

$validar = $_SESSION['usuario'];

if ($validar == null || $validar == '') {
    header("Location: ../../index.php");
    die();
}

// Verifica si se ha enviado el código del aula a eliminar
if (isset($_GET['codigoAula'])) {
    // Obtiene el código del aula a eliminar desde la URL
    $codigoAula = $_GET['codigoAula'];

    // Incluye el archivo de conexión a la base de datos
    include '../../db_Conexion/conector.php';

    // Instancia un objeto de la clase Conexion
    $conexion_obj = new Conexion();

    // Establece la conexión a la base de datos
    $conn = $conexion_obj->conectar();

    // Verifica si el código del aula está siendo utilizado en otra parte
    $consulta_uso_aula = $conn->prepare("SELECT * FROM estudiantes WHERE numero_aula = ?");
    $consulta_uso_aula->bind_param("s", $codigoAula);
    $consulta_uso_aula->execute();
    $resultados_uso_aula = $consulta_uso_aula->get_result();

    // Si se encontraron resultados, significa que el aula está siendo utilizada
    if ($resultados_uso_aula->num_rows > 0) {
        echo "<div class='card-danger alert-danger'>
                <p class='danger-message'>¡Error! El aula está siendo utilizada y no puede ser eliminada.</p>
                <i class='fa fa-times'></i>
            </div>";
            echo "<script>
            setTimeout(function() {
                // Redirigir 
                window.location.href = 'tablaAulas.php';
            }, 3500);
        </script>";
    } else {
        // Prepara la consulta SQL para eliminar el aula
        $eliminar_aula = $conn->prepare("DELETE FROM aula WHERE numero_aula = ?");
        $eliminar_aula->bind_param("s", $codigoAula);

        // Ejecuta la consulta para eliminar el aula
        if ($eliminar_aula->execute()) {
            // Si la eliminación es exitosa, redirecciona a la tabla de aulas
            echo "<script>window.location.href = 'tablaAulas.php';</script>";
            exit();
        } else {
            // Si hay un error al eliminar el aula, muestra un mensaje de error
            echo "<div class='card-danger alert-danger'>
                    <p class='danger-message'>Error al eliminar el aula.</p>
                    <i class='fa fa-times'></i>
                </div>";
            echo "<script>
                setTimeout(function() {
                    // Redirigir 
                    window.location.href = 'tablaAulas.php';
                }, 3200);
            </script>";
        }
    }

    // Cierra la conexión a la base de datos
    $conn->close();
} else {
    // Si no se ha proporcionado el código del aula a eliminar, muestra un mensaje de error
    echo "<div class='card-danger alert-danger'>
            <p class='danger-message'>No se ha proporcionado el código del aula a eliminar.</p>
            <i class='fa fa-times'></i>
        </div>";
        echo "<script>
        setTimeout(function() {
            // Redirigir 
            window.location.href = 'tablaAulas.php';
        }, 3200);
    </script>";
}
