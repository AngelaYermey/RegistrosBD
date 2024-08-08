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

if (isset($_GET["codAsig"])) {
    $ced = $_GET["codAsig"];
    $sql = $conn->prepare("SELECT * FROM asignaturas WHERE codigo_asignatura = ?");
    $sql->bind_param("s", $ced);
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
    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Algo salió mal.</div>";
    echo "<script>setTimeout(function() { window.location.href = 'tablaAsignatura.php'; }, 3000);</script>";
    exit();
}
?>

<body class="holy-grail">
    <header class="container2">
        <?php
        include("../../menuFooter/encabezadoA.html");
        ?>
    </header>
    <form method="POST" class="custom-form-style">
        <br>
        <h3>Modificar Asignatura</h3><br>
        <?php include "actualizar_asignatura.php"; ?>
        <div class="col-md-12">
            <label for="codigo" class="form-label">Código</label>
            <input type="text" id="codigo" class="form-control" name="codigo" value="<?php echo $datos->codigo_asignatura; ?>" required>
             <!-- Campo oculto para almacenar la codigo antigua por si se modifica este campo-->
             <input type="hidden" name="codAntiguo" value="<?php echo $datos->codigo_asignatura; ?>">
        </div>
        <div class="col-md-12">
            <label for="nom" class="form-label">Nombre</label>
            <input type="text" id="nom" class="form-control" name="nom" value="<?php echo $datos->nombre; ?>" required>
        </div>
        <div class="row p-4 ">
            <div class="col-6">
                <center><button type="submit" class="btn btn-success" name="btnModificar">Modificar</button></center>
            </div>
            <div class="col-6">
                <center><a href="tablaAsignatura.php" name="Cancelar" class="btn btn-secondary">Cancelar</a></center>
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
