<nav class="sidebar nav flex-column pt-5 white-text txt-sidebar">
    <!--INICIO DROPDOWN HOVER Enlace de Catálogos -->
    <div class="dropdown">
        <a href="#" class="nav-link text-center fw-bold p-3 txt-sidebar " id="dropdownCatalogos" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <strong>Catálogos</strong>
        </a>
        <ul class="dropdown-menu " aria-labelledby="dropdownCatalogos" style="width: 288px; background: #58ac89;  border-bottom: none !important;">
            <li class="nav-item"><a class="dropdown-item text-center txt-sidebarl" href="{{ url('/catalogos/clientes') }}">Clientes</a></li>
            <li class="nav-item"><a class="dropdown-item text-center txt-sidebarl" href="{{ url('/catalogos/vuelos') }}">Vuelos</a></li>
            <li class="nav-item"><a class="dropdown-item text-center txt-sidebarl" href="{{ url('/catalogos/hoteles') }}">Hoteles</a></li>
            <li class="nav-item"><a class="dropdown-item text-center txt-sidebarl" href="{{ url('/catalogos/sucursales') }}">Sucursales</a></li>
        </ul>
    </div>
    <!--FIN DE DROPDOWN HOVER-->

    <!-- Botones de Reservaciones y Reportes -->
    <a href="{{ url('/movimientos/reservaciones') }}" class="nav-link">Reservaciones</a>
    <a href="{{ url('/reportes/') }}" class="nav-link">Reportes</a>

    <!-- Botón de Salir -->
    <form action="{{ url('/logout') }}" method="POST">
        @csrf <!-- Agrega el token CSRF para protección contra CSRF -->
        <button type="submit" class="nav-link rounded-lg px-4 py-2 mb-2 bg-red-500 text-white hover:bg-red-600 transition duration-300">Salir</button>
    </form>
</nav>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const dropdownCatalogos = document.getElementById('dropdownCatalogos');
    const dropdownMenu = document.querySelector('.dropdown-menu');
    const navLinks = document.querySelectorAll('.nav-link, .dropdown-item');
    const currentPath = window.location.pathname;

    function removeHighlight() {
        navLinks.forEach(link => {
            link.classList.remove('bg-success', 'text-white');
        });
    }

    function highlightLink(link) {
        link.classList.add('bg-success', 'text-white');
    }

    function checkActiveLink() {
        navLinks.forEach(link => {
            if (link.href === window.location.href) {
                highlightLink(link);
                if (link.classList.contains('dropdown-item')) {
                    highlightLink(dropdownCatalogos);
                }
            }
        });
    }

    dropdownCatalogos.addEventListener('mouseenter', function () {
        dropdownMenu.classList.add('show');
    });

    dropdownCatalogos.addEventListener('mouseleave', function () {
        dropdownMenu.classList.remove('show');
    });

    dropdownMenu.addEventListener('mouseenter', function () {
        dropdownMenu.classList.add('show');
    });

    dropdownMenu.addEventListener('mouseleave', function () {
        dropdownMenu.classList.remove('show');
    });

    navLinks.forEach(link => {
        link.addEventListener('click', function (event) {
            if (!link.getAttribute('data-bs-toggle')) {
                highlightLink(link);
                if (link.closest('.dropdown-item')) {
                    highlightLink(dropdownCatalogos);
                }
            }
        });
    });

    // Inicializa el resaltado de enlaces cuando se carga el DOM
    checkActiveLink();
});
</script>
