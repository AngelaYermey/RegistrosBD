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



function mostrarCamposExtra() {
    var tipoUsuario = document.getElementById("tipo_usuario").value;
    var infoExtraEstudiante = document.getElementById("info_extra_estudiante");

    if (tipoUsuario === "estudiantes") {
        infoExtraEstudiante.style.display = "block";
        document.getElementById("facultad").required = true;
        document.getElementById("carrera").required = true;
    } else {
        infoExtraEstudiante.style.display = "none";
        document.getElementById("facultad").required = false;
        document.getElementById("carrera").required = false;
    }
}