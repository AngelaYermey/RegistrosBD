<?php
session_start();
include 'conector.php';

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

        // agregar pagina despues de iniciar sesión ejemplo 
        header('Location: bienvenido.php');


        exit;
    } elseif (!empty($fila_profesor['cedula'])) {
        // Si el usuario es un profesor, establecer sesión y redirigir
        $_SESSION['cedula'] = $fila_profesor['cedula'];


       // agregar pagina despues de iniciar sesión ejemplo header('Location: admin_profesor.php');
       header('Location: bienvenido Prof.php');
       

        exit;
    } else {
        // Si el usuario no es ni estudiante ni profesor, mostrar mensaje de error
        $error_message = 'No existe el usuario o la contraseña es incorrecta';

    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/Diseñocuenta.css">
    <title>Login</title>
</head>

<body>
    <section>
        <div class="imgbx">
            <img src="imagen/night.jpg">
        </div>
        <div class="contentbx">
            <div class="form">
                <h2>Iniciar sesión</h2>
                <form action="inicioSesion.php" method="POST">
                    <div class="inputbx">
                        <label>Cédula</label>
                        <input type="text" name="cedula" required>
                    </div>

                    <div class="inputbx">
                        <label>Contraseña</label>
                        <input type="password" name="pass" required>
                    </div>

                    <div class="inputbx">
                        <br><br><br><br>
                        <input type="submit" value="Iniciar sesión" name="iniciar" required>
                    </div>
                    <center>
                    <?php if (isset($error_message)) : ?>
                        <div class="error">
                            <?php echo $error_message; ?>
                        </div>
                    <?php endif; ?> </center>

                    <div class="inputbx">
                        <br><br>
                        <center>
                            <p>¿No tienes una cuenta? <a href="CrearCuen.php">Registrarme</a></p>
                        </center>
                    </div>

                </form>
            </div>
        </div>
    </section>
</body>

</html>
