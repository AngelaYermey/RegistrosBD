window.addEventListener('DOMContentLoaded', () => {
    const fileInput = document.getElementById('file');
    const texts = document.querySelector('.texts');
    const readButton = document.getElementById('readButton');
    const limpiarButton = document.getElementById('limpiarPantalla');
    const goToTranscripcionButton = document.getElementById('goToTranscripcion');
    const languageSelector = document.getElementById('language-selector');
    
    let currentLang = 'es-MX'; // Idioma por defecto
    let voices = [];
    let currentVoice;

    // Cargar las voces disponibles
    function loadVoices() {
        voices = speechSynthesis.getVoices();
        updateVoice();
    }

    // Seleccionar la voz específica para el idioma
    function updateVoice() {
        if (currentLang === 'es-MX') {
            currentVoice = voices.find(voice => voice.voiceURI === 'Microsoft Jorge Online (Natural) - Spanish (Mexico)');
        } else if (currentLang === 'en-US') {
            currentVoice = voices.find(voice => voice.voiceURI === 'Microsoft Jenny Online (Natural) - English (United States)');
        }
    }

    // Cargar las voces cuando estén disponibles
    speechSynthesis.onvoiceschanged = loadVoices;
    loadVoices();

    fileInput.addEventListener('change', handleFileSelect);

    function handleFileSelect(event) {
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onload = function(event) {
            const text = event.target.result;
            const p = document.createElement('p');
            p.textContent = text;
            texts.appendChild(p);
            localStorage.setItem('transcription', text);
        };

        reader.readAsText(file);
    }

    readButton.addEventListener('click', () => {
        const text = texts.innerText;
        const speech = new SpeechSynthesisUtterance(text);
        speech.lang = currentLang; // Utiliza el idioma seleccionado
        speech.voice = currentVoice; // Utiliza la voz específica
        speech.volume = 1;
        speech.rate = 1;
        speech.pitch = 1;
        window.speechSynthesis.speak(speech);
    });

    const storedTranscription = localStorage.getItem('transcription');

    if (storedTranscription) {
        const p = document.createElement('p');
        p.textContent = storedTranscription;
        texts.appendChild(p);
    }

    const observer = new MutationObserver(() => {
        readButton.disabled = texts.innerText.trim() === '';
    });
    observer.observe(texts, { childList: true });

    limpiarButton.addEventListener('click', () => {
        window.speechSynthesis.cancel();
        localStorage.removeItem('transcription');
        texts.innerHTML = '';
        fileInput.value = ''; // Restablecer el valor del input de archivo
        readButton.disabled = true; // Deshabilitar el botón de lectura
    });

    goToTranscripcionButton.addEventListener('click', () => {
        window.speechSynthesis.cancel();
        localStorage.removeItem('transcription');
        texts.innerHTML = '';
        fileInput.value = ''; // Restablecer el valor del input de archivo
        readButton.disabled = true; // Deshabilitar el botón de lectura
    });

    

    // Actualizar la voz cuando cambia el idioma seleccionado
    languageSelector.addEventListener('change', function() {
        currentLang = this.value;
        updateVoice();
    });
});
