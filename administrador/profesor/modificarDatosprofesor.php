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
    <title>ROEH: Modificar</title>
</head>

<?php
include '../../db_Conexion/conector.php'; // incluye el archivo de conexión

// Crear una instancia de la clase Conexion
$conexion_obj = new Conexion();
// Establecer la conexión a la base de datos
$conn = $conexion_obj->conectar();
// Verificar si se ha enviado la cédula 
if (isset($_GET["cedProf"])) {

    $ced = $_GET["cedProf"];

    // Ejecutar la consulta SQL
    $sql = $conn->prepare("SELECT * FROM profesores WHERE cedula_prof = ?");
    $sql->bind_param("s", $ced);
    $sql->execute();

    $result = $sql->get_result();
    // Verificar si se encontraron resultados
    if ($result->num_rows > 0) {
        $datos = $result->fetch_object();
    } else {
?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            No se encontraron datos para la cédula proporcionada.
        </div>
        <script>
            setTimeout(function() {
                window.location.href = 'tablaProfesor.php';
            }, 3000); // Redirigir después de 3 segundos (3000 milisegundos)
        </script>
    <?php
        exit(); // Detener la ejecución si no se encontraron datos
    }
} else {
    ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        No se proporcionó la cédula.
    </div>
    <script>
        setTimeout(function() {
            window.location.href = 'tablaProfesor.php';
        }, 3000); // Redirigir después de 3 segundos (3000 milisegundos)
    </script>
<?php
    exit(); // Detener la ejecución si no se proporcionó la cédula
}
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
                <h2>Modificar Profesor</h2><br>
                <form method="POST" class="custom-form-style">
                    <div class="mb-3"> 
                        <?php include "actualizar_profesor.php"; ?>
                        <label for="nom" class="form-label">Nombre</label>
                        <input type="text" id="nom" class="form-control" name="nom" pattern="[A-Za-zÁáÉéÍíÓóÚúÜüÑñ]+" title="Solo se permiten letras mayúsculas y minúsculas" value="<?php echo $datos->nombre; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="ape" class="form-label">Apellido</label>
                        <input type="text" id="ape" class="form-control" name="ape" pattern="[A-Za-zÁáÉéÍíÓóÚúÜüÑñ]+" title="Solo se permiten letras mayúsculas y minúsculas" value="<?php echo $datos->apellido; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="cedula" class="form-label">Cédula</label>
                        <input type="text" id="cedula" name="nueva_cedula" class="form-control" pattern="(\d{1,2}|PE|E|N|\d{1,2}AV|\d{1,2}PI)-\d{1,4}-\d{1,5}" title="Formato: XX-XXXX-XXXXX" value="<?php echo $datos->cedula_prof; ?>" required>
                        <!-- Campo oculto para almacenar la cédula antigua por si necesita modificar este campo-->
                        <input type="hidden" name="cedAntigua" value="<?php echo $datos->cedula_prof; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="correo" class="form-label">Correo Institucional</label>
                        <input type="email" id="correo" name="correo" class="form-control" title="Formato: @utp.ac.pa " pattern="^[\w.%+-]+@([a-zA-Z0-9-]+\.)*utp\.ac\.pa$" value="<?php echo $datos->email; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="pass" class="form-label">Contraseña</label>
                        <input type="text" id="pass" name="pass" class="form-control" pattern="(?=.*\d)(?=.*[A-Za-z])(?=.*[\W_]).{8,}" value="<?php echo $datos->contraseña; ?>" required>
                    </div>
                    <div class="inputbx2">
                        <div class="row p-4 ">
                            <div class="col-6">
                                <center><button type="submit" class="btn btn-success" name="btn_Modificar" value="ok">Modificar</button></center>
                            </div>
                            <div class="col-6">
                                <center><a href="tablaProfesor.php" name="Cancelar" class="btn btn-secondary">Cancelar</a></center>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </section>

</body>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<footer class="footer">
    <?php
    include("../../menuFooter/footerA.html");
    ?>
</footer>

</html>