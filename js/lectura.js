document.addEventListener('DOMContentLoaded', () => {
    const fileUpload = document.getElementById('fileUpload');
    const textContent = document.getElementById('textContent');
    const playButton = document.getElementById('playButton');
    const stopButton = document.getElementById('stopButton');
    const limpiarButton = document.getElementById('limpiarTexto');
    const texts = document.querySelector('.texts');
    const languageSelector = document.querySelectorAll('input[name="language"]');

    let speechSynthesisUtterance;
    let currentLanguage = 'es-ES';
    let textToRead = '';

    


    // Actualizar idioma cuando se selecciona un radio button
    languageSelector.forEach((radio) => {
        radio.addEventListener('change', (e) => {
            currentLanguage = e.target.value;
        });
    });


    // Leer el archivo .txt subido
    fileUpload.addEventListener('change', (e) => {
        const file = e.target.files[0];
        const reader = new FileReader();

        reader.onload = function (event) {
            const text = event.target.result;
            const p = document.createElement('p');
            p.textContent = text;
            textContent.appendChild(p);
            localStorage.setItem('transcription', text); // Guardar el texto en localStorage

            textToRead = text; // Asignar el texto para su posterior lectura en voz alta
        };

        reader.readAsText(file);
    });


    // Leer el contenido generado por PHP
    const phpTextElement = document.querySelector('.texts p');
    if (phpTextElement) {
        textToRead = phpTextElement.textContent;
    }


    // Función para reproducir el texto
    const playText = () => {
        if (speechSynthesisUtterance) {
            speechSynthesis.cancel(); // Cancelar cualquier síntesis en curso
        }
        speechSynthesisUtterance = new SpeechSynthesisUtterance(textToRead);
        speechSynthesisUtterance.lang = currentLanguage;
        speechSynthesis.speak(speechSynthesisUtterance);
    };
    
    // Iniciar la lectura del texto
    playButton.addEventListener('click', playText);

    // Detener la lectura
    stopButton.addEventListener('click', () => {
        window.speechSynthesis.cancel();
        console.log('Speech synthesis stopped.');
    });

    document.getElementById('limpiarTexto').addEventListener('click', () => {
        const texts = document.querySelector('.texts');
        texts.innerHTML = ''; // Limpia el contenido del elemento con la clase 'texts'
    });

});



document.getElementById('goToTranscripcion').addEventListener('click', () => {
    if (window.speechSynthesis) {
        window.speechSynthesis.cancel(); // Cancelar cualquier síntesis de voz en curso
    }
});

