<?php
session_start();
error_reporting(0);

$validar = $_SESSION['usuario'];

if ($validar == null || $validar == '') {
    header("Location: ../../index.php");
    die();
}

include '../../db_Conexion/conector.php';

$conexion_obj = new Conexion();
$conn = $conexion_obj->conectar();

$query = "SELECT id_centroRegional, nombre_centro FROM centros_regionales";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/formRegistro.css">
    <link rel="shortcut icon" href="../../img/iconoRetinanuevo.png" type="image/x-icon">
    <title>ROEH</title>
</head>

<body class="holy-grail">
    <header class="container2">
        <?php
        include("../../menuFooter/encabezadoA.html");
        ?>
    </header>

    <section>
        <div class="contentbx">
            <div class="form">
                <h2>Registrar Aulas</h2><br>
                <form autocomplete="off" action="registrosAula.php" method="POST" class="formulario_Crear_Cuenta">
                    <div class="inputbx">
                        <div class="form-floating mb-3">
                            <label for="ape">Codigo o numero del aula</label>
                            <input type="text" id="CodAula" pattern="^[A-Za-z0-9]+$" class="form-control" name="CodAula" data-form-lastname required>
                        </div>

                        <div class="form-floating mb-3">
                            <label for="cr">Centro Regional</label>
                            <select id="cr" name="id_centroRegional" class="form-select" required>
                                <option value="">Escoger opción...</option>
                                <?php while ($row = $result->fetch_assoc()) : ?>
                                    <option value="<?php echo $row['id_centroRegional']; ?>"><?php echo $row['nombre_centro']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                    </div>
                    <div class="inputbx">
                        <button type="submit" class="btn_ingDatos" data-form-btn name="btn_ingDatos">Ingresar Datos</button>
                    </div>
                    <div class="inputbx">
                        <a href="tablaAulas.php" name="volver" class="btnvolver" data-form-btn>Volver Atrás</a>
                    </div>
                </form>

            </div>

        </div>
    </section>

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