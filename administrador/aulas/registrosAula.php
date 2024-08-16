<?php
echo '<style>
body {
    font-family: "Quicksand", sans-serif;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;
    margin: 0;
    background-color: #f4f4f9; /* Fondo general */
}

/* Estilo base para las tarjetas de alerta */
.card {
    width: 450px; /* Ancho de la tarjeta */
    padding: 40px;
    border-radius: 12px; /* Bordes redondeados */
    box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1); /* Sombra pronunciada */
    text-align: center;
    position: relative;
    margin-top: 20px; 
}


.card-success {
    background-color: #e7f5ff; /* Fondo azul claro */
    border-left: 6px solid #2358d3; /* Borde izquierdo*/
    color: #2358d3; /* Color del texto */
}

/* Estilo para la tarjeta de error */
.card-danger {
    background-color: #fdecea; /* Fondo rojo claro */
    border-left: 6px solid #d9534f; /* Borde izquierdo grueso */
    color: #d9534f; /* Color del texto */
}

/* Estilo para los mensajes dentro de las tarjetas */
.card-success .success-message,
.card-danger .danger-message {
    font-size: 28px; 
    font-weight: bold; 
    margin-bottom: 25px; 
}

/*iconos en las tarjetas */
.card .icon {
    font-size: 60px; /* tamaño del icono */
    margin-bottom: 20px; 
}

/* Color para el icono de éxito */
.card-success .icon {
    color: #2358d3; /* Azul */
}

/* Color para el icono de error */
.card-danger .icon {
    color: #d9534f; /* Rojo */
}

/* Media query para dispositivos móviles */
@media (max-width: 480px) {
    .card {
        width: 95%; /* Ajuste de ancho para pantallas pequeñas */
        padding: 30px; /* Ajuste del padding */
    }

    .card .icon {
        font-size: 50px; /* Reducción del tamaño del icono  */
    }

    .card-success .success-message,
    .card-danger .danger-message {
        font-size: 24px; /* Ajuste del tamaño del texto  */
    }
}
</style>';

include '../../db_Conexion/conector.php';
session_start();

// Verificar si se ha enviado el formulario
if (isset($_POST['btn_ingDatos'])) {

    // Establecer conexión a la base de datos
    $con = new Conexion();
    $mysqli = $con->conectar();

    // Obtener los datos del formulario
    $aula = $_POST['CodAula'];
    $centro_regional = $_POST['id_centroRegional'];

    // Obtener la cédula del administrador de la sesión
    $admin_cedula = $_SESSION['usuario'];

    // Consultar si el aula ya existe
    $stmt = $mysqli->prepare("SELECT numero_aula FROM aula WHERE numero_aula = ?");
    $stmt->bind_param("s", $aula);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si ya existe el aula
    if ($result->num_rows > 0) {
        echo '<div class="card-danger alert-danger">
        <p class="danger-message">¡Error! Ya existe registrado.</p>
        <i class="fa fa-times"></i>
    </div>';
        echo "<script>
        // Esperar 4 segundos antes de redirigir
        setTimeout(function() {
            // Redirigir a otra página
            window.location.href = 'formAulas.php';
        }, 3300);
    </script>";
        
    } else {
        // Insertar el nuevo aula en la tabla
        $stmt = $mysqli->prepare("INSERT INTO aula (numero_aula, id_centroRegional) VALUES (?, ?)");
        $stmt->bind_param("ss", $aula, $centro_regional);

        if ($stmt->execute()) {
            echo '<div class="card-success alert-simple alert-success">
            <p class="success-message greencross">Registrado correctamente</p>
            <i class="fa fa-times"></i>
        </div>';
                 echo "<script>
            // Esperar 4 segundos antes de redirigir
            setTimeout(function() {
                // Redirigir a otra página
                window.location.href = 'formAulas.php';
            }, 3300);
        </script>";
        } else {
            echo '<div class="card-danger alert-danger">
            <p class="danger-message">¡Error! No se pudo completar el registro.</p>
            <i class="fa fa-times"></i>
        </div>';
            echo "<script>
            // Esperar 4 segundos antes de redirigir
            setTimeout(function() {
                // Redirigir a otra página
                window.location.href = 'formAulas.php';
            }, 3300);
        </script>";
        }
    }

    // Cerrar la conexión
    $stmt->close();
    $mysqli->close();
    
    
}
?>
