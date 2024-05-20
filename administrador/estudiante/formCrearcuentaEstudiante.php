<?php
session_start();
error_reporting(0);

$validar = $_SESSION['usuario'];

if ($validar == null || $validar = '') {
    header("Location: ../../formularioIniciosesion.html");
    die();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/DiseñoCuenta.css">
    <title>Reistro de usuarios</title>
</head>

<body>
    <section>
        <div class="contentbx">
            <div class="form">
                <h2>Registrar usuarios</h2><br>
                <form action="registroEstudiante.php" method="POST" class="formulario_Crear_Cuenta">
                    <div class="inputbx">
                        <div class="form-floating mb-3">
                            <label for="nom">Nombre</label>
                            <input type="text" id="nom" class="form-control" name="nom" data-form-name pattern="[A-Za-zÁáÉéÍíÓóÚúÜüÑñ]+" title="Solo se permiten letras mayúsculas y minúsculas" required>
                        </div>

                        <div class="form-floating mb-3">
                            <label for="ape">Apellido</label>
                            <input type="text" id="ape" class="form-control" name="ape" data-form-lastname pattern="[A-Za-zÁáÉéÍíÓóÚúÜüÑñ]+" title="Solo se permiten letras mayúsculas y minúsculas" required>
                        </div>

                        <div class="form-floating mb-3">
                            <label for="cedula">Cédula</label>
                            <input type="text" id="cedula" name="cedula" class="form-control" data-form-id pattern="(\d{1,2}|PE|E|N|\d{1,2}AV|\d{1,2}PI)-\d{1,4}-\d{1,5}" title="Formato: XX-XXXX-XXXXX" required>
                        </div>

                        <div class="form-floating mb-3">
                            <label for="correo">Correo Institucional</label>
                            <input type="email" id="correo" name="correo" class="form-control" title="Formato: @utp.ac.pa " data-form-email pattern="^[\w.%+-]+@([a-zA-Z0-9-]+\.)*utp\.ac\.pa$" required>
                        </div>

                        <div class="form-floating mb-3">
                            <label for="facultad">Facultad</label>
                            <input type="text" id="facultad" name="facultad" title="Por favor, ingrese su facultad."><br>
                        </div>
                        <div class="form-floating mb-3">
                            <label for="carrera">Carrera</label>
                            <input type="text" id="carrera" name="carrera" title="Por favor, ingrese su carrera."><br>
                        </div>

                        <div class="form-floating mb-3">
                            <label for="año">Año:</label>
                            <select id="año" name="cr" class="form-select" required title="Por favor, escoja una opción.">
                                <option value="">Escoger opción...</option>
                                <option value="A1">I</option>
                                <option value="A2">II</option>
                                <option value="A3">III</option>
                                <option value="A4">IV</option>
                                <option value="A5">V</option>                      
                            </select>
                        </div>

                        <div class="form-floating mb-3">
                            <label for="cr">Centro Regional:</label>
                            <select id="cr" name="cr" class="form-select" required title="Por favor, escoja una opción.">
                                <option value="">Escoger opción...</option>
                                <option value="CR1">Centro Regional de Azuero</option>
                                <option value="CR2">Centro Regional de Bocas del Toro</option>
                                <option value="CR3">Centro Regional de Chiriquí</option>
                                <option value="CR4">Centro Regional de Coclé</option>
                                <option value="CR5">Centro Regional de Colón</option>
                                <option value="CR6">Centro Regional de Panamá Oeste</option>
                                <option value="CR7">Centro Regional de Veraguas</option>                        
                            </select>
                        </div>
                        
                        <div class="form-floating mb-3">
                            <label for="pass">Contraseña</label>
                            <input type="password" id="pass" name="pass" class="form-control" data-form-pass required>
                        </div>
                    </div>
                    <div class="inputbx">
                        <button type="submit" class="btnCrear_Cuenta" data-form-btn name="btnCrear">Crear Cuenta</button>
                    </div>
                    <div class="inputbx">
                        <a href="tablaEstudiante.php" name="volver" class="btnvolver" data-form-btn>Volver Atrás</a>
                    </div>

                </form>

            </div>

        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>