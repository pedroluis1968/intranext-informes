<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Intranext - Informes</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">

    <link rel="shortcut icon" href="https://acceso2.intranext.es/images/logos/favicon.png">

    <!-- plugin css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://acceso2.intranext.es/assets/fonts/feather-font/css/iconfont.css" rel="stylesheet" />
    <link href="https://acceso2.intranext.es/assets/plugins/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://acceso2.intranext.es/assets/plugins/flatpickr/flatpickr.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- NobleUI / Intranext Custom Styles -->
    <link href="https://acceso2.intranext.es/css/sidebar.css" rel="stylesheet" />
    <link href="https://acceso2.intranext.es/assets/plugins/sweetalert2/sweetalert2.min.css" rel="stylesheet" />

    <style>
        /* Estilos del Panel Lateral Derecho */
        :root {
            --mi-panel-altura-tarjeta: 650px;
            --mi-panel-ancho-contenido: 320px;
            --mi-panel-ancho-iconos: 50px;
        }

        .mi-panel-contenedor {
            position: fixed;
            top: 50%;
            transform: translateY(-50%);
            right: calc(-1 * var(--mi-panel-ancho-contenido));
            width: calc(var(--mi-panel-ancho-contenido) + var(--mi-panel-ancho-iconos));
            height: var(--mi-panel-altura-tarjeta);
            max-height: 90vh;
            z-index: 1045;
            transition: right 0.35s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            pointer-events: none;
        }

        .mi-panel-contenedor.is-open {
            right: 0;
        }

        .mi-panel-iconos {
            position: absolute;
            left: 28px;
            top: 50%;
            transform: translateY(-50%);
            width: 6%;
            display: flex;
            flex-direction: column;
            padding: 8px 0;
            align-items: center;
            pointer-events: auto;
        }

        .mi-panel-icono-trigger {
            color: #ffffff;
            padding: 20px 3px 20px 3px;
            transition: all 0.2s ease;
            cursor: pointer;
            width: 100%;
            text-align: center;
        }

        .mi-panel-icono-trigger:hover {
            background-color: rgba(0, 0, 0, 0.2);
        }

        .mi-panel-icono-trigger.is-active {
            background-color: #4a90e2;
        }

        .mi-panel-contenido {
            margin-left: var(--mi-panel-ancho-iconos);
            width: var(--mi-panel-ancho-contenido);
            height: auto;
            min-height: 25vh;
            background-color: #ffffff;
            box-shadow: -5px 0 15px rgba(0, 0, 0, 0.15);
            display: flex;
            flex-direction: column;
            border-radius: 12px;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            overflow: hidden;
            pointer-events: auto;
        }

        .mi-panel-cuerpo {
            flex-grow: 1;
            padding: 20px;
            overflow-y: auto;
            position: relative;
        }

        .mi-panel-pestaña {
            display: none;
        }

        .mi-panel-pestaña.is-active {
            display: block;
            animation: fadeIn 0.4s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .mi-panel-notificacion-numero {
            position: absolute;
            top: 8px;
            right: 8px;
            min-width: 20px;
            height: 20px;
            background-color: #dc3545;
            color: #ffffff;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            line-height: 20px;
            text-align: center;
            padding: 0 5px;
            border: 2px solid #ffffff;
            z-index: 10;
        }

        /* Estilos Sidebar NobleUI Fixes */
        .sidebar {
            width: 240px;
            background: #042a3c;
            height: 100vh;
            position: fixed;
            transition: all 0.3s;
            display: flex;
            flex-direction: column;
            z-index: 1000;
        }

        .page-wrapper {
            margin-left: 240px;
            width: calc(100% - 240px);
            min-height: 100vh;
            transition: background 0.6s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }

        .bg-escritorio {
            background: linear-gradient(45deg, #e0f2fe 0%, #f0f9ff 100%);
        }

        .bg-expectantes {
            background: linear-gradient(45deg, #fff3e0 0%, #ffb74d 100%);
        }

        .bg-cooperativas {
            background: linear-gradient(45deg, #f9ffcc 0%, #f2ff80 100%);
        }

        .bg-socios {
            background: linear-gradient(45deg, #f0fff4 0%, #dcfce7 100%);
        }

        .bg-contactos {
            background: linear-gradient(45deg, #f5f3ff 0%, #ede9fe 100%);
        }


        .bg-inmuebles {
            background: linear-gradient(45deg, #fff5f5 0%, #f0e4e4 100%);
        }

        .bg-promociones {
            background: linear-gradient(45deg, #fdf2f8 0%, #fce7f3 100%);
        }

        .bg-perfil {
            background: linear-gradient(45deg, #f8f9fa 0%, #e9ecef 100%);
        }

        .bg-configuracion {
            background: linear-gradient(135deg, #042a3c 0%, #063e58 100%);
            color: white;
        }

        .sidebar-header {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .nav-item .nav-link {
            display: flex;
            align-items: center;
            padding: 0.6rem 1.5rem;
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
        }

        .nav-item .nav-link .link-icon {
            width: 20px;
            height: 20px;
            margin-right: 15px;
        }

        .nav-item.active .nav-link {
            color: #fff;
            background: rgba(255, 255, 255, 0.1);
        }

        #nav2 {
            display: flex;
            justify-content: space-around;
            padding: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(0, 0, 0, 0.1);
        }

        .nav2-item p {
            font-size: 0.7rem;
            margin-bottom: 0;
            color: rgba(255, 255, 255, 0.6);
        }

        #headernav {
            padding: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-brand img {
            max-width: 140px;
        }

        /* Mobile specific styles */
        .mobile-toggle {
            display: none;
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 1050;
            background: #042a3c;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 8px 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 991.98px) {
            .mobile-toggle {
                display: block;
            }

            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.mobile-open {
                transform: translateX(0);
            }

            .page-wrapper {
                margin-left: 0;
                width: 100%;
                padding-top: 60px;
                /* Space for the toggle button */
            }
        }
    </style>

    @livewireStyles
</head>

<body>
    <div class="main-wrapper">
        <!-- Mobile Toggle Button -->
        <button class="mobile-toggle" onclick="toggleSidebar()">
            <i class="bi bi-list fs-3"></i>
        </button>

        <!-- Sidebar -->
        <nav class="sidebar" id="mainSidebar">
            <div class="sidebar-header">
                <a href="/" class="sidebar-brand">
                    <img src="/imagenes/logo-axis-gestora_600.png" alt="Logo Axis"
                        style="max-width: 160px; filter: brightness(0) invert(1);">
                </a>
            </div>
            <div class="sidebar-body d-flex flex-column flex-grow-1" style="min-height: 0;">
                <ul class="nav flex-column p-0 mt-4" id="nav1" style="flex-grow: 1; overflow-y: auto;">
                    <!-- Escritorio -->
                    <li class="nav-item active mb-1" id="menu-escritorio">
                        <a href="javascript:void(0)" class="nav-link d-flex align-items-center py-2"
                            onclick="window.Livewire.emit('switchPage', 'escritorio'); markActive('escritorio');">
                            <div class="icon-container rounded-3 d-flex align-items-center justify-content-center me-3"
                                style="width: 45px; height: 45px; background: rgba(0, 209, 224, 0.15);">
                                <i class="bi bi-grid-1x2-fill" style="font-size: 1.6rem; color: #00d1e0;"></i>
                            </div>
                            <span class="link-title fw-bold fs-5">Escritorio</span>
                        </a>
                    </li>
                    <!-- Expectantes -->
                    <li class="nav-item mb-1" id="menu-expectantes">
                        <a href="javascript:void(0)" class="nav-link d-flex align-items-center py-2"
                            onclick="window.Livewire.emit('switchPage', 'expectantes'); markActive('expectantes');">
                            <div class="icon-container rounded-3 d-flex align-items-center justify-content-center me-3"
                                style="width: 45px; height: 45px; background: rgba(255, 152, 0, 0.15);">
                                <i class="bi bi-person-plus-fill" style="font-size: 1.6rem; color: #ff9800;"></i>
                            </div>
                            <span class="link-title fw-bold fs-5">Expectantes</span>
                        </a>
                    </li>
                    <li class="nav-item mb-1" id="menu-cooperativas">
                        <a href="javascript:void(0)" class="nav-link d-flex align-items-center py-2"
                            onclick="window.Livewire.emit('switchPage', 'cooperativas'); markActive('cooperativas');">
                            <div class="icon-container rounded-3 d-flex align-items-center justify-content-center me-3"
                                style="width: 45px; height: 45px; background: rgba(234, 255, 0, 0.2);">
                                <i class="bi bi-building-fill-add" style="font-size: 1.6rem; color: #ccff00;"></i>
                            </div>
                            <span class="link-title fw-bold fs-5">Cooperativas</span>
                        </a>
                    </li>
                    <!-- Promociones -->
                    <li class="nav-item mb-1" id="menu-promociones">
                        <a href="javascript:void(0)" class="nav-link d-flex align-items-center py-2"
                            onclick="window.Livewire.emit('switchPage', 'promociones'); markActive('promociones');">
                            <div class="icon-container rounded-3 d-flex align-items-center justify-content-center me-3"
                                style="width: 45px; height: 45px; background: rgba(255, 0, 255, 0.2);">
                                <i class="bi bi-layers-fill" style="font-size: 1.6rem; color: #ff00ff;"></i>
                            </div>
                            <span class="link-title fw-bold fs-5">Promociones</span>
                        </a>
                    </li>
                    <!-- Inmuebles -->
                    <li class="nav-item mb-1" id="menu-inmuebles">
                        <a href="javascript:void(0)" class="nav-link d-flex align-items-center py-2"
                            onclick="window.Livewire.emit('switchPage', 'inmuebles'); markActive('inmuebles');">
                            <div class="icon-container rounded-3 d-flex align-items-center justify-content-center me-3"
                                style="width: 45px; height: 45px; background: rgba(255, 87, 34, 0.2);">
                                <i class="bi bi-houses-fill" style="font-size: 1.6rem; color: #ff5722;"></i>
                            </div>
                            <span class="link-title fw-bold fs-5">Inmuebles</span>
                        </a>
                    </li>
                    <!-- Socios -->
                    <li class="nav-item mb-1" id="menu-socios">
                        <a href="javascript:void(0)" class="nav-link d-flex align-items-center py-2"
                            onclick="window.Livewire.emit('switchPage', 'socios'); markActive('socios');">
                            <div class="icon-container rounded-3 d-flex align-items-center justify-content-center me-3"
                                style="width: 45px; height: 45px; background: rgba(54, 179, 126, 0.15);">
                                <i class="bi bi-people-fill" style="font-size: 1.6rem; color: #36b37e;"></i>
                            </div>
                            <span class="link-title fw-bold fs-5">Socios</span>
                        </a>
                    </li>
                    <!-- Contactos (Usuarios) -->
                    <li class="nav-item mb-1" id="menu-contactos">
                        <a href="javascript:void(0)" class="nav-link d-flex align-items-center py-2"
                            onclick="window.Livewire.emit('switchPage', 'contactos'); markActive('contactos');">
                            <div class="icon-container rounded-3 d-flex align-items-center justify-content-center me-3"
                                style="width: 45px; height: 45px; background: rgba(101, 84, 192, 0.15);">
                                <i class="bi bi-person-badge-fill" style="font-size: 1.6rem; color: #6554c0;"></i>
                            </div>
                            <span class="link-title fw-bold fs-5">Usuarios</span>
                        </a>
                    </li>
                </ul>


                <div id="headernav"
                    class="mt-auto p-4 border-top border-white border-opacity-10 bg-black bg-opacity-10">
                    <div class="d-flex justify-content-between align-items-center position-relative">
                        <div class="d-flex align-items-center" style="cursor: pointer;"
                            onclick="window.Livewire.emit('switchPage', 'perfil'); markActive('perfil');">
                            <img id="headeravatar" class="rounded-circle"
                                style="width: 45px; height: 45px; border: 2px solid rgba(255,255,255,0.8); object-fit: cover;"
                                src="{{ Auth::user()->avatar ? 'https://axis.intranext.es/storage/' . Auth::user()->avatar : 'https://acceso2.intranext.es/assets/images/avatares/mujer_azul.png' }}"
                                alt="profile">
                            <div class="ms-2">
                                <div class="text-white fw-bold" style="font-size: 0.95rem; line-height: 1.2;">
                                    {{ Auth::user()->nombre }}
                                </div>
                                <small class="text-white-50" style="font-size: 0.75rem;">Ver perfil</small>
                            </div>
                        </div>
                        <div class="d-flex flex-column align-items-center gap-2">
                            <a href="javascript:void(0)" class="text-white text-opacity-75 hover-opacity-100"
                                onclick="window.Livewire.emit('switchPage', 'configuracion'); markActive('configuracion');"
                                title="Configuración">
                                <i class="bi bi-gear-fill" style="font-size: 1.1rem;"></i>
                            </a>
                            <a href="/logout" class="text-white text-opacity-75 hover-opacity-100 logout-btn"
                                data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-delay='{"show":1000, "hide":100}' title="Cerrar Sesión...">
                                <i class="bi bi-box-arrow-right" style="font-size: 1.1rem;"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Wrapper -->
        <div class="page-wrapper bg-escritorio">
            <div class="page-content p-3">
                {{ $slot }}
            </div>
        </div>

        <!-- Right Siding Panel -->
        <div class="mi-panel-contenedor">
            <div class="mi-panel-iconos">
                <a class="mi-panel-icono-trigger" data-target="#pestaña-acciones" title="Acciones Rápidas"
                    style="background-color:rgb(2, 103, 255);">
                    <i class="bi bi-headset h4 mb-0"></i>
                </a>
                <a class="mi-panel-icono-trigger" data-target="#pestaña-accesos" title="Accesos Directos"
                    style="background-color:rgb(34, 123, 255);">
                    <i data-feather="link"></i>
                </a>
                <a class="mi-panel-icono-trigger" data-target="#pestaña-notificaciones" title="Notificaciones"
                    style="background-color:rgb(103, 164, 255);">
                    <span class="mi-panel-notificacion-numero">2</span>
                    <i data-feather="bell"></i>
                </a>
            </div>

            <div class="mi-panel-contenido">
                <div class="mi-panel-cuerpo">
                    <div id="pestaña-acciones" class="mi-panel-pestaña">
                        <h6 class="text-muted mb-3">Acciones Rápidas</h6>
                        <div class="d-grid gap-2">
                            <button class="btn btn-inverse-secondary text-start"><i class="bi bi-journal-plus me-2"></i>
                                Seguimiento</button>
                            <button class="btn btn-inverse-info text-start"><i class="bi bi-calendar-plus me-2"></i>
                                Agenda</button>
                            <button class="btn btn-inverse-success text-start"><i class="bi bi-clipboard-plus me-2"></i>
                                Tarea</button>
                            <button class="btn btn-inverse-warning text-start"><i
                                    class="bi bi-person-lines-fill me-2"></i> Entidad</button>
                        </div>
                    </div>
                    <div id="pestaña-accesos" class="mi-panel-pestaña">
                        <h6 class="text-muted mb-3">Accesos Directos</h6>
                        <p class="text-muted">Próximamente...</p>
                    </div>
                    <div id="pestaña-notificaciones" class="mi-panel-pestaña">
                        <h6 class="text-muted mb-3">Notificaciones</h6>
                        <div class="list-group list-group-flush">
                            <div class="list-group-item d-flex align-items-center py-2">
                                <div
                                    class="wd-30 ht-30 d-flex align-items-center justify-content-center bg-primary rounded-circle me-3">
                                    <i class="icon-sm text-white" data-feather="briefcase"></i>
                                </div>
                                <div>
                                    <p class="mb-0">Nueva modificación tarea</p>
                                    <small class="text-muted">hace 1 mes</small>
                                </div>
                            </div>
                            <div class="list-group-item d-flex align-items-center py-2">
                                <div
                                    class="wd-30 ht-30 d-flex align-items-center justify-content-center bg-info rounded-circle me-3">
                                    <i class="icon-sm text-white" data-feather="info"></i>
                                </div>
                                <div>
                                    <p class="mb-0">Bienvenidos al sistema de Informes</p>
                                    <small class="text-muted">Recién llegado</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://acceso2.intranext.es/assets/plugins/feather-icons/feather.min.js"></script>
    <script src="https://acceso2.intranext.es/assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>

    @livewireScripts

    <script>
        $(document).ready(function () {
            if (typeof feather !== 'undefined') feather.replace();

            $('.mi-panel-icono-trigger').on('click', function (e) {
                e.preventDefault();
                const $this = $(this);
                const target = $this.data('target');
                const $container = $('.mi-panel-contenedor');
                const $panes = $('.mi-panel-pestaña');

                if ($this.hasClass('is-active')) {
                    $container.removeClass('is-open');
                    $this.removeClass('is-active');
                } else {
                    $('.mi-panel-icono-trigger').removeClass('is-active');
                    $panes.removeClass('is-active');
                    $this.addClass('is-active');
                    $(target).addClass('is-active');
                    $container.addClass('is-open');
                    if (typeof feather !== 'undefined') feather.replace();
                }
            });

            $(document).on('click', function (e) {
                if ($('.mi-panel-contenedor').hasClass('is-open') && !$(e.target).closest('.mi-panel-contenedor').length) {
                    $('.mi-panel-contenedor').removeClass('is-open');
                    $('.mi-panel-icono-trigger').removeClass('is-active');
                }
            });

            // Inicializar Tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        });

        function markActive(page) {
            $('#nav1 .nav-item').removeClass('active');
            if (page !== 'perfil' && page !== 'configuracion') {
                $('#menu-' + page).addClass('active');
            }

            // Cambiar fondo dinámicamente
            $('.page-wrapper').removeClass('bg-escritorio bg-expectantes bg-cooperativas bg-socios bg-contactos bg-inmuebles bg-promociones bg-perfil bg-configuracion')
                .addClass('bg-' + page);

            // Cerramos sidebar en mobile si está abierto
            if (window.innerWidth <= 991.98) {
                $('#mainSidebar').removeClass('mobile-open');
            }
        }

        function toggleSidebar() {
            $('#mainSidebar').toggleClass('mobile-open');
        }

        document.addEventListener("DOMContentLoaded", () => {
            window.livewire.on('profileUpdated', () => {
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            });
        });
    </script>
</body>

</html>