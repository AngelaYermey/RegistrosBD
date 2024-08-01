window.addEventListener('DOMContentLoaded', () => {
    const fileInput = document.getElementById('file');
    const texts = document.querySelector('.texts');
    const readButton = document.getElementById('readButton');
    const limpiarButton = document.getElementById('limpiarPantalla');
    const goToTranscripcionButton = document.getElementById('goToTranscripcion');
    const stopButton = document.getElementById('stopButton'); // Nuevo botón de detener

    let voices = [];
    let currentVoice;

    function loadVoices() {
        voices = speechSynthesis.getVoices();
        currentVoice = voices.find(voice => voice.name === 'Microsoft AvaMultilingual Online (Natural) - English (United States)');
        console.log(`Voice loaded: ${currentVoice ? currentVoice.name : 'None'}`);
    }

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
        const speechInstance = new SpeechSynthesisUtterance(text);
        speechInstance.voice = currentVoice;
        speechInstance.volume = 1;
        speechInstance.rate = 1;
        speechInstance.pitch = 1;
        window.speechSynthesis.speak(speechInstance);
    });

    stopButton.addEventListener('click', () => {
        window.speechSynthesis.cancel();
        console.log('Speech synthesis stopped.');
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

    limpiarButton.addEventListener('click', clearScreen);
    goToTranscripcionButton.addEventListener('click', clearScreen);

    function clearScreen() {
        window.speechSynthesis.cancel();
        localStorage.removeItem('transcription');
        texts.innerHTML = '';
        fileInput.value = '';
        readButton.disabled = true;
    }
});
