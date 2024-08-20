// Efecto de desplazamiento (scroll) para los contenedores
document.addEventListener('scroll', function() {
  const teamMembers = document.querySelectorAll('.team-member');
  
  teamMembers.forEach(member => {
      const rect = member.getBoundingClientRect();
      if (rect.top < window.innerHeight && rect.bottom >= 0) {
          member.classList.add('visible');
      } else {
          member.classList.remove('visible');
      }
  });
});

// Efecto de hover para los contenedores
document.querySelectorAll('.team-member').forEach(member => {
  member.addEventListener('mouseover', () => {
      member.style.transform = 'scale(1.05)';
      member.style.boxShadow = '0 8px 16px rgba(0, 0, 0, 0.2)';
  });
  member.addEventListener('mouseout', () => {
      member.style.transform = 'scale(1)';
      member.style.boxShadow = '0 4px 8px rgba(0, 0, 0, 0.1)';
  });
});

// Efecto de aparición gradual para los contenedores al cargar la página
window.addEventListener('load', () => {
  const teamMembers = document.querySelectorAll('.team-member');
  
  teamMembers.forEach(member => {
      member.classList.add('fade-in');
  });
});
