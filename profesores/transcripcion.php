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
  <title>Reconocimiento de Voz en Tiempo Real</title>
  <link rel="stylesheet" href="../css/estilo.css">
  <link rel="stylesheet" href="../css/estilobody.css">
  <link rel="stylesheet" href="../css/footer.css">
  <link rel="stylesheet" href="../css/popup.css">
  <link rel="shortcut icon" href="../img/iconoRetinanuevo.png" type="image/x-icon">
  <!-- librerias -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Tauri&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>


<body class="holy-grail">
  <div class="boxUsuario">

  <button id="salir" title="Salir" class="btnUsuario" onclick="document.querySelector('#salir a').click()">
      <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-log-out">
        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
        <polyline points="16 17 21 12 16 7" />
        <line x1="21" x2="9" y1="12" y2="12" />
      </svg>
      <a href="../sesion/cerrar.php" class="btn btn-secondary" style="display: none;">
        <span class="text">Salir</span>
      </a>
    </button>
  </div>

    

  </div>
  <header class="container">

    <?php
    include("../menuFooter/menu.html");
    ?>

  </header>

  <div class="holy-grail-body">

    <section class="holy-grail-content">
      <!-- espacio donde se realiza la transcripcion -->
      <div class="contenedorText">
        <div class="texts">

        </div>
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
  <script src="../js/controles.js"></script>
</body>

</html>