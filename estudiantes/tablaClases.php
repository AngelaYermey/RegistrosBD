<?php
session_start();

$UsuarioEstudiante = $_SESSION['usuario'];

if ($UsuarioEstudiante == null || $UsuarioEstudiante == '') {
    header("Location: ../formularioIniciosesion.html");
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
    <h2 class="text-center p-4 botonInfo">Clases Disponibles</h2>

    <div class="containerTabla">

        <form action="" method="GET" class="d-flex flex-wrap justify-content-between mb-3 align-items-center">
            <div class="container text-center">
                <div class="row">
                    <div class="col">
                        <a href="../sesion/cerrar.php" class="btn btn-secondary"><i class="fa-solid fa-door-open"></i> Salir</a>
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

        $conexion_obj = new Conexion(); // Instanciar un objeto de conexión
        $conn = $conexion_obj->conectar(); // Establecer la conexión a la base de datos

        // Definir el número de resultados por página
        $resultados_por_pagina = 5;

        // Determinar en qué página estamos
        if (isset($_GET['pagina'])) {
            $pagina = $_GET['pagina'];
        } else {
            $pagina = 1;
        }

        // Calcular el OFFSET
        $offset = ($pagina - 1) * $resultados_por_pagina;

        if (isset($_GET['buscador'])) { // Comprobar si se realizó una búsqueda
            $busqueda = $_GET['busqueda'];
            $busqueda = "%$busqueda%"; // Agregar comodines para la búsqueda parcial

            // Preparar la consulta SQL para buscar en varias columnas con LIMIT y OFFSET
            $sql = "SELECT 
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
        LIMIT ? OFFSET ?";
            $consulta = $conn->prepare($sql);
            $consulta->bind_param("ssssssii", $UsuarioEstudiante, $busqueda, $busqueda, $busqueda, $busqueda, $busqueda, $resultados_por_pagina, $offset);

            $consulta->execute(); // Ejecutar la consulta preparada
            $result = $consulta->get_result(); // Obtener los resultados de la consulta
        } else {
            $sql = "SELECT 
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
        LIMIT ? OFFSET ?";
            $consulta = $conn->prepare($sql);
            $consulta->bind_param("sii", $UsuarioEstudiante, $resultados_por_pagina, $offset);

            $consulta->execute(); // Ejecutar la consulta preparada
            $result = $consulta->get_result(); // Obtener los resultados de la consulta
        }

        ?>


        <?php
        // Calcular el número total de resultados
        $total_resultados_sql = "SELECT COUNT(*) FROM clases WHERE numero_aula IN (SELECT numero_aula FROM estudiantes WHERE cedula_estudiante = ?)";
        $total_resultados_consulta = $conn->prepare($total_resultados_sql);
        $total_resultados_consulta->bind_param("s", $UsuarioEstudiante);
        $total_resultados_consulta->execute();
        $total_resultados_consulta->bind_result($total_resultados);
        $total_resultados_consulta->fetch();
        $total_resultados_consulta->close();

        // Calcular el número total de páginas
        $total_paginas = ceil($total_resultados / $resultados_por_pagina);
        ?>

        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item <?php if ($pagina <= 1) {
                                            echo 'disabled';
                                        } ?>">
                    <a class="page-link" href="<?php if ($pagina <= 1) {
                                                    echo '#';
                                                } else {
                                                    echo "?pagina=" . ($pagina - 1);
                                                } ?>">Anterior</a>
                </li>
                <?php for ($i = 1; $i <= $total_paginas; $i++) : ?>
                    <li class="page-item <?php if ($pagina == $i) {
                                                echo 'active';
                                            } ?>">
                        <a class="page-link" href="?pagina=<?= $i; ?>"><?= $i; ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item <?php if ($pagina >= $total_paginas) {
                                            echo 'disabled';
                                        } ?>">
                    <a class="page-link" href="<?php if ($pagina >= $total_paginas) {
                                                    echo '#';
                                                } else {
                                                    echo "?pagina=" . ($pagina + 1);
                                                } ?>">Siguiente</a>
                </li>
            </ul>
        </nav>



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

    </div>

    <footer class="footer">
        <?php
        include("../menuFooter/footer.html");
        ?>

    </footer>

    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script> -->
    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
</body>

</html>