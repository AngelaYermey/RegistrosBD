<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Estudiantes</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/5ef4b61a8f.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/Diseñocuenta.css">

</head>

<body>
    <h2 class="text-center p-4">Tabla de Estudiantes</h2>
    <div class="container">
    <div class="row justify-content-end">
        <div class="col-md-12 d-grid gap-2 d-md-flex justify-content-md-end">
        <a href="adminUsuario.html" class="btn btn-primary me-md-2 mb-2"><i class="fa-solid fa-circle-left"> Volver </i></a>
        </div>
    </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Cédula</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Apellido</th>
                            <th scope="col">Correo</th>
                            <th scope="col">Facultad</th>
                            <th scope="col">Carrera</th>
                            <th scope="col">Contraseña</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <?php
                        // Se incluye el archivo de conexión
                        include "conexiones/conector.php";
                        // Se instancia un objeto de la clase Conexion
                        $conexion_obj = new Conexion();
                        // Se establece la conexión a la base de datos
                        $conn = $conexion_obj->conectar();
                        // Se ejecuta la consulta SQL para obtener los datos de estudiantes
                        $sql = $conn->query("SELECT * FROM estudiantes");
                        // Se recorren los resultados de la consulta
                        while ($datos = $sql->fetch_object()) {
                        ?>
                            <tr>
                                <th scope="row"><?php echo $datos->cedula; ?></th>
                                <td><?php echo $datos->nombre; ?></td>
                                <td><?php echo $datos->apellido; ?></td>
                                <td><?php echo $datos->email; ?></td>
                                <td><?php echo $datos->facultad; ?></td>
                                <td><?php echo $datos->carrera; ?></td>
                                <td><?php echo $datos->contraseña; ?></td>
                                <td>
                                    <a href="" class="btn btn-small btn-warning"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <a href="" class="btn btn-small btn-danger"><i class="fa-solid fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>

                </table>
            </div>
        </div>
    </div>

</body>

</html>