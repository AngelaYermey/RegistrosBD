<?php
session_start();

$Usuarioprofesor = $_SESSION['usuario'];

if ($Usuarioprofesor == null || $Usuarioprofesor == '') {
  header("Location: ../formularioIniciosesion.html");
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
    <link rel="stylesheet" href="../css/lectura.css">
    <link rel="shortcut icon" href="../img/iconoRetinanuevo.png" type="image/x-icon">
    <!-- librerias -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tauri&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="holy-grail">
    <header class="container">
        <?php
        include("../menuFooter/menuLectura.html");
        ?>

    </header>

    <div class="holy-grail-body">

        <section class="holy-grail-content">
            <!-- espacio donde se realiza la transcripcion -->
            <div class="texts">
                
            </div>
            <!-- fin de espacio transcripcion -->
        </section>
    </div>

    <footer class="footer">
        <?php
        include("../menuFooter/footer.html");
        ?>

    </footer>

    <script src="/js/script.js"></script>
    <script src="/js/lectura.js"></script>
    <script src="/js/Controles.js"></script>

</body>

</html>