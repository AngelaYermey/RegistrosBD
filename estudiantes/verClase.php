<?php
session_start();

$UsuarioEstudiante = $_SESSION['usuario'];

if ($UsuarioEstudiante == null || $UsuarioEstudiante == '') {
    header("Location: ../formularioIniciosesion.html");
    die();
}

include '../db_Conexion/conector.php';

$conexion_obj = new Conexion(); // Instanciar un objeto de conexión
$conn = $conexion_obj->conectar(); // Establecer la conexión a la base de datos

if (isset($_GET['clase'])) {
    $clase_seleccionada = $_GET['clase'];

    // Consulta para obtener el texto y el tema de la clase seleccionada
    $sql = "SELECT tema_clase, texto_clase FROM clases WHERE codigo_asignatura = ?";
    $consulta = $conn->prepare($sql);
    $consulta->bind_param("s", $clase_seleccionada);

    $consulta->execute(); // Ejecutar la consulta preparada
    $result = $consulta->get_result(); // Obtener los resultados de la consulta
    $clase = $result->fetch_object();
    $tema_clase = $clase->tema_clase;
    $texto_clase = $clase->texto_clase;
} else {
    // Si no se proporciona el parámetro clase, redirigir a la página anterior
    header("Location: tablaClases.php");
    die();
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reconocimiento de Voz en Tiempo Real | Lectura</title>
    <link rel="stylesheet" href="../css/estilo.css">
    <link rel="stylesheet" href="../css/estilobody.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/popup.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script src="https://cdn.rawgit.com/mattdiamond/Recorderjs/08e7abd9/dist/recorder.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tauri&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="/img/iconoRetinanuevo.png" type="image/x-icon">
</head>

<body class="holy-grail">
    <header class="container">
        <div class="box">
            <div class="imgMain">
                <!-- imagen de footer -->
                <img class="imagenMain" src="/img/retinaLogo2.png" alt="">
            </div>

            <button id="goToTranscripcion" title="Volver a Transcripción" class="btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-big-left">
                    <path d="M18 15h-6v4l-7-7 7-7v4h6v6z" />
                </svg>
                <a href="tablaClases.php" class="btn btn-secondary">Volver atrás</a>
                <span class="text">Volver atrás</span>
            </button>

            <select id="language-selector" title="Cambiar idioma">
                <option value="es-MX" class="text"> Español</option>
                <option value="en-US" class="text">Inglés</option>
            </select>

            <button id="readButton" title="Leer Texto" class="btn">

                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-audio-lines">
                    <path d="M2 10v3" />
                    <path d="M6 6v11" />
                    <path d="M10 3v18" />
                    <path d="M14 8v7" />
                    <path d="M18 5v13" />
                    <path d="M22 10v3" />
                </svg>

                <span class="text">Leer Texto</span>
            </button>

            <button id="limpiarPantalla" title="Limpiar Pantalla" class="btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash">
                    <polyline points="3 6 5 6 21 6" />
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2m-2 8v4m0 0h4m-4 0h4" />
                </svg>
                <span class="text">Limpiar Pantalla</span>
            </button>

        </div>
    </header>
    <!-- informacion de la clase segun lo seleccionado -->
    <div class="holy-grail-body">
        <section class="holy-grail-content">
            <div class="container">
                <h2 class="text-center p-4">Tema: <?php echo $tema_clase; ?></h2>
                <div class="text-container">
                    <p><?php echo $texto_clase; ?></p>
                </div>
            </div>
        </section>
    </div>

    <footer class="footer">
        <div class="footer__addr">
            <!-- imagen de footer -->
            <img class="imagen" src="/img/retina.png" alt="">
        </div>

        <ul class="footer__nav">
            <li class="nav__item">
                <h2 class="nav__title">Información</h2>

                <ul class="nav__ul">
                    <li>
                        <a href="#">
                            <p class="info">Sitio web creado por la Universidad Tecnológica de Panamá, está una herramienta
                                web que
                                facilita la
                                inclusión digital. Convierte voz a texto en tiempo real para personas con discapacidad
                                auditiva y lee
                                texto a voz para quienes tienen discapacidad visual, mejorando la accesibilidad y la
                                comunicación.</p>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav__item">
                <h2 class="nav__title">Transcripción en Tiempo Real de Voz a Texto:</h2>

                <ul class="nav__ul">
                    <li>
                        <a href="#">
                            <p class="info">
                                <ul>
                                    <li class="info">Facilita la comunicación para personas con discapacidad auditiva.
                                    </li>
                                    <li class="info">Convierte la voz en texto de manera instantánea.</li>
                                </ul>
                            </p>
                        </a>
                    </li>

                    <li>
                        <a href="#">

                        </a>
                    </li>

                </ul>
            </li>

            <li class="nav__item">
                <h2 class="nav__title">Texto a Voz:</h2>

                <ul class="nav__ul">
                    <li>
                        <a href="#">
                            <p class="info">
                                <ul>
                                    <li class="info">Mejora la accesibilidad para personas con discapacidad visual.</li>
                                    <li class="info">Lee en voz alta el texto proporcionando una experiencia auditiva.
                                    </li>
                                </ul>
                            </p>
                        </a>
                    </li>

                </ul>
            </li>
        </ul>

        <div class="legal">
            <p class="titulos2">&copy; 2024 Copyright.</p>

        </div>
    </footer>

    <script src="../js/script.js"></script>
    <script src="../js/lectura.js"></script>
    <script src="../js/Controles.js"></script>


    <!-- <script src="/js/database.js"></script>  -->
</body>

</html>