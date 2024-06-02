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



session_start();

$validar = $_SESSION['usuario'];

if ($validar == null || $validar =='') {
  header("Location: ../../formularioIniciosesion.html");
  die();
}

// Verifica si se ha enviado el código de la asignatura a eliminar
if (isset($_GET['codigoAsignatura'])) {
    // Obtiene el código de la asignatura a eliminar desde la URL
    $codigoAsig = $_GET['codigoAsignatura'];

    // Incluye el archivo de conexión a la base de datos
    include '../../db_Conexion/conector.php';

    // Instancia un objeto de la clase Conexion
    $conexion_obj = new Conexion();

    // Establece la conexión a la base de datos
    $conn = $conexion_obj->conectar();

    // Prepara la consulta SQL para eliminar las clases asociadas a la asignatura
    $eliminar_clases = $conn->prepare("DELETE FROM clases WHERE codigo_asignatura = ?");
    $eliminar_clases->bind_param("s", $codigoAsig);

    // Ejecuta la consulta para eliminar las clases asociadas a la asignatura
    if ($eliminar_clases->execute()) {
        // Ahora que las clases asociadas han sido eliminadas, puedes eliminar la asignatura
        $eliminar_asignatura = $conn->prepare("DELETE FROM asignaturas WHERE codigo_asignatura = ?");
        $eliminar_asignatura->bind_param("s", $codigoAsig);

        // Ejecuta la consulta para eliminar la asignatura
        if ($eliminar_asignatura->execute()) {
            // Si la eliminación es exitosa, redirecciona a la tabla de asignaturas
            echo "<script>window.location.href = 'tablaAsignatura.php';</script>";
            exit();
        } else {
            // Si hay un error al eliminar la asignatura, muestra un mensaje de error
            echo "<div class='card-danger alert-danger'>
                    <p class='danger-message'>Error al eliminar la asignatura.</p>
                    <i class='fa fa-times'></i>
                </div>";
                echo "<script>
                setTimeout(function() {
                    // Redirigir
                    window.location.href = 'tablaAsignaturas.php';
                }, 3000); 
            </script>";              
        }
    } else {
        // Si hay un error al eliminar las clases asociadas a la asignatura, muestra un mensaje de error
        echo "<div class='card-danger alert-danger'>
                <p class='danger-message'>Error al eliminar las clases asociadas a la asignatura.</p>
                <i class='fa fa-times'></i>
            </div>";
            echo "<script>
            setTimeout(function() {
                // Redirigir
                window.location.href = 'tablaAsignaturas.php';
            }, 3000); 
        </script>";
    }

    // Cierra la conexión a la base de datos
    $conn->close();
} else {
    // Si no se ha proporcionado el código de la asignatura a eliminar, muestra un mensaje de error
    echo "<div class='card-danger alert-danger'>
            <p class='danger-message'>No se ha proporcionado el código de la asignatura a eliminar.</p>
            <i class='fa fa-times'></i>
        </div>";
        echo "<script>
       setTimeout(function() {
           // Redirigir
           window.location.href = 'tablaAsignaturas.php';
       }, 3000); 
   </script>";
}



?>
