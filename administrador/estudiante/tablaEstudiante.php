<?php
session_start();
error_reporting(0);

$validar = $_SESSION['usuario'];

if ($validar == null || $validar == '') {
    header("Location: ../../formularioIniciosesion.html");
    die();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla Estudiantes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://kit.fontawesome.com/5ef4b61a8f.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="../../css/tabla.css">
    <link rel="stylesheet" href="../css/estilo.css">
  <link rel="stylesheet" href="../css/estilobody.css">
  <link rel="stylesheet" href="../css/footer.css">
</head>

<body>
    
    <h2 class="text-center p-4">Tabla de Estudiantes</h2>

    <div class="containerTabla">

        <form action="" method="GET" class="d-flex flex-wrap justify-content-between mb-3 align-items-center">
            <div class="col-md-4 mb-2 mb-md-0">
                <a href="../adminUsuario.html" class="btn btn-secondary"><i class="fa-solid fa-circle-left"></i> Volver</a>
            </div>
            <div class="col-md-4 mb-2 mb-md-0">
                <div class="input-group">
                    <input placeholder="Ingrese el dato que desee buscar" name="busqueda" type="search" class="form-control">
                    <button type="submit" name="buscador" class="btn btn-primary">Buscar</button>
                </div>
            </div>
            <div class="col-md-4 text-md-end">
                <a href="formCrearcuentaEstudiante.php" type="button" class="btn btn-success"> <i class="fa-solid fa-plus"></i> Agregar</a>
            </div>
        </form>

        <?php

        include '../../db_Conexion/conector.php';

        $conexion_obj = new Conexion(); // Instanciar un objeto de conexión
        $conn = $conexion_obj->conectar(); // Establecer la conexión a la base de datos

        if (isset($_GET['buscador'])) { // Comprobar si se realizó una búsqueda
            $busqueda = $_GET['busqueda'];
            $busqueda = "%$busqueda%"; // Agregar comodines para la búsqueda parcial

            // Preparar la consulta SQL para buscar en varias columnas
            $consulta = $conn->prepare("SELECT estudiantes.*, centros_regionales.nombre_centro AS nombre_centro FROM estudiantes LEFT JOIN centros_regionales 
            ON estudiantes.id_centroRegional = centros_regionales.id_centroRegional WHERE 
            estudiantes.cedula_estudiante LIKE ? OR 
            estudiantes.nombre LIKE ? OR 
            estudiantes.apellido LIKE ? OR 
            estudiantes.email LIKE ? OR 
            estudiantes.facultad LIKE ? OR 
            estudiantes.carrera LIKE ? OR 
            estudiantes.año LIKE ? OR 
            estudiantes.numero_aula LIKE ? OR 
            centros_regionales.nombre_centro LIKE ?");
            // Enlaza parámetros
            $consulta->bind_param("sssssssss", $busqueda, $busqueda, $busqueda, $busqueda, $busqueda, $busqueda, $busqueda, $busqueda, $busqueda);

            $consulta->execute(); // Ejecutar la consulta preparada
            $result = $consulta->get_result(); // Obtener los resultados de la consulta
        } else {
            // Consulta sin búsqueda
            $result = $conn->query("SELECT estudiantes.*, centros_regionales.nombre_centro AS nombre_centro FROM estudiantes LEFT JOIN centros_regionales ON estudiantes.id_centroRegional = centros_regionales.id_centroRegional");
        }
        ?>
        <div class="row justify-content-center">
            <div class="table-responsive">
                <table class="table">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Cédula</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Apellido</th>
                            <th scope="col">Correo</th>
                            <th scope="col">Facultad</th>
                            <th scope="col">Carrera</th>
                            <th scope="col">Año</th>
                            <th scope="col">Centro Regional</th>
                            <th scope="col">N° Aula</th>
                            <th scope="col">Contraseña</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <?php if ($result->num_rows === 0) : ?>
                            <tr>
                                <td colspan="10" class="text-center" style="color: red; font-size: 20px;">No se encontraron resultados.</td>
                            </tr>
                        <?php else : ?>
                            <?php while ($datos = $result->fetch_object()) : ?>
                                <tr>
                                    <th scope="row"><?php echo $datos->cedula_estudiante; ?></th>
                                    <td><?php echo $datos->nombre; ?></td>
                                    <td><?php echo $datos->apellido; ?></td>
                                    <td><?php echo $datos->email; ?></td>
                                    <td><?php echo $datos->facultad; ?></td>
                                    <td><?php echo $datos->carrera; ?></td>
                                    <td><?php echo $datos->año; ?></td>
                                    <td><?php echo $datos->nombre_centro; ?></td>
                                    <td><?php echo $datos->numero_aula; ?></td>
                                    <td><?php echo $datos->contraseña; ?></td>
                                    <td>
                                        <a href="modificarDatosestudiante.php?cedEst=<?= $datos->cedula_estudiante ?>" class="btn btn-small btn-warning mb-1"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <button onclick="confirmarEliminacion('<?= $datos->cedula_estudiante ?>')" class="btn btn-danger"><i class="fa-solid fa-trash"></i></button>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- JS de Bootstrap (opcional, solo si necesitas funcionalidades como el cierre de las alertas) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Función para mostrar el mensaje de confirmación
        function confirmarEliminacion(cedula) {
            Swal.fire({
                title: '¿Estás seguro/a?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Si el usuario confirma, redirigir al script de eliminación
                    window.location.href = 'eliminarDatosestudiante.php?cedEst=' + cedula;
                }else {
                    // Si hay un error, mostrar un mensaje de error
                    Swal.fire('Error', response.message, 'error');
                }
            });
        }
    </script>
</body>

</html>
