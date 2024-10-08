<?php
session_start();

$UsuarioEstudiante = $_SESSION['usuario'];

if ($UsuarioEstudiante == null || $UsuarioEstudiante == '') {
    header("Location: ../index.php");
    die();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ROEH | Transcripción de texto a voz</title>
    <link rel="stylesheet" href="../css/estilo.css">
    <link rel="stylesheet" href="../css/estilobody.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/lectura.css">
    <link rel="shortcut icon" href="../img/iconoRetinanuevo.png" type="image/x-icon">
    <!-- librerias -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tauri&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://kit.fontawesome.com/eb496ab1a0.js" crossorigin="anonymous"></script>
</head>

<body class="holy-grail">
    <div class="boxUsuario2">
        <button type="button" id="goToTranscripcion" class="btnUsuario2" onclick="location.href='../estudiantes/tablaClases.php'">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-left">
                <path d="m12 19-7-7 7-7" />
                <path d="M19 12H5" />
            </svg>
            <span class="text">Volver atrás</span>
        </button>


    </div>

    <!-- barra de espacio -->
    <div class="barSpace">

    </div>


    <header class="container">
        <?php
        include("../menuFooter/menuLectura.html");
        ?>

    </header>

    <div class="holy-grail-body">

        <section class="holy-grail-content">
            <!-- espacio donde se realiza la transcripcion -->
            <div class="texts" id="textContent">

            </div>
            <!-- fin de espacio transcripcion -->
        </section>
    </div>

    <footer class="footer">
        <?php
        include("../menuFooter/footer.html");
        ?>

    </footer>

    <script src="../js/script.js"></script>
    <script src="../js/lectura.js"></script>
    <script src="../js/controles.js"></script>

</body>

</html>