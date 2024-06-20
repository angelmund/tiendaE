document.addEventListener('DOMContentLoaded', function() {
    let menuSubmenus = document.querySelectorAll('.menu__submenu');

    menuSubmenus.forEach(function(menuSubmenu) {
        menuSubmenu.addEventListener('click', function() {
            let submenu = menuSubmenu.querySelector('.submenu');
            if (submenu.style.display === 'none' || submenu.style.display === '') {
                submenu.style.display = 'block';
            } else {
                submenu.style.display = 'none';
            }
        });
    });

    // Función para alternar la visibilidad del navbar
    function toggleNavbar() {
        var navbar = document.querySelector(".nav-bar");
        navbar.classList.toggle("activo");
        var toggleButton = document.querySelector(".abrir__btn");
        toggleButton.classList.toggle("activo");
    }

    // Asignar evento de click al botón de abrir
    document.querySelector(".abrir__btn").addEventListener("click", toggleNavbar);

    // Asignar evento de click al botón de cerrar
    document.querySelector(".cerrar_btn").addEventListener("click", toggleNavbar);
});
