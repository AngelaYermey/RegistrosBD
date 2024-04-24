<?php

include('conector.php');

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
        <div class="contentbx">
            <div class="form">
                <h2>Registrarse</h2>
                <form action="CrearCuen.php" method="POST">
                    <div class="inputbx">
                        <div class="form-floating mb-3">
                            <label for="nom">Nombre</label>
                            <input type="text" id="nom" class="form-control" name="nom" required>
                        </div>

                        <div class="form-floating mb-3">
                            <label for="ape">Apellido</label>
                            <input type="text" id="ape" class="form-control" name="ape" required>
                            <!-- Cualquier carácter independientemente de la nacionalidad, con un tamaño entre 2 y 64 -->
                        </div>

                        <div class="form-floating mb-3">
                            <label for="cedula">Cédula</label>
                            <input type="text" id="cedula" name="cedula" class="form-control" required>
                        </div>

                        <div class="form-floating mb-3">
                            <label for="correo">Correo Institucional</label>
                            <input type="email" id="correo" name="correo" class="form-control">
                            <!-- Patrón regular para validar el correo electrónico con el dominio específico -->
                        </div>

                        <div class="form-floating mb-3">
                            <label for="tipo_usuario">Tipo de Usuario:</label>
                            <select id="tipo_usuario" name="tipo_usuario" class="form-select" required title="Por favor, escoja una opción." onchange="mostrarCamposExtra()">
                                <option value="">Escoger opción...</option>
                                <option value="estudiantes">Estudiante</option>
                                <option value="profesores">Profesor</option>
                            </select>
                        </div>

                        <div id="info_extra_estudiante" style="display: none;" class="form-floating mb-3">
                            <label for="facultad">Facultad</label>
                            <input type="text" id="facultad" name="facultad" required title="Por favor, ingrese su facultad."><br><br>

                            <label for="carrera">Carrera</label>
                            <input type="text" id="carrera" name="carrera" required title="Por favor, ingrese su carrera."><br><br>
                        </div>

                        <div class="form-floating mb-3">
                            <label for="pass">Contraseña</label>
                            <input type="password" id="pass" name="pass" class="form-control" required>
                            <!-- Letras mayúsculas, minúsculas, números y los caracteres !?-. Su tamaño: entre 8 y 12 caracteres -->
                        </div>
                    </div>
                    <div class="inputbx">
                        <input type="submit" value="Crear Cuenta" name="crear">
                    </div>

                    <div class="inputbx">
                        <center>
                            <p>¿Ya tienes una cuenta? <a href="inicioSesion.php">Iniciar sesión</a></p>
                        </center>
                    </div>
                    <?php

                    if (isset($_POST['crear'])) {
                        $con = new Conexion();
                        $mysqli = $con->conectar();

                        // Inicializar variables
                        $cedula = $_POST['cedula'];
                        $nombre = $_POST['nom'];
                        $apellido = $_POST['ape'];
                        $email = $_POST['correo'];
                        $contraseña = password_hash($_POST['pass'], PASSWORD_DEFAULT); // Hashear la contraseña para almacenamiento seguro

                        // Verificar qué tipo de usuario se está registrando
                        $tipo_usuario = $_POST['tipo_usuario'];

                        // Consultar si ya existe un usuario con la cédula proporcionada
                        $resultado = $mysqli->query('SELECT cedula FROM ' . $tipo_usuario . ' WHERE cedula="' . $cedula . '"');
                        $fila = $resultado->fetch_assoc();

                        // Si no existe un usuario con esa cédula, proceder con el registro
                        if (empty($fila['cedula'])) {
                            // Insertar el nuevo usuario en la tabla correspondiente según el tipo de usuario
                            if ($tipo_usuario === 'estudiantes') {
                                $facultad = $_POST['facultad'];
                                $carrera = $_POST['carrera'];

                                mysqli_query($mysqli,  'INSERT INTO estudiantes(cedula, nombre, apellido, email, facultad, carrera, contraseña) VALUES ("' . $cedula . '", "' . $nombre . '", "' . $apellido . '", "' . $email . '", "' . $facultad . '", "' . $carrera . '", "' . $contraseña . '")');
                            } elseif ($tipo_usuario === 'profesores') {

                                mysqli_query($mysqli,  'INSERT INTO profesores(cedula, nombre, apellido, email, contraseña) VALUES ("' . $cedula . '", "' . $nombre . '", "' . $apellido . '", "' . $email . '", "' . $contraseña . '")');
                            }

                            // Mostrar mensaje de éxito y redirigir al usuario a la página de inicio de sesión
                            echo '<script language="javascript">alert("Cuenta creada correctamente");window.location.href="inicioSesion.php";</script>';
                            // Cerrar la conexión
                            mysqli_close($mysqli);
                        } else {
                            // Si ya existe un usuario con esa cédula, mostrar un mensaje de error
                            echo '<script language="javascript">alert("Ya tiene una cuenta registrada");</script>';
                        }
                    }
                    ?>


                </form>


            </div>

        </div>
    </section>

</body>
<script>
    function mostrarCamposExtra() {
        var tipoUsuario = document.getElementById("tipo_usuario").value;
        var infoExtraEstudiante = document.getElementById("info_extra_estudiante");

        if (tipoUsuario === "estudiantes") {
            infoExtraEstudiante.style.display = "block";
        } else {
            infoExtraEstudiante.style.display = "none";
        }
    }
</script>

</html>