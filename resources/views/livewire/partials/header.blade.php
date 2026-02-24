{{-- Header dinámico según la sección activa --}}
<div class="page-header-custom">
    @if($activePage == 'escritorio')
        <div class="page-header-icon" style="background: rgba(0, 209, 224, 0.15);">
            <i class="bi bi-grid-1x2-fill" style="font-size: 2.2rem; color: #00d1e0;"></i>
        </div>
        <div class="page-header-text">
            <h1>Escritorio Principal</h1>
            <p>Bienvenido de nuevo, {{ Auth::user()->nombre }}. Aquí tienes tu resumen diario.</p>
        </div>
    @elseif($activePage == 'cooperativas')
        <div class="page-header-icon" style="background: rgba(234, 255, 0, 0.2);">
            <i class="bi bi-building-fill-add" style="font-size: 2.2rem; color: #ccff00;"></i>
        </div>
        <div class="page-header-text">
            <h1>Gestión de Cooperativas</h1>
            <p>Administra y visualiza el estado de todas las cooperativas asociadas.</p>
        </div>
    @elseif($activePage == 'expectantes')
        <div class="page-header-icon" style="background: rgba(255, 152, 0, 0.15);">
            <i class="bi bi-person-plus-fill" style="font-size: 2.2rem; color: #ff9800;"></i>
        </div>
        <div class="page-header-text">
            <h1>Socios Expectantes</h1>
            <p>Futuros socios en espera de la constitución de nuevas cooperativas.</p>
        </div>
    @elseif($activePage == 'socios')
        <div class="page-header-icon" style="background: rgba(54, 179, 126, 0.15);">
            <i class="bi bi-people-fill" style="font-size: 2.2rem; color: #36b37e;"></i>
        </div>
        <div class="page-header-text">
            <h1>Panel de Socios</h1>
            <p>Listado completo, aportaciones y estado de los miembros asociados.</p>
        </div>
    @elseif($activePage == 'contactos')
        <div class="d-flex w-100 justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <div class="page-header-icon" style="background: rgba(101, 84, 192, 0.15);">
                    <i class="bi bi-person-badge-fill" style="font-size: 2.2rem; color: #6554c0;"></i>
                </div>
                <div class="page-header-text">
                    <h1>Directorio de Usuarios</h1>
                    <p>Gestión centralizada de usuarios del sistema y sus perfiles.</p>
                </div>
            </div>

            <div class="flex items-center gap-3 ms-auto"
                style="display: flex; align-items: center; gap: 12px; margin-right: 1.5rem;">
                <!-- Botones de Cambio de Vista -->
                <div class="btn-group shadow-sm" role="group" aria-label="Modo de visualización"
                    style="background: rgba(101, 84, 192, 0.1); border-radius: 10px; padding: 4px;">
                    <button type="button" class="btn {{ $userViewMode == 'grid' ? 'btn-primary' : 'btn-white border-0' }}"
                        wire:click="$set('userViewMode', 'grid')" title="Vista de Tarjetas"
                        style="border: none; background: {{ $userViewMode == 'grid' ? '#6554c0' : 'transparent' }}; color: {{ $userViewMode == 'grid' ? 'white' : '#64748b' }}; border-radius: 8px; padding: 6px 14px; display: flex; align-items: center; justify-content: center; box-shadow: {{ $userViewMode == 'grid' ? '0 2px 4px rgba(0,0,0,0.1)' : 'none' }};">
                        <i class="bi bi-grid-fill"></i>
                    </button>
                    <button type="button" class="btn {{ $userViewMode == 'list' ? 'btn-primary' : 'btn-white border-0' }}"
                        wire:click="$set('userViewMode', 'list')" title="Vista de Lista"
                        style="border: none; background: {{ $userViewMode == 'list' ? '#6554c0' : 'transparent' }}; color: {{ $userViewMode == 'list' ? 'white' : '#64748b' }}; border-radius: 8px; padding: 6px 14px; display: flex; align-items: center; justify-content: center; box-shadow: {{ $userViewMode == 'list' ? '0 2px 4px rgba(0,0,0,0.1)' : 'none' }};">
                        <i class="bi bi-list-ul"></i>
                    </button>
                </div>

                <button class="btn font-bold flex items-center gap-2 shadow-sm border-0" wire:click="openUserModal"
                    style="display: flex; align-items: center; gap: 6px; padding: 8px 18px; font-size: 14px; background: linear-gradient(135deg, #6554c0 0%, #4a3e8c 100%); color: white; border-radius: 12px; height: 100%;">
                    <span class="material-symbols-outlined" style="font-size: 1.2rem;">person_add</span>
                    <span class="d-none d-md-inline">Añadir Usuario</span>
                </button>
            </div>
        </div>
    @elseif($activePage == 'promociones')
        <div class="page-header-icon" style="background: rgba(212, 18, 179, 0.15);">
            <i class="bi bi-layers-fill" style="font-size: 2.2rem; color: #d412b3;"></i>
        </div>
        <div class="page-header-text">
            <h1>Gestión de Promociones</h1>
            <p>Configuración de promociones inmobiliarias vinculadas a cooperativas.</p>
        </div>
    @elseif($activePage == 'inmuebles')
        <div class="page-header-icon" style="background: rgba(165, 42, 42, 0.15);">
            <i class="bi bi-houses-fill" style="font-size: 2.2rem; color: #a52a2a;"></i>
        </div>
        <div class="page-header-text">
            <h1>Gestión de Inmuebles</h1>
            <p>Administración y asignación de viviendas, locales y garajes por promoción.</p>
        </div>
    @elseif($activePage == 'mensajes')
        <div class="page-header-icon" style="background: rgba(3, 169, 244, 0.15);">
            <i class="bi bi-chat-left-dots-fill" style="font-size: 2.2rem; color: #03a9f4;"></i>
        </div>
        <div class="page-header-text">
            <h1>Bandeja de Mensajes</h1>
            <p>Comunícate internamente con otros miembros y la gestoría.</p>
        </div>
    @endif
</div>