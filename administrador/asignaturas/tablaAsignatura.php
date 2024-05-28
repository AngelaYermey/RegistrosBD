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
    <h2 class="text-center p-4">Tabla de Profesores</h2>
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
                <a href="asignaturas.php" type="button" class="btn btn-success"> <i class="fa-solid fa-plus"></i> Agregar</a>
            </div>
        </form>

        <?php
        include '../../db_Conexion/conector.php';
        $conexion_obj = new Conexion(); // Instanciar un objeto de conexión
        $conn = $conexion_obj->conectar(); // Establecer la conexión a la base de datos

        if (isset($_GET['buscar'])) {
            // Comprobar si se realizó una búsqueda
            $busqueda = $_GET['busqueda']; // obtener el valor de 'busqueda'
            $busqueda = "%$busqueda%"; // comodines para la búsqueda parcial

            // Preparar la consulta SQL para buscar en varias columnas y obtener el nombre del centro regional
            $stmt = $conn->prepare("SELECT asignaturas.*, centros_regionales.nombre_centro FROM asignaturas INNER JOIN centros_regionales 
            ON asignaturas.id_centroRegional = centros_regionales.id_centroRegional WHERE codigo_asignatura LIKE ? OR nombre LIKE ? OR 
            centros_regionales.nombre_centro LIKE ?");
            // Asociar parámetros
            $stmt->bind_param("sss", $busqueda, $busqueda, $busqueda);

            $stmt->execute(); // Ejecutar la consulta preparada
            $result = $stmt->get_result(); // Obtener los resultados de la consulta

        } else {
            // Consulta por defecto si no hay búsqueda
            $result = $conn->query("SELECT asignaturas.*, centros_regionales.nombre_centro FROM asignaturas INNER JOIN centros_regionales ON
             asignaturas.id_centroRegional = centros_regionales.id_centroRegional");
            
        }
        ?>
        <div class="row justify-content-center">
            <div class="table-responsive">
                <table class="table">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Codigo</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Centro Regional</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <?php if ($result->num_rows === 0) : ?>
                            <tr>
                                <td colspan="6" class="text-center" style="color: red; font-size: 20px;">No se encontraron resultados.</td>
                            </tr>
                        <?php else : ?>
                            <?php while ($datos = $result->fetch_object()) : ?>
                                <tr>
                                    <th scope="row"><?php echo $datos->codigo_asignatura; ?></th>
                                    <td><?php echo $datos->nombre; ?></td>
                                    <td><?php echo $datos->nombre_centro; ?></td>
                                    <td>
                                        <a href="modificarDatosprofesor.php?cedProf=<?= $datos->codigo_asignatura ?>" class="btn btn-small btn-warning mb-1" name="modificar"><i class="fa-solid fa-pen-to-square"></i>Editar</a>
                                        <a href="eliminarDatosprofesor.php?cedProf=<?= $datos->codigo_asignatura ?>" class="btn btn-danger"><i class="fa-solid fa-trash" name="eliminar"></i> Eliminar</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>