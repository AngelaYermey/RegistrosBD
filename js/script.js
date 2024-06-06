window.addEventListener("DOMContentLoaded", () => {
  const texts = document.querySelector(".texts");
  const startButton = document.getElementById("startButton");
  const stopButton = document.getElementById("stopButton");
  const goToLecturaButton = document.getElementById("goToLectura");
  const limparTexto = document.getElementById("limpiar");
  const descargarTexto = document.getElementById("descargarFile");
  const guardarTranscripcionButton = document.getElementById("btninfo");
  const languageSelector = document.getElementById("language-selector");
  const micIcon = document.getElementById("micIcon");
  const micStatus = document.getElementById("micStatus");

  window.SpeechRecognition =
    window.SpeechRecognition || window.webkitSpeechRecognition;

  const recognition = new SpeechRecognition();
  recognition.interimResults = true;
  recognition.lang = "es-MX";

  let p;
  let isSpeaking = false;

  const startRecognition = () => {
    isSpeaking = true;
    recognition.start();
  };

  const stopRecognition = () => {
    isSpeaking = false;
    recognition.stop();
  };

  startButton.addEventListener("click", startRecognition);
  stopButton.addEventListener("click", stopRecognition);

  languageSelector.addEventListener("change", (e) => {
    recognition.lang = e.target.value;
  });

  recognition.addEventListener("start", () => {
    micIcon.classList.add("active");
    micIcon.classList.add("on");
    micStatus.textContent = "EN LINEA";
  });

  recognition.addEventListener("end", () => {
    micIcon.classList.remove("active");
    micIcon.classList.remove("on");
    micStatus.textContent = "APAGADO";
    if (isSpeaking) {
      recognition.start();
    }
  });

  recognition.addEventListener("result", (e) => {
    if (!p) {
      p = document.createElement("p");
      texts.appendChild(p);
    }

    const text = Array.from(e.results)
      .map((result) => result[0])
      .map((result) => result.transcript)
      .join("");

    p.innerText = text;
    if (e.results[0].isFinal) {
      p = null;
      localStorage.setItem("transcription", texts.innerText); // Guardar transcripción en el almacenamiento local
    }

    texts.scrollTop = texts.scrollHeight; // Autoscroll
  });

  limparTexto.addEventListener("click", () => {
    texts.innerHTML = ""; // Limpiar el contenido del elemento con la clase 'texts'
    stopRecognition();
  });

  descargarTexto.addEventListener("click", () => {
    const contenido = texts.innerText;
    const fechaHora = new Date();
    const opcionesFechaHora = {
      year: "numeric",
      month: "2-digit",
      day: "2-digit",
      hour: "2-digit",
      minute: "2-digit",
      second: "2-digit",
      hour12: true,
      timeZone: "America/Panama",
    };

    const fechaHoraFormato = fechaHora.toLocaleString(
      "es-Panama",
      opcionesFechaHora
    );
    const nombreArchivo = `texto_transcripto_${fechaHoraFormato}.txt`;

    const blob = new Blob([contenido], { type: "text/plain" });
    const url = window.URL.createObjectURL(blob);
    const enlaceDescarga = document.createElement("a");
    enlaceDescarga.href = url;
    enlaceDescarga.download = nombreArchivo;
    document.body.appendChild(enlaceDescarga);
    enlaceDescarga.click();
    document.body.removeChild(enlaceDescarga);
  });

  guardarTranscripcionButton.addEventListener("click", () => {
    Swal.fire({
      title: "Guardar Transcripción",
      html:
        '<input id="codigo" class="swal2-input" placeholder="Codigo de la asignatura">' +
        '<input id="numeroAula" class="swal2-input" placeholder="Codigo o numero del aula">' +
        '<input id="tema" class="swal2-input" placeholder="Tema de la clase">',
      focusConfirm: false,
      preConfirm: () => {
        // Obtener los valores de los campos de entrada
        const codigo = document.getElementById("codigo").value;
        const tema = document.getElementById("tema").value;
        const numeroAula = document.getElementById("numeroAula").value;

        // Obtener la transcripción del almacenamiento local
        const transcripcion = texts.innerText;

        // Validar que se ingresen todos los campos
        if (!codigo || !numeroAula || !tema || !transcripcion) {
          Swal.showValidationMessage("Todos los campos son obligatorios");
          return false;
        }
        return { codigo, numeroAula, tema, transcripcion };
      },
    }).then((result) => {
      if (result.isConfirmed) {
        const data = {
          codigo: result.value.codigo,
          tema: result.value.tema,
          numeroAula: result.value.numeroAula,
          transcripcion: result.value.transcripcion,
        };
        localStorage.setItem("transcriptionData", JSON.stringify(data));

        fetch("../profesores/guardarDatostraduccion.php", {
          method: "POST",
          body: JSON.stringify(data),
          headers: {
            "Content-Type": "application/json",
          },
        })
          .then((response) => response.json()) // Parsear la respuesta como JSON
          .then((data) => {
            if (data.success) {
              // Mostrar mensaje de éxito
              Swal.fire({
                title: "¡Guardado!",
                text: data.message,
                icon: "success",
                showConfirmButton: false,
                timer: 1900,
              });
            } else {
              // Mostrar mensaje de error
              Swal.fire({
                title: "Error",
                text: data.message,
                icon: "error",
                showConfirmButton: false,
                timer: 1900,
              });
            }
          })
      }
    });
  });

  goToLecturaButton.addEventListener("click", () => {
    window.location.href = "lectura.html"; // Redirigir a la interfaz de lectura
  });

  document.getElementById("goToEstudiante").addEventListener("click", () => {
    window.location.href = "estudiante.html";
  });

  recognition.onstart = () => {
    console.log("Comenzó la transcripción.");
  };

  recognition.onend = () => {
    console.log("Finalizó la transcripción.");
    // Reiniciar la transcripción solo si está en curso
    if (isSpeaking) {
      recognition.start();
    }
  };
});
