<?php

// Verificar si se ha enviado el formulario y si el campo 'correo' está presente
if(isset($_POST['correo'])){
    // Obtener el valor del campo 'correo'
    $correoElectronico = $_POST['correo'];

    // Validar si el correo electrónico no contiene la terminación "@utp.ac.pa"
    if (!preg_match('/@utp\.ac\.pa$/', $correoElectronico)) {
        // Si el correo electrónico no contiene la terminación permitida, mostrar un mensaje de error
        echo "Solo se permiten correos electrónicos con la terminación @utp.ac.pa";
        exit;
    } else {
        // Si el correo electrónico contiene la terminación permitida, procesar el formulario
        // ... (código para procesar el formulario)
    }
} 

?>