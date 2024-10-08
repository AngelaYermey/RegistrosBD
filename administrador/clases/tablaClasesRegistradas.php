<?php
session_start();
error_reporting(0);

$validar = $_SESSION['usuario'];

if ($validar == null || $validar == '') {
    header("Location: ../../index.php");
    die();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clases</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="../../img/iconoRetinanuevo.png" type="image/x-icon">
    <script src="https://kit.fontawesome.com/5ef4b61a8f.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../css/tabla.css">
</head>

<body class="holy-grail">
    <header class="container2">
        <?php
        include("../../menuFooter/encabezadoA.html");
        ?>
    </header>
    <div class="holy-grail-body">
        <section class="holy-grail-content">
            <div class="container">
                <h2 class="titulo">Clases Registradas</h2>
                <div class="containerTabla">
                    <form action="" method="GET" class="d-flex flex-wrap justify-content-between mb-3 align-items-center">
                        <div class="col-md-4 mb-2 mb-md-0">
                            <a href="../adminUsuario.php" class="btn btn-secondary"><i class="fa-solid fa-circle-left"></i> Volver</a>
                        </div>
                        <div class="col-md-4 mb-2 mb-md-0">
                            <div class="input-group">
                                <input placeholder="Buscador" name="busqueda" type="search" class="form-control">
                                <button type="submit" name="buscador" class="btn btn-primary">Buscar</button>
                            </div>
                        </div>
                    </form>
                    <!-- Filtro de fecha -->
                    <div class="row justify-content-center">
                        <div class="col-md-4">
                            <label for="orderFecha"><h4>Ordenar por fecha:</h4></label>
                            <select id="orderFecha" class="form-control">
                                <option value="asc">Más antigua a más reciente</option>
                                <option value="desc">Más reciente a más antigua</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <?php
                    include '../../db_Conexion/conector.php';
                    $conexion_obj = new Conexion(); // Instanciar un objeto de conexión
                    $conn = $conexion_obj->conectar(); // Establecer la conexión a la base de datos

                    // Número de resultados por página
                    $results_per_page = 7;

                    // Determinar el número de página actual
                    if (isset($_GET['page']) && is_numeric($_GET['page'])) {
                        $page = (int) $_GET['page'];
                    } else {
                        $page = 1;
                    }

                    // Calcular el offset para la consulta SQL
                    $offset = ($page - 1) * $results_per_page;

                    // Verifica si se realizó una búsqueda
                    if (isset($_GET['buscador'])) {
                        // Obtener el valor de 'busqueda'
                        $busqueda = $_GET['busqueda'];
                        $busqueda = "%$busqueda%";
                        // Preparar la consulta SQL para buscar en varias columnas
                        $stmt = $conn->prepare("
                        SELECT c.id, c.codigo_asignatura, a.nombre AS nombre_asignatura, c.tema_clase, c.fecha, p.nombre AS nombre_profesor, p.apellido AS apellido_profesor
                        FROM clases c
                        JOIN asignaturas a ON c.codigo_asignatura = a.codigo_asignatura
                        JOIN profesores p ON c.cedula_prof = p.cedula_prof
                        WHERE c.codigo_asignatura LIKE ? OR a.nombre LIKE ? OR p.nombre LIKE ? OR p.apellido LIKE ? OR c.fecha LIKE ?
                        LIMIT ?, ?
                         ");
                        $stmt->bind_param("ssssssi", $busqueda, $busqueda, $busqueda, $busqueda, $busqueda, $offset, $results_per_page);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        // Obtener el número total de resultados
                        $stmt_total = $conn->prepare("
                        SELECT COUNT(*) AS total
                        FROM clases c
                        JOIN asignaturas a ON c.codigo_asignatura = a.codigo_asignatura
                        JOIN profesores p ON c.cedula_prof = p.cedula_prof
                        WHERE c.codigo_asignatura LIKE ? OR a.nombre LIKE ? OR p.nombre LIKE ? OR p.apellido LIKE ? OR c.fecha LIKE ?
                         ");
                        $stmt_total->bind_param("sssss", $busqueda, $busqueda, $busqueda, $busqueda, $busqueda);
                        $stmt_total->execute();
                        $result_total = $stmt_total->get_result();
                        $total_rows = $result_total->fetch_object()->total;
                    } else {
                        $result = $conn->query("
                        SELECT c.id, c.codigo_asignatura, a.nombre AS nombre_asignatura, c.tema_clase, c.fecha, p.nombre AS nombre_profesor, p.apellido AS apellido_profesor
                        FROM clases c
                        JOIN asignaturas a ON c.codigo_asignatura = a.codigo_asignatura
                        JOIN profesores p ON c.cedula_prof = p.cedula_prof
                        LIMIT $offset, $results_per_page
                        ");

                        // Obtener el número total de resultados
                        $result_total = $conn->query("
                        SELECT COUNT(*) AS total
                        FROM clases c
                        JOIN asignaturas a ON c.codigo_asignatura = a.codigo_asignatura
                        JOIN profesores p ON c.cedula_prof = p.cedula_prof
                         ");
                        $total_rows = $result_total->fetch_object()->total;
                    }

                    // Calcular el número total de páginas
                    $total_pages = ceil($total_rows / $results_per_page);
                    ?>

                    <div class="row justify-content-center">
                        <div class="table-responsive">
                            <table class="table" id="clasesTable">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">Código Materia</th>
                                        <th scope="col">Nombre Materia</th>
                                        <th scope="col">Tema de la Clase</th>
                                        <th scope="col">Fecha</th>
                                        <th scope="col">Profesor</th>
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
                                                <td><?php echo $datos->nombre_asignatura; ?></td>
                                                <td><?php echo $datos->tema_clase; ?></td>
                                                <td><?php echo $datos->fecha; ?></td>
                                                <td><?php echo $datos->nombre_profesor . ' ' . $datos->apellido_profesor; ?></td>
                                                <td>
                                                    <a href="eliminarDatosclase.php?id=<?= $datos->id ?>" class="btn btn-danger"><i class="fa-solid fa-trash"></i> Eliminar</a>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <nav aria-label="...">
                        <ul class="pagination">
                            <li class="page-item <?php if ($page <= 1) echo 'disabled'; ?>">
                                <a class="page-link" href="?page=<?php echo $page - 1; ?>">Previous</a>
                            </li>
                            <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                                <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor; ?>
                            <li class="page-item <?php if ($page >= $total_pages) echo 'disabled'; ?>">
                                <a class="page-link" href="?page=<?php echo $page + 1; ?>">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </section>
    </div>

    <footer class="footer">
        <?php include("../../menuFooter/footerA.html"); ?>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="../../js/adminTables.js"></script>
</body>

</html>