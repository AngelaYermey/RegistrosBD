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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="../../img/iconoRetinanuevo.png" type="image/x-icon">
    <link rel="stylesheet" href="../../css/formModificar.css">
    <title>ROEH: modificar estudiante</title>
</head>

<?php

include '../../db_Conexion/conector.php';
$conexion_obj = new Conexion();
$conn = $conexion_obj->conectar();

if (isset($_GET["cedEst"])) {
    $ced = $_GET["cedEst"];
    $sql = $conn->prepare("SELECT * FROM estudiantes WHERE cedula_estudiante = ?");
    $sql->bind_param("s", $ced);
    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows > 0) {
        $datos = $result->fetch_object();
    } else {
        echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>No se encontraron los datos</div>";
        echo "<script>setTimeout(function() { window.location.href = 'tablaEstudiante.php'; }, 3000);</script>";
        exit();
    }
} else {
    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Algo salio mal.</div>";
    echo "<script>setTimeout(function() { window.location.href = 'tablaEstudiante.php'; }, 3000);</script>";
    exit();
}

// Consulta para obtener los centros regionales
$queryCentros = "SELECT id_centroRegional, nombre_centro FROM centros_regionales";
$resultCentros = $conn->query($queryCentros);

// Consulta para obtener las aulas
$queryAulas = "SELECT numero_aula, id_centroRegional FROM aula";
$resultAulas = $conn->query($queryAulas);
?>


<body class="holy-grail">
    <header class="container2">
        <?php
        include("../../menuFooter/encabezadoA.html");
        ?>
    </header>
    <section>
        <div class="contentbx">
            <div class="form">
                <h2>Modificar Estudiante</h2><br>
                <form method="POST" class="custom-form-style">
                    <div class="mb-3">
                        <?php include "actualizar_estudiante.php"; ?>
                        <label for="nom" class="form-label">Nombre</label>
                        <input type="text" id="nom" class="form-control" name="nom" pattern="[A-Za-zÁáÉéÍíÓóÚúÜüÑñ]+" title="Solo se permiten letras mayúsculas y minúsculas" value="<?php echo $datos->nombre; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="ape" class="form-label">Apellido</label>
                        <input type="text" id="ape" class="form-control" name="ape" pattern="[A-Za-zÁáÉéÍíÓóÚúÜüÑñ]+" title="Solo se permiten letras mayúsculas y minúsculas" value="<?php echo $datos->apellido; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="cedula" class="form-label">Cédula</label>
                        <input type="text" id="cedula" name="nueva_cedula" class="form-control" pattern="(\d{1,2}|PE|E|N|\d{1,2}AV|\d{1,2}PI)-\d{1,4}-\d{1,5}" title="Formato: XX-XXXX-XXXXX" value="<?php echo $datos->cedula_estudiante; ?>" required>
                        <!-- Campo oculto para almacenar la cédula antigua por si necesita modificar este campo-->
                        <input type="hidden" name="cedAntigua" value="<?php echo $datos->cedula_estudiante; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="correo" class="form-label">Correo Institucional</label>
                        <input type="email" id="correo" name="correo" class="form-control" title="Formato: @utp.ac.pa " pattern="^[\w.%+-]+@([a-zA-Z0-9-]+\.)*utp\.ac\.pa$" value="<?php echo $datos->email; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="facultad" class="form-label">Facultad</label>
                        <input type="text" id="facultad" name="facultad" class="form-control" title="Por favor, ingrese su facultad." value="<?php echo $datos->facultad; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="carrera" class="form-label">Carrera</label>
                        <input type="text" id="carrera" name="carrera" class="form-control" title="Por favor, ingrese su carrera." value="<?php echo $datos->carrera; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="año" class="form-label">Año:</label>
                        <input type="text" id="año" name="año" pattern="[1-5]" class="form-control" value="<?php echo $datos->año; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="cr">Centro Regional:</label>
                        <select id="cr" name="id_centroRegional" class="form-select" required>
                            <?php while ($row = $resultCentros->fetch_assoc()) : ?>
                                <option value="<?php echo $row['id_centroRegional']; ?>" <?php echo $datos->id_centroRegional == $row['id_centroRegional'] ? "selected" : ""; ?>>
                                    <?php echo $row['nombre_centro']; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="numAula">Número de Aula:</label>
                        <select id="aula" name="aula" class="form-select" required>
                            <?php while ($row = $resultAulas->fetch_assoc()) : ?>
                                <option value="<?php echo $row['numero_aula']; ?>" <?php echo $datos->numero_aula == $row['numero_aula'] ? "selected" : ""; ?>><?php echo $row['numero_aula']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>         

                    <div class="mb-3">
                        <label for="pass" class="form-label">Contraseña</label>
                        <input type="text" id="pass" name="pass" class="form-control" value="<?php echo $datos->contraseña; ?>" required>
                    </div>
                    <div class="inputbx2">
                        <div class="row p-4 ">
                            <div class="col-6">
                                <center><button type="submit" class="btn btn-success" name="btnModificar" value="ok">Modificar</button></center>
                            </div>
                            <div class="col-6">
                                <center><a href="tablaEstudiante.php" name="Cancelar" class="btn btn-secondary">Cancelar</a></center>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <footer class="footer">
        <?php
        include("../../menuFooter/footerA.html");
        ?>
    </footer>

</body>


</html>