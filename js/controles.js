

window.addEventListener('DOMContentLoaded', () => {
  const fileInput = document.getElementById('file');
  const texts = document.querySelector('.texts');

  fileInput.addEventListener('change', handleFileSelect);

  function handleFileSelect(event) {
      const file = event.target.files[0];
      const reader = new FileReader();

      reader.onload = function(event) {
          const text = event.target.result;
          const p = document.createElement('p');
          p.textContent = text;
          texts.appendChild(p);
      };

      reader.readAsText(file);
  }
});
