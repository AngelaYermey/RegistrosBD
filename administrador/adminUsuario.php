<?php
session_start();

$Usuarioprofesor = $_SESSION['usuario'];

if ($Usuarioprofesor == null || $Usuarioprofesor == '') {
    header("Location: ../formularioIniciosesion.html");
    die();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/Diseñocuenta.css">
    <link rel="stylesheet" href="../css/estilo.css">
    <link rel="stylesheet" href="../css/estilobody.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="shortcut icon" href="../img/iconoRetinanuevo.png" type="image/x-icon">
    <title>Administrar usuarios</title>
    <!-- librearias -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
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
    <section>
        <div class="contentbx">
            <div class="form">
                <center>
                    <h2>Administración de Usuarios</h2>
                </center><br>
                <div class="inputbx">
                    <a href="profesor/tablaProfesor.php" class="btn_tabProf" data-form-btn>Ver Registro Profesores</a>
                </div>
                <div class="inputbx">
                    <a href="estudiante/tablaEstudiante.php" class="btn_tabEstud" data-form-btn>Ver Registro Estudiantes</a>
                </div>
                <div class="inputbx">
                    <a href="asignaturas/tablaAsignatura.php" class="btn_tabEstud" data-form-btn>Ver Registro
                        Asignaturas</a>
                </div>
                <div class="inputbx">
                    <a href="aulas/tablaAulas.php" class="btn_tabEstud" data-form-btn>Ver Registro Aulas</a>
                </div>
                <div class="inputbx">
                    <a href="clases/clasesRegistradas.php" class="btn_tabEstud" data-form-btn>Ver Registro Clases</a>
                </div>
                <div class="inputbx">
                    <a href="../sesion/cerrar.php" class="btnsalir" data-form-btn>Salir</a>
                </div>
                </form>
            </div>
        </div>
    </section>
    <footer class="pie-pagina">
        <div class="grupo-1">
            <div class="box">
                <figure>
                    <a href="#">
                        <img src="../img/retina.png" alt="Logo de SLee Dw">
                    </a>
                </figure>
            </div>
            <div class="box">
                <h2>SOBRE NOSOTROS</h2>
                <p class="footerInfo3">ROEH, creada por la Universidad Tecnológica de Panamá, es una plataforma diseñada
                    para apoyar la educación inclusiva de estudiantes con discapacidades auditivas y visuales. Facilita la
                    comunicación al convertir voz a texto en tiempo real para personas con discapacidad auditiva y leer
                    texto en voz alta para personas con discapacidad visual, mejorando así la accesibilidad y la
                    comunicación.</p>
    
            </div>
            <div class="box">
                <h2>SIGUENOS</h2>
                <div class="red-social">
                    <a href="#" class="fa fa-user-tie" target="_blank"></a>
                    <a href="https://www.facebook.com/paginautp" class="fa fa-facebook" target="_blank"></a>
                    <a href="https://retina.utp.ac.pa/" target="_blank" class="fa fa-globe"></a>
                    <a href="https://twitter.com/utppanama" class="fa fa-twitter" target="_blank"></a>
                    <a href="https://www.youtube.com/@UTPPanama507" class="fa fa-youtube" target="_blank"></a>
                </div>
            </div>
        </div>
        <div class="grupo-2">
            <small>&copy; 2024 <b>Retina</b> - Todos los Derechos Reservados.</small>
        </div>
    </footer>
</body>

</html>