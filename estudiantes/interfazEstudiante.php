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
    </style>
</head>

<body>
    <h2>Clases Disponibles</h2>
    <table>
        <tr>
            <th>Código Materia</th>
            <th>Nombre Materia</th>
            <th>Nombre Clase</th>
            <th>Fecha</th>
            <th>Profesor</th>
            <th>Acciones</th>
        </tr>
        <?php
        // Incluir el archivo del conector
        require_once('../../db_Conexion/conector.php');

        // Crear una instancia de la clase Conexion
        $conexion = new Conexion();

        // Establecer conexión a la base de datos
        $conn = $conexion->conectar();

        // Obtener el centro regional del estudiante (de alguna manera, por ejemplo, a través de una sesión)
        //$id_centroRegional_estudiante = obtener_id_centro_regional_del_estudiante(); // Debes definir esta función
        $_SESSION['centroRegional'] = $id_centroRegional;
        // Consulta SQL para obtener los registros de clases del centro regional del estudiante
        $sql = "SELECT asignaturas.codigo_asignatura, asignaturas.nombre AS nombre_materia, clases.nombre_clase, clases.fecha, profesores.nombre AS nombre_profesor
        FROM clases
        INNER JOIN asignaturas ON clases.codigo_asignatura = asignaturas.codigo_asignatura
        INNER JOIN profesores ON clases.cedula_prof = profesores.cedula_prof
        WHERE asignaturas.id_centroRegional = $id_centroRegional";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Mostrar los datos encontrados en una tabla HTML
            echo "<table>";
            echo "<tr>
            <th>Código Materia</th>
            <th>Nombre Materia</th>
            <th>Tema</th>
            <th>Fecha</th>
            <th>Profesor</th>
            <th>Acciones</th>
          </tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["codigo_asignatura"] . "</td>";
                echo "<td>" . $row["nombre_materia"] . "</td>";
                echo "<td>" . $row["nombre_clase"] . "</td>";
                echo "<td>" . $row["fecha"] . "</td>";
                echo "<td>" . $row["nombre_profesor"] . "</td>";
                echo "<td>";
                echo "<button class='btn btn-view' onclick='verContenido(\"{$row["texto_clase"]}\")'>Ver</button>";
                echo "<a class='btn btn-download' href='descargar.php?clase_id={$row["id"]}'>Descargar</a>";
                echo "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No se encontraron clases para este centro regional.";
        }

        // Cerrar conexión
        $conn->close();
        ?>

    </table>

    <script>
        function verContenido(contenido) {
            // Aquí puedes implementar la lógica para mostrar el contenido en un modal o ventana emergente
            alert("Contenido de la clase:\n" + contenido);
        }
    </script>
</body>

</html>