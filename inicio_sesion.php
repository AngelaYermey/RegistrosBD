<?php
session_start();
include 'conexiones\conector.php';

if (isset($_POST['iniciar'])) {
    $con = new Conexion();
    $mysqli = $con->conectar();

    $cedula = $_POST['cedula'];
    $pass = $_POST['pass'];

    // Consultar si el usuario es un estudiante
    $resultado_estudiante = $mysqli->query('SELECT cedula FROM estudiantes WHERE cedula="' . $cedula . '" AND contraseña="' . $pass . '"');
    $fila_estudiante = $resultado_estudiante->fetch_assoc();

    // Consultar si el usuario es un profesor
    $resultado_profesor = $mysqli->query('SELECT cedula FROM profesores WHERE cedula="' . $cedula . '" AND contraseña="' . $pass . '"');
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
            background-color: #e9f0f6; /* Azul pálido para el fondo */
        }
        
        .card {
            width: 350px;
            padding: 30px;
            border-radius: 12px;
            background-color: #cce0f5; /* Azul claro */
            color: #333; /* Texto oscuro */
            text-align: center;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1); /* Sombra suave */
        }
        
        .card p {
            font-size: 28px; /* Tamaño de fuente más grande para el título */
            margin-bottom: 20px; /* Espacio adicional debajo del título */
        }
        
        .error-message {
            color: #dc3545; /* Rojo */
            font-weight: bold;
        }
        
        .card-success {
            width: 350px;
            padding: 30px;
            border-radius: 12px;
            background-color: #d2e9f7; /* Azul claro */
            color: #007bff; /* Azul */
            text-align: center;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1); /* Sombra suave */
        }
        
        .success-message {
            color: #007bff; /* Azul */
            font-weight: bold;
        }
        </style>
        ';
        // Si el usuario no es ni estudiante ni profesor, mostrar mensaje de error
        echo '<div class="card">
        <p class="error-message">¡Error!</br> Cédula o contraseña incorrecta.</p>
         </div>';
         
         echo "<script>
         // Esperar 4 segundos antes de redirigir
         setTimeout(function() {
             // Redirigir a otra página
             window.location.href = 'FormularioInicioSesion.html';
         }, 4000); 
     </script>";
    }
}
?>

