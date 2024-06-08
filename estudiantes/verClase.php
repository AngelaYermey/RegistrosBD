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
    <link rel="stylesheet" href="../css/lectura.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script src="https://cdn.rawgit.com/mattdiamond/Recorderjs/08e7abd9/dist/recorder.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tauri&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="/img/iconoRetinanuevo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="holy-grail">
    <div class="boxUsuario2">
        <button type="button" id="goToTranscripcion" class="btnUsuario2" onclick="location.href='tablaClases.php'">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-left">
                <path d="m12 19-7-7 7-7" />
                <path d="M19 12H5" />
            </svg>
            <span class="text">Volver atrás</span>
        </button>


    </div>
    <header class="container">
        <?php
        include("../menuFooter/menuLectura.html");
        ?>
    </header>
    <!-- informacion de la clase segun lo seleccionado -->
    <div class="holy-grail-body">
        <section class="holy-grail-content">
            <div class="container">
                <h2 class="text-center p-4">Tema: <?php echo $tema_clase; ?></h2>
                <div class="texts">
                    <p><?php echo $texto_clase; ?></p>
                </div>
            </div>
        </section>
    </div>

    <footer class="footer">
        <?php
        include("../menuFooter/footer.html");
        ?>

    </footer>

    <script src="../js/script.js"></script>
    <script src="../js/lectura.js"></script>
    <script src="../js/Controles.js"></script>

</body>

</html>