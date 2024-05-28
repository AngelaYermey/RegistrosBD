<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clases</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        .btn {
            padding: 6px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-view {
            background-color: #4CAF50;
            color: white;
        }

        .btn-download {
            background-color: #008CBA;
            color: white;
        }

        .containerTabla {
            padding: 20px;
        }

        .search-container {
            margin-bottom: 20px;
        }

        .search-container input[type=text] {
            padding: 6px;
            margin-top: 8px;
            font-size: 17px;
            border: none;
            border-bottom: 1px solid #ddd;
        }

        .search-container button {
            padding: 6px 10px;
            margin-top: 8px;
            margin-left: 5px;
            background: #ddd;
            font-size: 17px;
            border: none;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <?php
    session_start();
    error_reporting(0);

    $validar = $_SESSION['usuario'];

    if ($validar == null || $validar == '') {
        header("Location: ../../formularioIniciosesion.html");
        die();
    }
    ?>
    <h2 class="text-center p-4">Clases Disponibles</h2>
    <div class="containerTabla">
        <div class="search-container">
            <form action="" method="GET">
                <input type="text" placeholder="Buscar..." name="busqueda">
                <button type="submit" name="buscador">Buscar</button>
            </form>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Código Materia</th>
                    <th>Nombre Materia</th>
                    <th>Nombre Clase</th>
                    <th>Fecha</th>
                    <th>Profesor</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include '../db_Conexion/conector.php';

                $conexion = new Conexion();
                $conn = $conexion->conectar();

                $centroRegional = $_SESSION['centro_regional'];

                if (isset($_GET['buscador'])) {
                    $busqueda = $_GET['busqueda'];
                    $sql = "SELECT asignaturas.codigo_asignatura, asignaturas.nombre AS nombre_materia, clases.nombre_clase, clases.fecha, profesores.nombre AS nombre_profesor
                            FROM clases
                            INNER JOIN asignaturas ON clases.codigo_asignatura = asignaturas.codigo_asignatura
                            INNER JOIN profesores ON clases.cedula_prof = profesores.cedula_prof
                            INNER JOIN estudiantes ON asignaturas.id_centroRegional = estudiantes.id_centroRegional
                            WHERE estudiantes.cedula_estudiante = '" . $conn->real_escape_string($centroRegional) . "'
                            AND (asignaturas.codigo_asignatura LIKE '%$busqueda%'
                            OR asignaturas.nombre LIKE '%$busqueda%'
                            OR clases.nombre_clase LIKE '%$busqueda%'
                            OR clases.fecha LIKE '%$busqueda%'
                            OR profesores.nombre LIKE '%$busqueda%')";
                } else {
                    $sql = "SELECT asignaturas.codigo_asignatura, asignaturas.nombre AS nombre_materia, clases.nombre_clase, clases.fecha, profesores.nombre AS nombre_profesor
                            FROM clases
                            INNER JOIN asignaturas ON clases.codigo_asignatura = asignaturas.codigo_asignatura
                            INNER JOIN profesores ON clases.cedula_prof = profesores.cedula_prof
                            INNER JOIN estudiantes ON asignaturas.id_centroRegional = estudiantes.id_centroRegional
                            WHERE estudiantes.cedula_estudiante = '" . $conn->real_escape_string($centroRegional) . "'";
                }
                
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
                    while ($datos = $result->fetch_object()) {
                        echo "<tr>";
                        echo "<td>" . $datos->codigo_asignatura . "</td>"; // Cambiado a $datos->codigo_asignatura
                        echo "<td>" . $datos->nombre_materia . "</td>";
                        echo "<td>" . $datos->nombre_clase . "</td>";
                        echo "<td>" . $datos->fecha . "</td>";
                        echo "<td>" . $datos->nombre_profesor . "</td>";
                        echo "<td>";
                        echo "<button class='btn btn-view' onclick='verContenido(\"{$row["texto_clase"]}\")'>Ver</button>";
                        echo "<a class='btn btn-download' href='descargar.php?clase_id={$row["id"]}'>Descargar</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No se encontraron clases para este centro regional.</td></tr>";
                }
                
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <script>
        function verContenido(contenido) {
            alert("Contenido de la clase:\n" + contenido);
        }
    </script>
</body>

</html>
