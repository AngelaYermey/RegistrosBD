window.addEventListener('DOMContentLoaded', () => {
  const fileInput = document.getElementById('file');
  const texts = document.querySelector('.texts');

  fileInput.addEventListener('change', handleFileSelect);

  function handleFileSelect(event) {
    const file = event.target.files[0];

    // Validar el tipo de archivo
    if (file.type !== 'text/plain') {
      Swal.fire({
        title: 'Error',
        text: 'Solo se pueden mostrar archivos .txt',
        icon: 'error',
        didClose: () => {
          // Restablecer el valor del elemento de entrada del archivo
          fileInput.value = '';
          // Limpiar la pantalla
          while (texts.firstChild) {
            texts.removeChild(texts.firstChild);
          }
          // Limpiar las variables si es necesario
          // ...
        }
      });
      return; // Detener la ejecución si el archivo no es .txt
    }

    const reader = new FileReader();

    reader.onload = function (event) {
      const text = event.target.result;
      const p = document.createElement('p');
      p.textContent = text;
      // texts.appendChild(p);
    };

    reader.readAsText(file);
  }

  window.addEventListener('DOMContentLoaded', () => {
    const fileInput = document.getElementById('file');
    const texts = document.querySelector('.texts');

    fileInput.addEventListener('change', handleFileSelect);
  });

});
