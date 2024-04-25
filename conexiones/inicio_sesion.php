<?php
session_start();
include 'conexiones/conector.php';

if (isset($_POST['iniciar'])) {
    $con = new Conexion();
    $mysqli = $con->conectar();

    $cedula = $_POST['cedula'];
    $pass = $_POST['pass'];

    // Consultar si el usuario es un estudiante
    $resultado_estudiante = $mysqli->query('SELECT cedula FROM estudiantes WHERE cedula="' . $cedula . '" AND contraseña="' . $pass . '"');
    $fila_estudiante = $resultado_estudiante->fetch_assoc();

    // Consultar si el usuario es un profesor
    $resultado_profesor = $mysqli->query('SELECT cedula FROM profesores WHERE ced_profesor="' . $cedula . '" AND contraseña="' . $pass . '"');
    $fila_profesor = $resultado_profesor->fetch_assoc();

    if (!empty($fila_estudiante['cedula'])) {
        // Si el usuario es un estudiante, establecer sesión y redirigir
        $_SESSION['cedula'] = $fila_estudiante['cedula'];

        // agregar pagina despues de iniciar sesión  para estudiante ejemplo 
        header('Location: bienvenido.php');


        exit;
    } elseif (!empty($fila_profesor['cedula'])) {
        // Si el usuario es un profesor, establecer sesión y redirigir
        $_SESSION['cedula'] = $fila_profesor['cedula'];


       // agregar pagina despues de iniciar sesión ejemplo header('Location: admin_profesor.php');
       header('Location: guardarNotas.php');
       

        exit;
    } else {
        echo '<style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            background-color: #007bff; /* Azul brillante */
            color: #fff; /* Texto blanco */
        }

        .card {
            width: 300px;
            padding: 20px;
            border-radius: 8px;
            background-color: #ffffff; /* Fondo blanco */
            color: #007bff; /* Texto azul */
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Sombra suave */
        }

        .error-message {
            color: #dc3545; /* Rojo oscuro */
            font-weight: bold;
        }

        .card-success {
            width: 300px;
            padding: 20px;
            border-radius: 8px;
            background-color: #ffffff; /* Fondo blanco */
            color: #28a745; /* Texto verde */
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Sombra suave */
        }

        .success-message {
            color: #28a745; /* Verde */
            font-weight: bold;
        }
    </style>';
        // Si el usuario no es ni estudiante ni profesor, mostrar mensaje de error
        $error_message = 'No existe el usuario o la contraseña es incorrecta';
        echo '<div class="card">
        <p class="error-message">¡Error! cédula o contraseña incorrecta.</p>
    </div>';
    }
}
?>

<?php if (isset($error_message)) : ?>
   <div class="error">
     <?php echo $error_message; ?>
      </div>
<?php endif; ?> 