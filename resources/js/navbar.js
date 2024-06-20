document.addEventListener('DOMContentLoaded', function() {
    // Agregar un event listener al botón de usuario para abrir y cerrar el menú principal (como mencioné en respuestas anteriores).
    const menuButton = document.getElementById('toggleMenu');
    const menu = document.getElementById('menu');
    const toggleButton = document.getElementById('toggleMenu');
    const overlay = document.getElementById('overlay');

    toggleButton.addEventListener('click', function() {
    menu.classList.toggle('active');
    // Añade o elimina la clase 'content-overlay' al contenido de la página
    const content = document.getElementById('content'); // Reemplaza 'content' con el ID de tu contenido
    //content.classList.toggle('content-overlay');
  });

    const proyectosButton = document.getElementById('btn-menu-proyectos');
    const inscripcionesButton = document.getElementById('btn-menu-inscripciones');
    const proyectosSubMenu = document.getElementById('sub-menu-proyecto');
    const inscripcionesSubMenu = document.getElementById('sub-menu-inscripciones');

    proyectosButton.addEventListener('click', function() {
      if (proyectosSubMenu.style.display === 'block') {
        proyectosSubMenu.style.display = 'none'; // Muestra el submenú
      } else {
        proyectosSubMenu.style.display = 'block'; // Muestra el submenú
      }
    });

    inscripcionesButton.addEventListener('click', function() {
      if (inscripcionesSubMenu.style.display === 'block') {
        inscripcionesSubMenu.style.display = 'none'; // Muestra el submenú
      } else {
      inscripcionesSubMenu.style.display = 'block'; // Muestra el submenú
      }
    });

    menuButton.addEventListener('click', function() {
    if (menu.style.left === '0px') {
      menu.style.left = '-41%';
      menuButton.style.left = '10px';
      menuButton.textContent = '☰';
      overlay.style.display = 'none';
    } else {
      menu.style.left = '0px';
      menuButton.style.left = '41%';
      menuButton.textContent = '✕';
      overlay.style.display = 'block';
    }
  });

});