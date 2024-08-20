<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reconocimiento de Voz en Tiempo Real | Lectura</title>
    <link rel="stylesheet" href="./css/estilo.css">
    <link rel="stylesheet" href="./css/estilobody.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="./css/Creadores.css">
    <link rel="shortcut icon" href="./img/iconoRetinanuevo.png" type="image/x-icon">
    <!-- librerias -->

</head>

<body class="holy-grail">
    <div class="boxUsuario2">
        <button type="button" id="goToTranscripcion" class="btnUsuario2" onclick="location.href='index.php'">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-left">
                <path d="m12 19-7-7 7-7" />
                <path d="M19 12H5" />
            </svg>
            <span class="text">Volver atrás</span>
        </button>


    </div>
    <header class="container">
        <?php
        include("./menuFooter/encabezadoTeam.html");
        ?>

    </header>

    <div class="holy-grail-body">

        <section class="holy-grail-content">
            <?php
            include("./menuFooter/creators.html");
            ?>
        </section>
    </div>

    <footer class="footer">
        <?php
        include("./menuFooter/footerTeam.html");
        ?>

    </footer>

    <script src="./js/creadores.js"></script>
</body>

</html>