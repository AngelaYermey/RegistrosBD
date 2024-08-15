<?php
session_start();

$validar = $_SESSION['usuario'];

if ($validar == null || $validar = '') {
    header("Location: ../../index.php");
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
    <link rel="stylesheet" href="../../css/tabla.css">
    <script src="https://kit.fontawesome.com/5ef4b61a8f.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="../../img/iconoRetinanuevo.png" type="image/x-icon">

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
                <h2 class="titulo">Tabla de Asignaturas</h2>
                <div class="containerTabla">
                    <form action="" method="GET" class="d-flex flex-wrap justify-content-between mb-3 align-items-center">
                        <div class="col-md-4 mb-2 mb-md-0">
                            <a href="../adminUsuario.php" class="btn btn-secondary"><i class="fa-solid fa-circle-left"></i> Volver</a>
                        </div>
                        <div class="col-md-4 mb-2 mb-md-0">
                            <div class="input-group">
                                <input placeholder="Buscador" name="busqueda" type="search" class="form-control">
                                <button type="submit" name="buscar" class="btn btn-primary">Buscar</button>
                            </div>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <a href="FormAsignatura.php" type="button" class="btn btn-success"> <i class="fa-solid fa-plus"></i> Agregar</a>
                        </div>
                    </form>

                    <?php
                    include '../../db_Conexion/conector.php';
                    $conexion_obj = new Conexion(); // Instanciar un objeto de conexión
                    $conn = $conexion_obj->conectar(); // Establecer la conexión a la base de datos

                    $resultados_por_pagina = 6;
                    $total_resultados = $conn->query("SELECT COUNT(*) AS total FROM asignaturas")->fetch_object()->total;
                    $total_paginas = ceil($total_resultados / $resultados_por_pagina);

                    $pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
                    $inicio = ($pagina_actual - 1) * $resultados_por_pagina;

                    if (isset($_GET['buscar'])) {
                        $busqueda = $_GET['busqueda'];
                        $busqueda = "%$busqueda%";
                        $stmt = $conn->prepare("SELECT * FROM asignaturas WHERE codigo_asignatura LIKE ? OR nombre LIKE ? LIMIT ?, ?");
                        $stmt->bind_param("ssii", $busqueda, $busqueda, $inicio, $resultados_por_pagina);
                    } else {
                        $stmt = $conn->prepare("SELECT * FROM asignaturas LIMIT ?, ?");
                        $stmt->bind_param("ii", $inicio, $resultados_por_pagina);
                    }
                    $stmt->execute();
                    $result = $stmt->get_result();
                    ?>
                    <div class="row justify-content-center">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">Codigo</th>
                                        <th scope="col">Nombre</th>
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
                                                <td>
                                                    <a href="modificarAsignatura.php?codAsig=<?= $datos->codigo_asignatura ?>" class="btn btn-small btn-warning mb-1" name="modificar"><i class="fa-solid fa-pen-to-square"></i> Editar</a>
                                                    <button onclick="confirmarEliminacion('<?= $datos->codigo_asignatura ?>')" class="btn btn-danger"><i class="fa-solid fa-trash"></i> Eliminar</button>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            <li class="page-item <?= $pagina_actual <= 1 ? 'disabled' : '' ?>">
                                <a class="page-link" href="?pagina=<?= $pagina_actual - 1 ?>">Previous</a>
                            </li>
                            <?php for ($i = 1; $i <= $total_paginas; $i++) : ?>
                                <li class="page-item <?= $i == $pagina_actual ? 'active' : '' ?>">
                                    <a class="page-link" href="?pagina=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                            <li class="page-item <?= $pagina_actual >= $total_paginas ? 'disabled' : '' ?>">
                                <a class="page-link" href="?pagina=<?= $pagina_actual + 1 ?>">Next</a>
                            </li>
                        </ul>
                    </nav>


                </div>
            </div>
        </section>
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
                    window.location.href = 'eliminarDatosasignatura.php?codigoAsignatura=' + codigo;
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

    <footer class="footer">
        <?php
        include("../../menuFooter/footerA.html");
        ?>
    </footer>
</body>

</html>