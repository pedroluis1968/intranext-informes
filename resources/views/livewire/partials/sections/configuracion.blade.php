{{-- Vista: Panel de Configuración --}}
<div class="config-container py-4">
    <div class="row g-4 mb-5">
        <div class="col-12">
            <div class="d-flex align-items-center mb-2">
                <div class="bg-white bg-opacity-10 p-3 rounded-4 me-3 border border-white border-opacity-10">
                    <i class="bi bi-gear-wide-connected fs-1 text-white"></i>
                </div>
                <div>
                    <h1 class="display-5 fw-bold text-white mb-0">Configuración</h1>
                    <p class="text-white text-opacity-75 mb-0">Gestione las preferencias globales y del sistema</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Tarjeta de Ajustes Generales -->
        <div class="col-md-6 col-lg-4">
            <div class="card bg-white bg-opacity-10 border-white border-opacity-10 h-100 shadow-lg" style="backdrop-filter: blur(10px); border-radius: 24px;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-primary bg-opacity-25 p-2 rounded-3 me-3">
                            <i class="bi bi-sliders text-primary fs-3"></i>
                        </div>
                        <h5 class="card-title fw-bold text-white mb-0">General</h5>
                    </div>
                    <p class="text-white text-opacity-75 mb-4 small">Ajustes básicos del sistema, idioma y visualización predeterminada.</p>
                    <div class="d-grid">
                        <button class="btn btn-outline-light rounded-pill border-opacity-25 py-2 fw-bold small">Administrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tarjeta de Seguridad -->
        <div class="col-md-6 col-lg-4">
            <div class="card bg-white bg-opacity-10 border-white border-opacity-10 h-100 shadow-lg" style="backdrop-filter: blur(10px); border-radius: 24px;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-success bg-opacity-25 p-2 rounded-3 me-3">
                            <i class="bi bi-shield-check text-success fs-3"></i>
                        </div>
                        <h5 class="card-title fw-bold text-white mb-0">Seguridad</h5>
                    </div>
                    <p class="text-white text-opacity-75 mb-4 small">Control de acceso, permisos de usuarios y logs de actividad.</p>
                    <div class="d-grid">
                        <button class="btn btn-outline-light rounded-pill border-opacity-25 py-2 fw-bold small">Gestionar Seguridad</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tarjeta de Notificaciones -->
        <div class="col-md-6 col-lg-4">
            <div class="card bg-white bg-opacity-10 border-white border-opacity-10 h-100 shadow-lg" style="backdrop-filter: blur(10px); border-radius: 24px;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-warning bg-opacity-25 p-2 rounded-3 me-3">
                            <i class="bi bi-bell text-warning fs-3"></i>
                        </div>
                        <h5 class="card-title fw-bold text-white mb-0">Notificaciones</h5>
                    </div>
                    <p class="text-white text-opacity-75 mb-4 small">Configure los canales de alerta y las reglas de envío de correos.</p>
                    <div class="d-grid">
                        <button class="btn btn-outline-light rounded-pill border-opacity-25 py-2 fw-bold small">Configurar Alertas</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tarjeta de Base de Datos / Sistema -->
        <div class="col-md-6 col-lg-4">
            <div class="card bg-white bg-opacity-10 border-white border-opacity-10 h-100 shadow-lg" style="backdrop-filter: blur(10px); border-radius: 24px;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-danger bg-opacity-25 p-2 rounded-3 me-3">
                            <i class="bi bi-database-gear text-danger fs-3"></i>
                        </div>
                        <h5 class="card-title fw-bold text-white mb-0">Mantenimiento</h5>
                    </div>
                    <p class="text-white text-opacity-75 mb-4 small">Respaldos de base de datos, optimización y limpieza de registros temporales.</p>
                    <div class="d-grid">
                        <button class="btn btn-outline-light rounded-pill border-opacity-25 py-2 fw-bold small">Ver Estado</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tarjeta de Integraciones -->
        <div class="col-md-6 col-lg-4">
            <div class="card bg-white bg-opacity-10 border-white border-opacity-10 h-100 shadow-lg" style="backdrop-filter: blur(10px); border-radius: 24px;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-info bg-opacity-25 p-2 rounded-3 me-3">
                            <i class="bi bi-plugin text-info fs-3"></i>
                        </div>
                        <h5 class="card-title fw-bold text-white mb-0">Integraciones</h5>
                    </div>
                    <p class="text-white text-opacity-75 mb-4 small">Conexión con servicios externos, APIs y exportación de datos.</p>
                    <div class="d-grid">
                        <button class="btn btn-outline-light rounded-pill border-opacity-25 py-2 fw-bold small">Configurar APIs</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .config-container {
        animation: fadeInScale 0.6s ease-out forwards;
    }

    @keyframes fadeInScale {
        from {
            opacity: 0;
            transform: scale(0.98) translateY(10px);
        }
        to {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }

    .card {
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        background-color: rgba(255, 255, 255, 0.15) !important;
        border-color: rgba(255, 255, 255, 0.2) !important;
    }

    .btn-outline-light:hover {
        background-color: rgba(255, 255, 255, 0.1);
        color: white;
    }
</style>
