document.querySelectorAll('.interactiveBtn').forEach(button => {
    button.addEventListener('click', () => {
        alert(`Redirigiendo a ${button.textContent.trim()}`);
    });
});