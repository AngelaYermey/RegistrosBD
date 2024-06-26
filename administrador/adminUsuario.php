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
    <title>Administrar usuarios</title>
     <!-- librearias -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
     integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
     crossorigin="anonymous" referrerpolicy="no-referrer" />
 <link rel="preconnect" href="https://fonts.googleapis.com" />
 <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
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
    <footer class="footer">
        <footer>
            <section class="top">
                <img class="imgFooter" src="../img/retina.png" />
                <div class="links">
                    <div class="links-column">
                        <h2 style="font-weight: bold;">Información</h2>
                        <a>ROEH es un sitio web creado por la Universidad Tecnológica de Panamá, está es una
                            herramienta
                            web que
                            facilita la
                            inclusión digital. Convierte voz a texto en tiempo real para personas con discapacidad
                            auditiva y lee
                            texto a voz para quienes tienen discapacidad visual, mejorando la accesibilidad y la
                            comunicación.</a>

                    </div>
                    <div class="links-column">
                        <h2 style="font-weight: bold;">Transcripción en Tiempo Real de Voz a Texto:</h2>
                        <a>Facilita la comunicación para personas con discapacidad auditiva.</a>
                        <a>Convierte la voz en texto de manera instantánea.</a>
                        <h2 style="font-weight: bold;">Texto a Voz:</h2>
                        <a>Mejora la accesibilidad para personas con discapacidad visual.</a>
                        <a>Lee en voz alta el texto proporcionando una experiencia auditiva.</a>
                    </div>
                    <div class="links-column socials-column">
                        <h2 style="font-weight: bold;">Sitio de interes</h2>
                        <p>
                            Follow me on social media to get the latest awesome reels and
                            posts.
                        </p>
                        <div class="socials">
                            <a class="" href="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24"
                                    fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-users">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                    <circle cx="9" cy="7" r="4" />
                                    <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                </svg>
                            </a>
                            <a class="fa-brands fa-tiktok"></a>
                            <a class="fa-brands fa-linkedin"></a>
                        </div>
                    </div>
                </div>
            </section>
            <section class="bottom">
                <p class="copyright">© 2024 Todo los derechos reservados</p>
                <div class="legal">
                    <a> Contact </a>
                    <a> Terms </a>
                    <a> Privacy </a>
                </div>
            </section>
        </footer>

    </footer>
</body>

</html>