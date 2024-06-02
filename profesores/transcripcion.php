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
  <header class="container">
    <div class="box">
      <div class="imgMain">
        <!-- imagen de footer -->
        <img class="imagenMain" src="../img/retinaLogo2.png" alt="">
      </div>

      <select id="language-selector" title="Cambiar idioma">
        <option value="es-MX" id="text2"> Español</option>
        <option value="en-US" id="text2">Inglés</option>
      </select>

      <button id="startButton" title="Iniciar transcripcion" class="btn">
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-mic">
          <path d="M12 2a3 3 0 0 0-3 3v7a3 3 0 0 0 6 0V5a3 3 0 0 0-3-3Z" />
          <path d="M19 10v2a7 7 0 0 1-14 0v-2" />
          <line x1="12" x2="12" y1="19" y2="22" />
        </svg>
        <span class="text">Iniciar Transcripción</span>
      </button>



      <button id="stopButton" title="detener transcripcion" class="btn">
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-mic-off">
          <line x1="2" x2="22" y1="2" y2="22" />
          <path d="M18.89 13.23A7.12 7.12 0 0 0 19 12v-2" />
          <path d="M5 10v2a7 7 0 0 0 12 5" />
          <path d="M15 9.34V5a3 3 0 0 0-5.68-1.33" />
          <path d="M9 9v3a3 3 0 0 0 5.12 2.12" />
          <line x1="12" x2="12" y1="19" y2="22" />
        </svg>

        <span class="text">Detener Transcripción</span>
      </button>


      <button id="btninfo" title="Manual de uso" class="btn">
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-save-all">
          <path d="M10 2v3a1 1 0 0 0 1 1h5" />
          <path d="M18 18v-6a1 1 0 0 0-1-1h-6a1 1 0 0 0-1 1v6" />
          <path d="M18 22H4a2 2 0 0 1-2-2V6" />
          <path d="M8 18a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9.172a2 2 0 0 1 1.414.586l2.828 2.828A2 2 0 0 1 22 6.828V16a2 2 0 0 1-2.01 2z" />
        </svg>
        <span class="text">Guardar Transcripción</span>
      </button>




      <button id="limpiar" title="Limpiar pantalla" class="btn">
        <svg height="24" width="24" fill="#FFFFFF" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="w-6 h-6">
          <path strokeLinecap="round" strokeLinejoin="round" d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25m18 0A2.25 2.25 0 0 0 18.75 3H5.25A2.25 2.25 0 0 0 3 5.25m18 0V12a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 12V5.25" />
        </svg>
        <span class="text">Limpar pantalla</span>
      </button>

      <button id="descargarFile" title="Descargar texto" class="btn">
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-cloud-download">
          <path d="M4 14.899A7 7 0 1 1 15.71 8h1.79a4.5 4.5 0 0 1 2.5 8.242" />
          <path d="M12 12v9" />
          <path d="m8 17 4 4 4-4" />
        </svg>

        <span class="text">Descargar la nota de texto</span>
      </button>


      <button id="salir" class="btn">
        <a href="../sesion/cerrar.php" class="btn btn-secondary"><span class="text">Salir</span></a>
      </button>



      <button id="goToLectura" title="Ir a lectura" class="btn">
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-speech">
          <path d="M8.8 20v-4.1l1.9.2a2.3 2.3 0 0 0 2.164-2.1V8.3A5.37 5.37 0 0 0 2 8.25c0 2.8.656 3.054 1 4.55a5.77 5.77 0 0 1 .029 2.758L2 20" />
          <path d="M19.8 17.8a7.5 7.5 0 0 0 .003-10.603" />
          <path d="M17 15a3.5 3.5 0 0 0-.025-4.975" />
        </svg>

        <span class="text">Ir a Lectura</span>
      </button>

      <div id="micContainer">
        <svg id="micIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="70" height="70" class="w-12 h-12">
          <path id="micPath" strokeLinecap="round" strokeLinejoin="round" d="M12 18.75a6 6 0 0 0 6-6v-1.5m-6 7.5a6 6 0 0 1-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M12 15.75a3 3 0 0 1-3-3V4.5a3 3 0 1 1 6 0v8.25a3 3 0 0 1-3 3Z" />
        </svg>
        <span id="micStatus" class="text-lg md:text-xl lg:text-2xl">OFF</span>
      </div>
    </div>
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
    <div class="footer__addr">
      <!-- imagen de footer -->
      <img class="imagen" src="./img/retina.png" alt="">
    </div>

    <ul class="footer__nav">
      <li class="nav__item">
        <h2 class="nav__title">Información</h2>

        <ul class="nav__ul">
          <li>
            <a href="#">
              <p class="info">Sitio web creado por la Universidad Tecnológica de Panamá, está es una herramienta
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
                  <li class="info">Facilita la comunicación para personas con discapacidad auditiva.</li>
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
                  <li class="info">Lee en voz alta el texto proporcionando una experiencia auditiva.</li>
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
  <script src="../js/controles.js"></script>
  <!-- <script src="/js/database.js"></script>  -->

</body>

</html>