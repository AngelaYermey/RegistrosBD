<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/login.css">
    <link rel="stylesheet" href="./css/complelogin.css">
    <link rel="shortcut icon" href="./img/iconoRetinanuevo.png" type="image/x-icon">
    <!-- librearias -->
    <title>ROEH</title>
</head>


<body>
    <div class="contenedor-formulario contenedor">
        <div class="continfo">
            <div class="imagen-formulario">

            </div>
            <div class="social">
                <ul class="wrapper">
                    <li class="icon retina">
                        <span class="tooltip">Retina.com</span>
                        <a href="https://retina.utp.ac.pa/" target="_blank">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-globe">
                                <circle cx="12" cy="12" r="10" />
                                <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20" />
                                <path d="M2 12h20" />
                            </svg>
                        </a>
                    </li>
                    <li class="icon twitter">
                        <span class="tooltip">X</span>
                        <a href="https://x.com/UTPCocle" target="_blank">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-twitter">
                                <path
                                    d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z" />
                            </svg>
                        </a>
                    </li>
                    <li class="icon instagram">
                        <span class="tooltip">Instagram</span>
                        <a href="https://www.instagram.com/utpcocle/" target="_blank">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-instagram">
                                <rect width="20" height="20" x="2" y="2" rx="5" ry="5" />
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z" />
                                <line x1="17.5" x2="17.51" y1="6.5" y2="6.5" />
                            </svg>
                        </a>
                    </li>
                    <li class="icon facebook">
                        <span class="tooltip">Facebook</span>
                        <a href="https://www.facebook.com/utpcocle/" target="_blank">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-facebook">
                                <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z" />
                            </svg>
                        </a>
                    </li>
                    <li class="icon youtubed">
                        <span class="tooltip">Youtubed</span>
                        <a href="https://www.youtube.com/c/centroregionaldecocle" target="_blank">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-youtube">
                                <path
                                    d="M2.5 17a24.12 24.12 0 0 1 0-10 2 2 0 0 1 1.4-1.4 49.56 49.56 0 0 1 16.2 0A2 2 0 0 1 21.5 7a24.12 24.12 0 0 1 0 10 2 2 0 0 1-1.4 1.4 49.55 49.55 0 0 1-16.2 0A2 2 0 0 1 2.5 17" />
                                <path d="m10 15 5-3-5-3z" />
                            </svg>
                        </a>
                    </li>
                    <li class="icon utp">
                        <span class="tooltip">UTP Coclé</span>
                        <a href="https://cc.utp.ac.pa/" target="_blank">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-rss">
                                <path d="M4 11a9 9 0 0 1 9 9" />
                                <path d="M4 4a16 16 0 0 1 16 16" />
                                <circle cx="5" cy="19" r="1" />
                            </svg>
                        </a>
                    </li>
                    <li class="icon team">
                        <span class="tooltip">Equipo desarrollador</span>
                        <a href="./creadores.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-contact">
                                <path d="M17 18a2 2 0 0 0-2-2H9a2 2 0 0 0-2 2" />
                                <rect width="18" height="18" x="3" y="4" rx="2" />
                                <circle cx="12" cy="10" r="2" />
                                <line x1="8" x2="8" y1="2" y2="4" />
                                <line x1="16" x2="16" y1="2" y2="4" />
                            </svg>
                        </a>
                    </li>
                </ul>

            </div>
        </div>


        <form class="formulario" action="inicioSesion.php" method="POST">
            <h2 class="textlogin">Bienvenido</h2>
            <h3 class="textlogin">Inicia sesión con tu cuenta</h3>
            <div class="texto-formulario">
            </div>

            <div class="input">
                <label for="tipo_usuario">Tipo de Usuario:</label>
                <select id="tipo_usuario" name="tipo_usuario" class="form-select" required
                    title="Por favor, escoja una opción.">
                    <option value="">Escoger opción...</option>
                    <option value="administrador">Administrador</option>
                    <option value="profesor">Profesor</option>
                    <option value="estudiante">Estudiante</option>
                </select><br>
            </div>

            <div class="input">
                <label>Cédula</label>
                <input type="text" name="cedula" data-form-id
                    pattern="(\d{1,2}|PE|E|N|\d{1,2}AV|\d{1,2}PI)-\d{1,4}-\d{1,5}" title="Formato: XX-XXXX-XXXXX"
                    required>
            </div>

            <div class="input">
                <label>Contraseña</label>
                <input type="password" name="pass" required>
            </div>
            <br>
            <div class="input">
                <div class="input">
                    <input type="submit" name="iniciar" class="btnCrear_Cuenta" data-form-btn value="Iniciar sesión">
                </div>
            </div>

        </form>


    </div>

</body>

</html>