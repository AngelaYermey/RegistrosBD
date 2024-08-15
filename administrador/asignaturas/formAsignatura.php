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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/formRegistro.css">
    <title>Reistro de asignaturas</title>
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
                <h2>Registrar asignaturas</h2><br>
                <form action="registroAsignatura.php" method="POST" class="formulario_Crear_Cuenta" >
                    <div class="inputbx">
                    <div class="form-floating mb-3">
                            <label for="ape">Codigo</label>
                            <input type="text" id="codAsignatura" class="form-control" name="codAsignatura" data-form-lastname  required>                           
                        </div>

                        <div class="form-floating mb-3">
                            <label for="nom">Nombre</label>
                            <input type="text" id="nomAsignatura" class="form-control" name="nomAsignatura" data-form-name required>
                        </div>

                    </div>
                    <div class="inputbx">
                        <button type="submit" class="btn_ingDatos" data-form-btn name="btn_ingDatos">Ingresar Datos</button>
                    </div>   
                    <div class="inputbx">
                        <a href="tablaAsignatura.php" name="volver" class="btnvolver" data-form-btn>Volver Atrás</a>
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