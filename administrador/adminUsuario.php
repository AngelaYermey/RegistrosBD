<?php
session_start();

$Usuarioprofesor = $_SESSION['usuario'];

if ($Usuarioprofesor == null || $Usuarioprofesor == '') {
    header("Location: ../index.php");
    die();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/estilo.css">
    <link rel="stylesheet" href="../css/estilobody.css">
    <link rel="stylesheet" href="../css/adminMenu.css">
    <link rel="shortcut icon" href="../img/iconoRetinanuevo.png" type="image/x-icon">
    <title>ROEH: Administración de usuarios</title>
    <!-- librearias -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <script src="https://kit.fontawesome.com/eb496ab1a0.js" crossorigin="anonymous"></script>
</head>

<body class="holy-grail">
    <header class="container">
        <div class="box">
            <div class="imgMain">
                <!-- imagen de footer -->
                <img class="imagenMain" src="../img/NuevoLogo.png" alt="">
            </div>
        </div>
    </header>
    <br><br>
    <div class="adminBox">
        <section class="contAdmin">
        <h2 class="textAdmin">Administración de Usuarios</h2>
            <div class="contentbx">
                <div class="buttonBox">
                    <a href="profesor/tablaProfesor.php" class="interactiveBtn" data-form-btn>
                        <i class="fas fa-chalkboard-teacher"></i><h3>Ver Registro Profesores</h3>
                    </a>
                </div>
                <div class="buttonBox">
                    <a href="estudiante/tablaEstudiante.php" class="interactiveBtn" data-form-btn>
                        <i class="fas fa-user-graduate"></i><h3>Ver Registro Estudiantes</h3>
                    </a>
                </div>
                <div class="buttonBox">
                    <a href="asignaturas/tablaAsignatura.php" class="interactiveBtn" data-form-btn>
                        <i class="fas fa-book"></i><h3>Ver Registro Asignaturas</h3>
                    </a>
                </div>
                <div class="buttonBox">
                    <a href="aulas/tablaAulas.php" class="interactiveBtn" data-form-btn>
                        <i class="fas fa-school"></i><h3>Ver Registro Aulas</h3>
                    </a>
                </div>
                <div class="buttonBox">
                    <a href="clases/tablaClasesRegistradas.php" class="interactiveBtn" data-form-btn>
                        <i class="fas fa-chalkboard"></i><h3>Ver Registro Clases</h3> 
                    </a>
                </div>
                <div class="buttonBox">
                    <a href="../sesion/cerrar.php" class="interactiveBtn btnLogout" data-form-btn>
                        <i class="fas fa-sign-out-alt"></i><h3>Salir</h3>
                    </a>
                </div>
            </div>
        </section>
    </div>

    <br><br>
    <footer class="footer">
        <?php
        include("../menuFooter/footer.html");
        ?>

    </footer>
    <script src="../js/adminMenu.js"></script>

</body>

</html>