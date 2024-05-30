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
    <title>Clases</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://kit.fontawesome.com/5ef4b61a8f.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="../css/tabla.css">
</head>

<body>
    <h2 class="text-center p-4">Clases Disponibles</h2>

    <div class="containerTabla">

        <form action="" method="GET" class="d-flex flex-wrap justify-content-between mb-3 align-items-center">
            <div class="col-md-4 mb-2 mb-md-0">
                <a href="../sesion/cerrar.php" class="btn btn-secondary"><i class="fa-solid fa-circle-left"></i>salir</a>
            </div>
            <div class="col-md-4 mb-2 mb-md-0">
                <div class="input-group">
                    <input placeholder="Ingrese el dato que desee buscar" name="busqueda" type="search" class="form-control">
                    <button type="submit" name="buscador" class="btn btn-primary">Buscar</button>
                </div>
            </div>
        </form>

        <?php
        session_start();
        include '../db_Conexion/conector.php';

        $conexion_obj = new Conexion(); // Instanciar un objeto de conexión
        $conn = $conexion_obj->conectar(); // Establecer la conexión a la base de datos
        
        $centroRegional = $_SESSION['centro_regional'];
        if (isset($_GET['buscador'])) { // Comprobar si se realizó una búsqueda
            $busqueda = $_GET['busqueda'];
            $busqueda = "%$busqueda%"; // Agregar comodines para la búsqueda parcial
        
            // Preparar la consulta SQL para buscar en varias columnas
            $sql = "SELECT 
                        asignaturas.codigo_asignatura, 
                        asignaturas.nombre AS nombre_asignatura,
                        clases.texto_clase, 
                        profesores.nombre AS nombre_profesor,
                        clases.fecha
                    FROM 
                        clases 
                    INNER JOIN 
                        asignaturas ON clases.codigo_asignatura = asignaturas.codigo_asignatura 
                    INNER JOIN 
                        profesores ON clases.cedula_prof = profesores.cedula_prof 
                    INNER JOIN 
                        estudiantes ON asignaturas.id_centroRegional = estudiantes.id_centroRegional 
                    WHERE 
                        estudiantes.cedula_estudiante = ? 
                        AND (asignaturas.codigo_asignatura LIKE ? 
                            OR asignaturas.nombre LIKE ? 
                            OR clases.texto_clase LIKE ? 
                            OR profesores.nombre LIKE ? 
                            OR clases.fecha LIKE ?)
                    ORDER BY 
                        clases.fecha DESC";
            $consulta = $conn->prepare($sql);
            $consulta->bind_param("ssssss", $centroRegional, $busqueda, $busqueda, $busqueda, $busqueda, $busqueda);
        
            $consulta->execute(); // Ejecutar la consulta preparada
            $result = $consulta->get_result(); // Obtener los resultados de la consulta
        } else {
            $sql = "SELECT 
                        asignaturas.codigo_asignatura, 
                        asignaturas.nombre AS nombre_asignatura,
                        clases.texto_clase, 
                        profesores.nombre AS nombre_profesor,
                        clases.fecha
                    FROM 
                        clases 
                    INNER JOIN 
                        asignaturas ON clases.codigo_asignatura = asignaturas.codigo_asignatura 
                    INNER JOIN 
                        profesores ON clases.cedula_prof = profesores.cedula_prof 
                    INNER JOIN 
                        estudiantes ON asignaturas.id_centroRegional = estudiantes.id_centroRegional 
                    WHERE 
                        estudiantes.cedula_estudiante = ?
                    ORDER BY 
                        clases.fecha DESC";
            $consulta = $conn->prepare($sql);
            $consulta->bind_param("s", $centroRegional);
        
            $consulta->execute(); // Ejecutar la consulta preparada
            $result = $consulta->get_result(); // Obtener los resultados de la consulta
        }
        

        ?>
        <div class="row justify-content-center">
            <div class="table-responsive">
                <table class="table">
                    <thead class="table-light">
                        <tr>
                        <th scope="col">Código Materia</th>
                            <th scope="col">Nombre Materia</th>
                            <th scope="col">Nombre Clase</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Profesor</th>
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
                                    <th scope="row"><?php echo $datos->codigo_asignatura; ?></th>
                                    <td><?php echo $datos->nombre_asignatura; ?></td>
                                    <td><?php echo $datos->texto_clase; ?></td>
                                    <td><?php echo $datos->fecha; ?></td>
                                    <td><?php echo $datos->nombre_profesor; ?></td>
                                    <td>
                                        <a href="modificarDatosestudiante.php?cedEst=<?= $datos->codigo_asignatura ?>" class="btn btn-small btn-warning mb-1"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <a href="eliminarDatosestudiante.php?cedEst=<?= $datos->codigo_asignatura ?>" class="btn btn-danger"><i class="fa-solid fa-trash"></i></a>
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