<div>

    {{-- =====================================================
    MODALES: Formularios de creación / edición
    ====================================================== --}}
    @include('livewire.partials.modals-cooperativas')
    @include('livewire.partials.modals-expectantes')
    @include('livewire.partials.modals-socios')
    @include('livewire.partials.modals-inmuebles')
    @include('livewire.partials.modals-promociones')
    @include('livewire.partials.modals-usuarios')
    @include('livewire.partials.modals-shared')

    {{-- =====================================================
    MODALES: Confirmaciones y acciones secundarias
    ====================================================== --}}
    @include('livewire.partials.modals-acciones')

    {{-- =====================================================
    ESTILOS CSS del escritorio
    ====================================================== --}}
    @include('livewire.partials.styles')

    {{-- =====================================================
    CABECERA DINÁMICA (icono + título por sección)
    ====================================================== --}}
    @include('livewire.partials.header')

    {{-- =====================================================
    CONTENIDO DINÁMICO según la página activa
    ====================================================== --}}
    <div class="dashboard-content">
        @if($activePage == 'escritorio')
            @include('livewire.partials.sections.escritorio')

        @elseif($activePage == 'cooperativas')
            @include('livewire.partials.sections.cooperativas')

        @elseif($activePage == 'expectantes')
            @include('livewire.partials.sections.expectantes')

        @elseif($activePage == 'socios')
            @include('livewire.partials.sections.socios')

        @elseif($activePage == 'contactos')
            @include('livewire.partials.sections.contactos')

        @elseif($activePage == 'promociones')
            @include('livewire.partials.sections.promociones')

        @elseif($activePage == 'inmuebles')
            @include('livewire.partials.sections.inmuebles')

        @elseif($activePage == 'perfil')
            @include('livewire.partials.sections.perfil')

        @elseif($activePage == 'configuracion')
            @include('livewire.partials.sections.configuracion')

        @elseif($activePage == 'mensajes')
            @livewire('mailbox', ['draftEmail' => $draftEmail])

        @endif
    </div>

    {{-- =====================================================
    SCRIPTS GLOBALES
    ====================================================== --}}
    <script>
        window.addEventListener('swal:alert', event => {
            Swal.fire({
                title: event.detail.title,
                text: event.detail.text,
                icon: event.detail.type,
                confirmButtonColor: '#00d1e0'
            });
        });
    </script>

</div>