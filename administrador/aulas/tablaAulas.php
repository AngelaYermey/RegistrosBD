<?php
session_start();
error_reporting(0);

$validar = $_SESSION['usuario'];

if ($validar == null || $validar = '') {
    header("Location: ../../formularioIniciosesion.html");
    die();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla Asignaturas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://kit.fontawesome.com/5ef4b61a8f.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="../../css/tabla.css">
</head>

<body>
    <h2 class="text-center p-4">Tabla de Aulas</h2>
    <div class="containerTabla">
        <form action="" method="GET" class="d-flex flex-wrap justify-content-between mb-3 align-items-center">
            <div class="col-md-4 mb-2 mb-md-0">
                <a href="../adminUsuario.html" class="btn btn-secondary"><i class="fa-solid fa-circle-left"></i> Volver</a>
            </div>
            <div class="col-md-4 mb-2 mb-md-0">
                <div class="input-group">
                    <input placeholder="Buscador" name="busqueda" type="search" class="form-control">
                    <button type="submit" name="buscar" class="btn btn-primary">Buscar</button>
                </div>
            </div>
            <div class="col-md-4 text-md-end">
                <a href="formAulas.php" type="button" class="btn btn-success"> <i class="fa-solid fa-plus"></i> Agregar</a>
            </div>
        </form>

        <?php
        include '../../db_Conexion/conector.php';
        $conexion_obj = new Conexion(); // Instanciar un objeto de conexión
        $conn = $conexion_obj->conectar(); // Establecer la conexión a la base de datos
        // Verifica si se realizó una búsqueda
        if (isset($_GET['buscar'])) {
            // Obtener el valor de 'busqueda'
            $busqueda = $_GET['busqueda'];
            // Agregar comodines para la búsqueda parcial
            $busqueda = "%$busqueda%";

            // Preparar la consulta SQL para buscar en varias columnas y obtener el nombre del centro regional
            $stmt = $conn->prepare("SELECT aula.*, centros_regionales.nombre_centro FROM aula INNER JOIN centros_regionales 
            ON aula.id_centroRegional = centros_regionales.id_centroRegional WHERE numero_aula LIKE ? OR 
            centros_regionales.nombre_centro LIKE ?");
            // Asociar parámetros
            $stmt->bind_param("ss", $busqueda, $busqueda);

            $stmt->execute(); // Ejecutar la consulta preparada
            $resultado = $stmt->get_result(); // Obtener los resultados de la consulta

        } else {
            // Consulta por defecto si no hay búsqueda
            $resultado = $conn->query("SELECT aula.*, centros_regionales.nombre_centro FROM aula INNER JOIN centros_regionales ON
            aula.id_centroRegional = centros_regionales.id_centroRegional");
        }

        ?>
        <div class="row justify-content-center">
            <div class="table-responsive">
                <table class="table">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">N° Aula</th>
                            <th scope="col">Centro Regional</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <?php if ($resultado->num_rows === 0) : ?>
                            <tr>
                                <td colspan="6" class="text-center" style="color: red; font-size: 20px;">No se encontraron resultados.</td>
                            </tr>
                        <?php else : ?>
                            <?php while ($datos = $resultado->fetch_object()) : ?>
                                <tr>
                                    <th scope="row"><?php echo $datos->numero_aula; ?></th>
                                    <td><?php echo $datos->nombre_centro; ?></td>
                                    <td>
                                        <a href="modificarAula.php?codAula=<?= $datos->numero_aula ?>" class="btn btn-small btn-warning mb-1" name="modificar"><i class="fa-solid fa-pen-to-square"></i>Editar</a>
                                        <button onclick="confirmarEliminacion('<?= $datos->numero_aula ?>')" class="btn btn-danger"><i class="fa-solid fa-trash"></i> Eliminar</button>
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
        function confirmarEliminacion(codigo) {
            Swal.fire({
                title: '¿Estás seguro/a?',
                text: "¡No podrás revertir esto, algunas clases asociadas pueden eliminarse!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Si el usuario confirma, redirigir al script de eliminación
                    window.location.href = 'eliminarDatosaula.php?codigoAula=' + codigo;
                } else {
                    // Si hay un error, mostrar un mensaje de error
                    Swal.fire('Error', response.message, 'error');
                }
            });
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>