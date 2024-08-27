<?php
session_start();

$UsuarioEstudiante = $_SESSION['usuario'];

if ($UsuarioEstudiante == null || $UsuarioEstudiante == '') {
    header("Location: ../index.php");
    die();
}

// Parámetros de paginación
$limite = 6; // Número de resultados por página
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1; // Página actual
$inicio = ($pagina > 1) ? ($pagina * $limite) - $limite : 0; // Índice de inicio para la consulta

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clases</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="../img/iconoRetinanuevo.png" type="image/x-icon">
    <script src="https://kit.fontawesome.com/5ef4b61a8f.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="../css/tabla.css">

</head>

<body class="holy-grail">
    <header class="container2">
        <?php
        include("../menuFooter/encabezado.html");
        ?>
    </header>
    <div class="holy-grail-body">
        <section class="holy-grail-content">
            <h2 class="text-center p-4 botonInfo">Clases Disponibles</h2>

            <div class="containerTabla">

                <form action="" method="GET" class="d-flex flex-wrap justify-content-between mb-3 align-items-center">
                    <div class="container text-center">
                        <div class="row">
                            <div class="col">
                                <a href="../sesion/cerrar.php" class="btn btn-secondary"><i class="fa-solid fa-door-open"></i> Salir</a>
                            </div>
                            <div class="col">
                                <a href="../estudiantes/lecturaEstu.php" class="btn btn-secondary2"><i class="fa-solid fa-volume-high"></i>Transcribir texto a voz</a>
                            </div>
                            <div class="col">
                                <div class="input-group">
                                    <input placeholder="Buscador" name="busqueda" type="search" class="form-control">
                                    <button type="submit" name="buscador" class="btn btn-primary">Buscar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <?php

                include '../db_Conexion/conector.php';

                $conexion_obj = new Conexion();
                $conn = $conexion_obj->conectar();

                if (isset($_GET['buscador'])) {
                    $busqueda = $_GET['busqueda'];
                    $busqueda = "%$busqueda%";

                    $sql = "SELECT 
                        SQL_CALC_FOUND_ROWS
                        asignaturas.codigo_asignatura, 
                        asignaturas.nombre AS nombre_asignatura,
                        clases.tema_clase, 
                        profesores.nombre AS nombre_profesor,
                        profesores.apellido AS apellido_profesor,
                        clases.fecha
                    FROM 
                        clases 
                    INNER JOIN 
                        asignaturas ON clases.codigo_asignatura = asignaturas.codigo_asignatura 
                    INNER JOIN 
                        profesores ON clases.cedula_prof = profesores.cedula_prof 
                    WHERE 
                        clases.numero_aula IN (
                            SELECT numero_aula FROM estudiantes WHERE cedula_estudiante = ?)
                    AND (
                        asignaturas.codigo_asignatura LIKE ? 
                        OR asignaturas.nombre LIKE ? 
                        OR clases.tema_clase LIKE ? 
                        OR CONCAT(profesores.nombre, ' ', profesores.apellido) LIKE ? 
                        OR clases.fecha LIKE ?
                    )
                    LIMIT ?, ?";
                    $consulta = $conn->prepare($sql);
                    $consulta->bind_param("ssssssii", $UsuarioEstudiante, $busqueda, $busqueda, $busqueda, $busqueda, $busqueda, $inicio, $limite);
                } else {
                    $sql = "SELECT 
                        SQL_CALC_FOUND_ROWS
                        asignaturas.codigo_asignatura, 
                        asignaturas.nombre AS nombre_asignatura,
                        clases.tema_clase, 
                        profesores.nombre AS nombre_profesor,
                        profesores.apellido AS apellido_profesor,
                        clases.fecha
                    FROM 
                        clases 
                    INNER JOIN 
                        asignaturas ON clases.codigo_asignatura = asignaturas.codigo_asignatura 
                    INNER JOIN 
                        profesores ON clases.cedula_prof = profesores.cedula_prof 
                    WHERE 
                        clases.numero_aula IN (
                            SELECT numero_aula FROM estudiantes WHERE cedula_estudiante = ?
                        )
                    ORDER BY 
                        clases.fecha DESC
                    LIMIT ?, ?";
                    $consulta = $conn->prepare($sql);
                    $consulta->bind_param("sii", $UsuarioEstudiante, $inicio, $limite);
                }

                $consulta->execute();
                $result = $consulta->get_result();

                // Obtener el número total de resultados
                $total_resultados = $conn->query("SELECT FOUND_ROWS() as total")->fetch_assoc()['total'];

                // Calcular el número total de páginas
                $total_paginas = ceil($total_resultados / $limite);
                ?>

                <div class="row justify-content-center">
                    <div class="table-responsive">
                        <table class="table">
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
                                        <td colspan="10" class="text-center" style="color: red; font-size: 20px;">No se encontraron resultados.</td>
                                    </tr>
                                <?php else : ?>
                                    <?php while ($datos = $result->fetch_object()) : ?>
                                        <tr>
                                            <th scope="row"><?php echo $datos->codigo_asignatura; ?></th>
                                            <td><?php echo $datos->nombre_asignatura; ?></td>
                                            <td><?php echo $datos->tema_clase; ?></td>
                                            <td><?php echo $datos->fecha; ?></td>
                                            <td>
                                                <?php echo $datos->nombre_profesor; ?>
                                                <?php echo $datos->apellido_profesor; ?>
                                            </td>
                                            <td>
                                                <a href="verClase.php?clase=<?= $datos->codigo_asignatura ?>" class="btn btn-success"><i class="fa-solid fa-up-right-from-square"></i> Abrir</a>
                                                <a href="descargarClase.php?clase=<?= $datos->codigo_asignatura ?>" class="btn btn-danger"><i class="fa-solid fa-download"></i> Descargar</a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <br>
                <!-- Paginación -->
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        <?php if ($pagina > 1) : ?>
                            <li class="page-item">
                                <a class="page-link" href="?pagina=<?php echo $pagina - 1; ?>" aria-label="Anterior">
                                    <span aria-hidden="true">&laquo;</span> Anterior
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $total_paginas; $i++) : ?>
                            <li class="page-item <?php echo ($i == $pagina) ? 'active' : ''; ?>">
                                <a class="page-link" href="?pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($pagina < $total_paginas) : ?>
                            <li class="page-item">
                                <a class="page-link" href="?pagina=<?php echo $pagina + 1; ?>" aria-label="Siguiente">
                                    Siguiente <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        </section>
    </div>

    <footer class="footer">
        <?php
        include("../menuFooter/footer.html");
        ?>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>