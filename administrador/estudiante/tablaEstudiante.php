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
                <h2 class="text-center p-4">Tabla de Estudiantes</h2>

                <div class="containerTabla">

                    <form action="" method="GET" class="d-flex flex-wrap justify-content-between mb-3 align-items-center">
                        <div class="col-md-4 mb-2 mb-md-0">
                            <a href="../adminUsuario.php" class="btn btn-secondary"><i class="fa-solid fa-circle-left"></i> Volver</a>
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

                    $conexion_obj = new Conexion();
                    $conn = $conexion_obj->conectar();

                    $registros_por_pagina = 6; // Número de registros por página
                    $pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
                    $offset = ($pagina_actual - 1) * $registros_por_pagina;

                    if (isset($_GET['buscador'])) {
                        $busqueda = $_GET['busqueda'];
                        $busqueda = "%$busqueda%";

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
                        centros_regionales.nombre_centro LIKE ? LIMIT ?, ?");
                        $consulta->bind_param("ssssssssssi", $busqueda, $busqueda, $busqueda, $busqueda, $busqueda, $busqueda, $busqueda, $busqueda, $busqueda, $offset, $registros_por_pagina);
                    } else {
                        $consulta = $conn->prepare("SELECT estudiantes.*, centros_regionales.nombre_centro AS nombre_centro FROM estudiantes LEFT JOIN centros_regionales 
                        ON estudiantes.id_centroRegional = centros_regionales.id_centroRegional LIMIT ?, ?");
                        $consulta->bind_param("ii", $offset, $registros_por_pagina);
                    }

                    $consulta->execute();
                    $result = $consulta->get_result();

                    // Obtener el número total de registros
                    $total_registros = $conn->query("SELECT COUNT(*) AS total FROM estudiantes")->fetch_object()->total;
                    $total_paginas = ceil($total_registros / $registros_por_pagina);
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
                                            <td colspan="11" class="text-center" style="color: red; font-size: 20px;">No se encontraron resultados.</td>
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

                    <!-- Enlaces de paginación -->
                    <nav aria-label="...">
                        <ul class="pagination justify-content-center">
                            <li class="page-item <?php if ($pagina_actual <= 1) echo 'disabled'; ?>">
                                <a class="page-link" href="?pagina=<?= $pagina_actual - 1; ?>">Previous</a>
                            </li>
                            <?php for ($i = 1; $i <= $total_paginas; $i++) : ?>
                                <li class="page-item <?php if ($i == $pagina_actual) echo 'active'; ?>">
                                    <a class="page-link" href="?pagina=<?= $i; ?>"><?= $i; ?></a>
                                </li>
                            <?php endfor; ?>
                            <li class="page-item <?php if ($pagina_actual >= $total_paginas) echo 'disabled'; ?>">
                                <a class="page-link" href="?pagina=<?= $pagina_actual + 1; ?>">Next</a>
                            </li>
                        </ul>
                    </nav>


                </div>
            </div>
        </section>
    </div>
    <!-- fin de content -->

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
                } else {
                    // Si hay un error, mostrar un mensaje de error
                    Swal.fire('Error', response.message, 'error');
                }
            });
        }
    </script>
    <footer class="footer">
        <?php
        include("../../menuFooter/footerA.html");
        ?>

    </footer>
</body>

</html>