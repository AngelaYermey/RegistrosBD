
const btnCrearCuenta = document.querySelector("[data-form-btn]");
const nombre=document.querySelector("[data-form-name]");
const apellido=document.querySelector("[data-form-lastname]");
const cedula=document.querySelector("[data-form-id]");
const correo=document.querySelector("[data-form-email]");
const contrasena=document.querySelector("[data-form-pass]");
btnCrearCuenta.addEventListener("click", (e)=>{
    /* e.preventDefault(); */
    if(nombre.value.length>=3){
        nombre.setCustomValidity("");
        if(apellido.value.length>=3){
            apellido.setCustomValidity("");
            if(contrasena.value.length>=8){
                contrasena.setCustomValidity("");
            }else{
                contrasena.setCustomValidity("La contraseña debe tener al menos 8 caracteres.");
            }
        }else{
            apellido.setCustomValidity("El apellido debe tener al menos 3 caracteres.");
        }
    }else{
        nombre.setCustomValidity("El nombre debe tener al menos 3 caracteres.");
    
    }
    
});

window.onload = function() {
    // Agregamos un event listener al formulario para capturar el evento de envío
    document.getElementById("formulario_Crear_Cuenta").addEventListener("submit", function(event) {
        // Evitamos que el formulario se envíe por defecto
        event.preventDefault();

        // Obtenemos el valor del campo 'correo'
        var correoElectronico = document.getElementById("correo").value;

        // Validamos si el correo electrónico termina con "@utp.ac.pa"
        if (!correoElectronico.endsWith("@utp.ac.pa")) {
            // Si el correo electrónico no termina con "@utp.ac.pa", mostramos un mensaje de error
            document.getElementById("mensajeError").innerText = "Solo se permite el correo institucional @utp.ac.pa";
        } else {
            // Si el correo electrónico es válido, podemos enviar el formulario o realizar otras acciones aquí
            document.getElementById("formulario_Crear_Cuenta").submit();
        }
    });
};
