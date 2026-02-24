{{-- Vista: Inmuebles (Grid + Lista + Filtros) --}}
<div class="inmuebles-dashboard">
    <!-- BARRA DE FILTROS Y CONTROLES -->
    <div class="row g-3 mb-4 align-items-center">
        <!-- Buscador -->
        <div class="col-lg-4">
            <div class="input-group shadow-sm border rounded-pill overflow-hidden bg-white">
                <span class="input-group-text bg-transparent border-0 ps-3 text-muted"><i class="bi bi-search"></i></span>
                <input type="text" class="form-control border-0 ps-1 py-2" 
                       placeholder="Buscar inmueble o promoción..." 
                       wire:model.debounce.300ms="searchInmueble"
                       style="box-shadow: none;">
            </div>
        </div>

        <!-- Filtros Select -->
        <div class="col-lg-8">
            <div class="d-flex flex-wrap gap-2 justify-content-lg-end align-items-center">
                
                <!-- Filtro por Cooperativa -->
                <select class="form-select form-select-sm rounded-pill border-light shadow-sm bg-white" 
                        style="width: auto; max-width: 180px;" 
                        wire:model="filterInmuebleCoop">
                    <option value="">Todas las Cooperativas</option>
                    @foreach($cooperativasList as $coop)
                        <option value="{{ $coop->id }}">{{ $coop->nombre }}</option>
                    @endforeach
                </select>

                <!-- Filtro por Promoción -->
                <select class="form-select form-select-sm rounded-pill border-light shadow-sm bg-white" 
                        style="width: auto; max-width: 180px;" 
                        wire:model="filterInmueblePromo">
                    <option value="">Todas las Promociones</option>
                    @foreach($promociones as $promo)
                        <option value="{{ $promo->id }}">{{ $promo->nombre_promocion }}</option>
                    @endforeach
                </select>

                <!-- Filtro por Tipología -->
                <select class="form-select form-select-sm rounded-pill border-light shadow-sm bg-white" 
                        style="width: auto; max-width: 150px;" 
                        wire:model="filterInmuebleTipo">
                    <option value="">Cualquier Tipo</option>
                    @foreach($tiposInmueble as $tipo)
                        <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                    @endforeach
                </select>

                <!-- Filtro por Estado -->
                <select class="form-select form-select-sm rounded-pill border-light shadow-sm bg-white" 
                        style="width: auto; max-width: 150px;" 
                        wire:model="filterInmuebleEstado">
                    <option value="">Cualquier Estado</option>
                    @foreach($estadosInmueble as $est)
                        <option value="{{ $est->id }}">{{ $est->nombre }}</option>
                    @endforeach
                </select>

                <!-- Toggle Vista -->
                <div class="btn-group shadow-sm btn-group-sm" role="group">
                    <button type="button" class="btn {{ $inmuebleViewMode == 'grid' ? 'btn-primary' : 'btn-white border' }}" 
                            wire:click="$set('inmuebleViewMode', 'grid')" title="Vista de Tarjetas">
                        <i class="bi bi-grid-fill"></i>
                    </button>
                    <button type="button" class="btn {{ $inmuebleViewMode == 'list' ? 'btn-primary' : 'btn-white border' }}" 
                            wire:click="$set('inmuebleViewMode', 'list')" title="Vista de Lista">
                        <i class="bi bi-list-ul"></i>
                    </button>
                </div>

                <!-- Botón Nuevo -->
                <button type="button" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm fw-bold border-0"
                        style="background: linear-gradient(90deg, #a52a2a, #8b0000);"
                        wire:click="openInmuebleModal">
                    <i class="bi bi-plus-lg me-1"></i>Nuevo
                </button>
            </div>
        </div>
    </div>

    <!-- CONTENEDOR DE RESULTADOS -->
    <div wire:key="inmueble-view-container">
        @if($inmuebleViewMode == 'grid')
            <!-- VISTA GRID (TARJETAS) -->
            <div class="row g-4" wire:key="inm-grid">
                @forelse($inmuebles as $inm)
                    <div class="col-md-6 col-lg-4 col-xl-3" wire:key="inm-card-{{ $inm->id }}">
                        <div class="card h-100 border-0 shadow-sm inmueble-card" style="border-radius: 20px; overflow: hidden; transition: transform 0.3s ease;">
                            <div class="position-relative">
                                <!-- Imagen / Icono de fondo -->
                                <div class="bg-light d-flex align-items-center justify-content-center" style="height: 160px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                                    <i class="bi bi-house-door text-muted opacity-25" style="font-size: 5rem;"></i>
                                    <div class="position-absolute bottom-0 start-0 w-100 p-3 bg-dark bg-opacity-50 backdrop-blur d-flex justify-content-between align-items-center">
                                        <span class="badge rounded-pill px-2 py-1 text-white border-0" 
                                              style="background-color: {{ $inm->estado_color ?? '#6c757d' }}; font-size: 0.7rem; text-transform: uppercase;">
                                            {{ $inm->estado_acronimo ?? ($inm->estado_id == 1 ? 'DISP' : 'S/E') }}
                                        </span>
                                        <div class="d-flex gap-1">
                                            @if($inm->inmueble_acronimo)
                                                <span class="badge text-white" style="background-color: {{ $inm->inmueble_color ?: '#495057' }}; font-size: 0.6rem; border-radius: 4px;">{{ $inm->inmueble_acronimo }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <!-- Botones flotantes -->
                                <div class="position-absolute top-0 end-0 p-2">
                                    <div class="d-flex flex-column gap-2">
                                        <button class="btn btn-white btn-sm rounded-circle shadow-sm border" style="width: 32px; height: 32px;" wire:click="editInmueble({{ $inm->id }})">
                                            <i class="bi bi-pencil-fill text-warning"></i>
                                        </button>
                                        <button class="btn btn-white btn-sm rounded-circle shadow-sm border" style="width: 32px; height: 32px;" wire:click="confirmDeleteInmueble({{ $inm->id }})">
                                            <i class="bi bi-trash-fill text-danger"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-3">
                                <h6 class="fw-bold text-dark mb-1">{{ $inm->nombre }}</h6>
                                <p class="small text-primary fw-bold mb-2">
                                    <i class="bi bi-stack me-1"></i> {{ $inm->promocion_nombre }}
                                </p>
                                <p class="text-muted mb-3 x-small text-truncate" style="height: 32px; overflow: hidden;">
                                    {{ $inm->comentario ?: 'Sin descripción detallada...' }}
                                </p>
                                <div class="d-flex justify-content-between align-items-center mt-auto border-top pt-2">
                                    <span class="x-small text-muted"><i class="bi bi-info-circle me-1"></i>ID: {{ $inm->id }}</span>
                                    <button class="btn btn-link btn-sm text-decoration-none p-0 fw-bold x-small" wire:click="editInmueble({{ $inm->id }})">Ver detalles <i class="bi bi-arrow-right"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <i class="bi bi-houses text-muted opacity-25" style="font-size: 4rem;"></i>
                        <p class="text-muted mt-3">No hay inmuebles que coincidan con los filtros.</p>
                    </div>
                @endforelse
            </div>
        @else
            <!-- VISTA LISTA (TABLA) -->
            <div class="card border-0 shadow-sm" style="border-radius: 20px; overflow: hidden;" wire:key="inm-list">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3 text-muted small text-uppercase fw-bold">Nombre / Identificador</th>
                                <th class="py-3 text-muted small text-uppercase fw-bold">Promoción</th>
                                <th class="py-3 text-muted small text-uppercase fw-bold text-center">Tipología / Prot.</th>
                                <th class="py-3 text-muted small text-uppercase fw-bold text-center">Estado</th>
                                <th class="pe-4 py-3 text-muted small text-uppercase fw-bold text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="border-top-0">
                            @forelse($inmuebles as $inm)
                                <tr style="cursor: pointer;" wire:click="editInmueble({{ $inm->id }})">
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-3 bg-brown-light bg-opacity-25 d-flex align-items-center justify-content-center me-3" 
                                                 style="width: 40px; height: 40px; color: #8b0000; background-color: rgba(165, 42, 42, 0.1);">
                                                <i class="bi bi-house-door-fill"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark">{{ $inm->nombre }}</div>
                                                <div class="x-small text-muted text-truncate" style="max-width: 200px;">{{ $inm->comentario }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-layers me-2 text-muted"></i>
                                            <span class="text-dark small">{{ $inm->promocion_nombre }}</span>
                                        </div>
                                    </td>
                                    <td class="py-3 text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            @if($inm->inmueble_acronimo)
                                                <span class="badge text-white shadow-sm" style="background-color: {{ $inm->inmueble_color ?: '#6c757d' }}; font-size: 0.65rem;">{{ $inm->inmueble_acronimo }}</span>
                                            @endif
                                            @if($inm->proteccion_acronimo)
                                                <span class="badge text-white shadow-sm" style="background-color: {{ $inm->proteccion_color ?: '#6c757d' }}; font-size: 0.65rem;">{{ $inm->proteccion_acronimo }}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="py-3 text-center">
                                        <span class="badge rounded-pill px-3 shadow-sm" 
                                              style="background-color: {{ $inm->estado_color ?? '#6b7280' }}; color: white;">
                                             {{ $inm->estado_nombre ?? ($inm->estado_id == 1 ? 'Disponible' : 'S/E') }}
                                         </span>
                                    </td>
                                    <td class="pe-4 py-3 text-end">
                                        <div class="d-flex justify-content-end gap-2">
                                            <button class="btn btn-sm btn-outline-warning rounded-pill border-0 bg-warning bg-opacity-10 text-warning" wire:click.stop="editInmueble({{ $inm->id }})">
                                                <i class="bi bi-pencil-fill"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger rounded-pill border-0 bg-danger bg-opacity-10 text-danger" wire:click.stop="confirmDeleteInmueble({{ $inm->id }})">
                                                <i class="bi bi-trash3-fill"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-5 text-center text-muted">No se encontraron resultados</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</div>

<style>
    .inmueble-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .backdrop-blur {
        backdrop-filter: blur(4px);
    }
    .x-small {
        font-size: 0.75rem;
    }
</style>