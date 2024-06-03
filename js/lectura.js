window.addEventListener('DOMContentLoaded', () => {
    const texts = document.querySelector('.texts');
    const readButton = document.getElementById('readButton');
    const limpiarButton = document.getElementById('limpiarPantalla');
    const goToTranscripcionButton = document.getElementById('goToTranscripcion');

    readButton.addEventListener('click', () => {
        const text = texts.innerText;
        const speech = new SpeechSynthesisUtterance(text);
        speech.lang = 'es-MX';
        speech.volume = 1;
        speech.rate = 1;
        speech.pitch = 1;
        window.speechSynthesis.speak(speech);
    });

    const storedTranscription = localStorage.getItem('transcription');

    if (storedTranscription) {
        const p = document.createElement('p'); // Crear un elemento <p>
        p.textContent = storedTranscription; // Asignar el texto de la transcripción al contenido del elemento <p>
        texts.appendChild(p); // Añadir el elemento <p> al contenedor
    }

   

    const observer = new MutationObserver(() => {
        readButton.disabled = texts.innerText.trim() === '';
    });
    observer.observe(texts, { childList: true });

   


    // Agregar evento de clic al botón de limpiar
    limpiarButton.addEventListener('click', () => {
        // Limpiar el contenido en pantalla
        window.speechSynthesis.cancel();
        localStorage.removeItem('transcription');
        texts.innerHTML = '';
    });


    goToTranscripcionButton.addEventListener('click', () => {
        window.location.href = 'index.html';
     
    });
});
