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
$conexion_obj = new Conexion();
$conn = $conexion_obj->conectar();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Preparar la consulta SQL para eliminar la clase
    $stmt = $conn->prepare("DELETE FROM clases WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Redirigir de vuelta a la página de clases después de eliminar
        header("Location: clasesRegistradas.php");
    } else {
        // Si hay un error al eliminar el aula, muestra un mensaje de error
        echo "<div class='card-danger alert-danger'>
          <p class='danger-message'>Ocurrio un error al eliminar.</p>
          <i class='fa fa-times'></i>
      </div>";
        echo "<script>
      setTimeout(function() {
          // Redirigir 
          window.location.href = 'clasesRegistradas.php';
      }, 3200);
  </script>";
    }

    $stmt->close();
}

$conn->close();
