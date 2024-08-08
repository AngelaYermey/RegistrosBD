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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://kit.fontawesome.com/5ef4b61a8f.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../css/formModificar.css">
    <title>Modificar</title>
</head>

<?php

include '../../db_Conexion/conector.php';
$conexion_obj = new Conexion();
$conn = $conexion_obj->conectar();

if (isset($_GET["codAula"])) {
    $codAula = $_GET["codAula"];
    $sql = $conn->prepare("SELECT * FROM aula WHERE numero_aula = ?");
    $sql->bind_param("s", $codAula);
    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows > 0) {
        $datos = $result->fetch_object();
    } else {
        echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>No se encontraron los datos</div>";
        echo "<script>setTimeout(function() { window.location.href = 'tablaAsignatura.php'; }, 3000);</script>";
        exit();
    }
} else {
    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Algo salio mal.</div>";
    echo "<script>setTimeout(function() { window.location.href = 'tablaAsignatura.php'; }, 3000);</script>";
    exit();
}
$query = "SELECT id_centroRegional, nombre_centro FROM centros_regionales";
$resultCentros = $conn->query($query);
error_reporting(E_ALL);
?>

<body class="holy-grail">
    <header class="container2">
        <?php
        include("../../menuFooter/encabezadoA.html");
        ?>
    </header>
    <form method="POST" class="custom-form-style">
        <br>
        <h3 class="textcolor">Modificar Aula</h3><br>
        <div class="col-md-12">
            <?php include "actualizarDatosaula.php"; ?>
            <label for="nom" class="form-label">codigo</label>
            <input type="text" id="codigoAula" class="form-control" name="codigoAula" value="<?php echo $datos->numero_aula; ?>" required>
            <!-- Campo oculto para almacenar la cédula antigua por si necesita modificar este campo-->
            <input type="hidden" name="numAntiguo" value="<?php echo $datos->numero_aula; ?>">

        </div>
        <div class="col-12">
            <label for="cr">Centro Regional:</label>
            <select id="cr" name="id_centroRegional" class="form-select" required>
                <option value="">Escoger opción...</option>
                <?php while ($row = $resultCentros->fetch_assoc()) : ?>
                    <option value="<?php echo $row['id_centroRegional']; ?>" <?php echo $datos->id_centroRegional == $row['id_centroRegional'] ? "selected" : ""; ?>><?php echo $row['nombre_centro']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="row p-4 ">
            <div class="col-6">
                <center><button type="submit" class="btn btn-success" name="btnModificar" value="ok">Modificar</button></center>
            </div>
            <div class="col-6">
                <center><a href="tablaAulas.php" name="Cancelar" class="btn btn-secondary">Cancelar</a></center>
            </div>
        </div>

    </form>

    <footer class="footer">
        <?php
        include("../../menuFooter/footerA.html");
        ?>
    </footer>

</body>


</html>