{{-- Vista: Gestión de Cooperativas (Grid + Lista) --}}
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
    <!-- Buscador de Cooperativas -->
    <div class="input-group shadow-sm border rounded-pill overflow-hidden bg-white" style="max-width: 400px; flex: 1;">
        <span class="input-group-text bg-transparent border-0 ps-3 text-muted"><i class="bi bi-search"></i></span>
        <input type="text" class="form-control border-0 ps-1 py-2"
            placeholder="Buscar por nombre, población o registro..." wire:model.debounce.300ms="searchCoop"
            style="box-shadow: none;">
        <button class="btn btn-primary px-4 fw-bold" type="button">
            Buscar
        </button>
    </div>

    <!-- Controles de Vista y Acciones -->
    <div class="d-flex align-items-center gap-3 ms-auto">
        <div class="form-check form-switch bg-white p-2 px-4 rounded-pill shadow-sm border mb-0">
            <input class="form-check-input" type="checkbox" role="switch" id="switchFinalizadas"
                wire:model="showFinished">
            <label class="form-check-label fw-bold text-muted ms-2" for="switchFinalizadas"
                style="font-size: 0.85rem; white-space: nowrap;">
                Ver Finalizadas
            </label>
        </div>

        <!-- Botones de Cambio de Vista -->
        <div class="btn-group shadow-sm" role="group" aria-label="Modo de visualización">
            <button type="button" class="btn {{ $coopViewMode == 'grid' ? 'btn-primary' : 'btn-white border' }}"
                wire:click="$set('coopViewMode', 'grid')" title="Vista de Tarjetas">
                <i class="bi bi-grid-fill"></i>
            </button>
            <button type="button" class="btn {{ $coopViewMode == 'list' ? 'btn-primary' : 'btn-white border' }}"
                wire:click="$set('coopViewMode', 'list')" title="Vista de Lista">
                <i class="bi bi-list-ul"></i>
            </button>
        </div>

        <button type="button" class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold text-nowrap"
            wire:click="openModal">
            <i class="bi bi-plus-lg me-2"></i>Nueva
        </button>
    </div>
</div>

<!-- Contenedor principal con wire:key para evitar conflictos de hidratación -->
<div wire:key="coop-view-container">
    @if($coopViewMode == 'grid')
        <div class="row g-4" wire:key="view-grid">
            @forelse($cooperativas as $coop)
                <div class="col-md-4 col-lg-3" wire:key="coop-card-{{ $coop->id }}">
                    <div class="coop-card shell-link" wire:click="editCooperativa({{ $coop->id }})">
                        <!-- Botones de Acción Flotantes -->
                        <div class="position-absolute top-0 end-0 p-3" style="z-index: 10;">
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-light shadow-sm text-primary rounded-circle border"
                                    style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;"
                                    wire:click.stop="editCooperativa({{ $coop->id }})" title="Editar">
                                    <i class="bi bi-pencil-fill" style="font-size: 0.8rem;"></i>
                                </button>
                                <button class="btn btn-sm btn-light shadow-sm text-danger rounded-circle border"
                                    style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;"
                                    wire:click.stop="confirmDeleteCooperativa({{ $coop->id }})" title="Eliminar">
                                    <i class="bi bi-trash3-fill" style="font-size: 0.8rem;"></i>
                                </button>
                            </div>
                        </div>

                        <span class="coop-status-badge shadow-sm"
                            style="background-color: {{ $coop->estado_color ?? '#f3f4f6' }}; color: white; text-shadow: 0 1px 1px rgba(0,0,0,0.3);">
                            {{ $coop->estado_acronimo ?? 'SIN ESTADO' }}
                        </span>

                        <div class="position-absolute"
                            style="top: 15px; left: 15px; display: flex; flex-direction: row; gap: 4px;">
                            @if($coop->inmueble_acronimo)
                                <span class="badge shadow-sm text-white"
                                    style="background-color: {{ $coop->inmueble_color ?: '#6c757d' }}; font-size: 0.6rem; border-radius: 4px; padding: 2px 6px; text-transform: uppercase;">{{ $coop->inmueble_acronimo }}</span>
                            @endif
                            @if($coop->proteccion_acronimo)
                                <span class="badge shadow-sm text-white"
                                    style="background-color: {{ $coop->proteccion_color ?: '#6c757d' }}; font-size: 0.6rem; border-radius: 4px; padding: 2px 6px; text-transform: uppercase;">{{ $coop->proteccion_acronimo }}</span>
                            @endif
                        </div>

                        <div class="coop-icon-box mt-2 overflow-hidden">
                            @if($coop->ruta_logo)
                                <img src="{{ $coop->ruta_logo }}"
                                    style="width: 100%; height: 100%; object-fit: contain; padding: 4px;">
                            @else
                                <i class="bi bi-building text-primary fs-4"></i>
                            @endif
                        </div>

                        <h3 class="coop-title pe-4">{{ $coop->nombre }}</h3>
                        <p class="coop-info">
                            <i class="bi bi-geo-alt me-1"></i> {{ $coop->poblacion ?? 'Ubicación no definida' }}
                        </p>

                        <div class="coop-stats py-3">
                            <div class="row g-0 w-100">
                                <!-- Expectantes -->
                                <div class="col-4 border-end text-center">
                                    <div class="fw-bold text-primary" style="font-size: 0.9rem; line-height: 1;">
                                        {{ $coop->num_socios_expectantes }}
                                    </div>
                                    <small class="text-muted"
                                        style="font-size: 0.65rem; text-transform: uppercase; letter-spacing: 0.5px;">Expect.</small>
                                </div>

                                <!-- Miembros -->
                                <div class="col-4 border-end text-center" style="cursor: pointer;"
                                    wire:click.stop="openMembersModal({{ $coop->id }})">
                                    <div class="fw-bold text-dark" style="font-size: 0.9rem; line-height: 1;">
                                        {{ $coop->num_socios_registrados }} / {{ $coop->num_socios_max }}
                                    </div>
                                    <small class="text-muted"
                                        style="font-size: 0.65rem; text-transform: uppercase; letter-spacing: 0.5px;">Socios</small>
                                </div>

                                <!-- Lista de Espera -->
                                <div class="col-4 text-center">
                                    <div class="fw-bold text-warning" style="font-size: 0.9rem; line-height: 1;">
                                        {{ $coop->num_socios_espera }} / {{ $coop->num_socios_espera_max }}
                                    </div>
                                    <small class="text-muted"
                                        style="font-size: 0.65rem; text-transform: uppercase; letter-spacing: 0.5px;">Espera</small>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 d-flex justify-content-between align-items-center">
                            <button type="button" class="btn btn-sm btn-light rounded-circle shadow-sm border"
                                style="width: 32px; height: 32px;" wire:click.stop="openMembersModal({{ $coop->id }})"
                                title="Gestionar Miembros">
                                <i class="bi bi-people-fill text-primary" style="font-size: 0.9rem;"></i>
                            </button>
                            <div class="text-end" style="flex: 1; padding-left: 15px;">
                                @php
                                    $percent = ($coop->num_socios_max > 0) ? round(($coop->num_socios_registrados / $coop->num_socios_max) * 100, 2) : 0;
                                    $colorClass = 'danger';
                                    if ($percent >= 90)
                                        $colorClass = 'success';
                                    elseif ($percent >= 70)
                                        $colorClass = 'primary';
                                    elseif ($percent >= 50)
                                        $colorClass = 'warning';
                                @endphp
                                <div class="fw-bold text-{{ $colorClass }}" style="font-size: 0.75rem; line-height: 1;">
                                    {{ number_format($percent, 2) }}%</div>
                                <div class="progress ms-auto mt-1"
                                    style="width: 65px; height: 6px; border-radius: 10px; background-color: #f1f5f9;">
                                    <div class="progress-bar bg-{{ $colorClass }}" role="progressbar"
                                        style="width: {{ $percent }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <img src="https://acceso2.intranext.es/images/iconos/sidebar/.old/settings.png"
                        style="width: 80px; opacity: 0.2; filter: grayscale(1);">
                    <p class="text-muted mt-3">No se encontraron cooperativas con los criterios seleccionados.</p>
                </div>
            @endforelse
        </div>
    @else
        <!-- VISTA DE LISTA (TABLA) -->
        <div class="widget-card p-0 shadow-sm border-0" wire:key="view-list">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-muted small text-uppercase fw-bold">Entidad / Cooperativa</th>
                            <th class="py-3 text-muted small text-uppercase fw-bold">Ubicación</th>
                            <th class="py-3 text-muted small text-uppercase fw-bold text-center">Estado</th>
                            <th class="py-3 text-muted small text-uppercase fw-bold text-center">Tipología / Prot.</th>
                            <th class="py-3 text-muted small text-uppercase fw-bold text-center">Expect.</th>
                            <th class="py-3 text-muted small text-uppercase fw-bold text-center">Lista Espera</th>
                            <th class="py-3 text-muted small text-uppercase fw-bold">Ocupación</th>
                            <th class="pe-4 py-3 text-muted small text-uppercase fw-bold text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($cooperativas as $coop)
                            <tr style="cursor: pointer;" wire:click="editCooperativa({{ $coop->id }})"
                                wire:key="coop-row-{{ $coop->id }}">
                                <td class="ps-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-3 bg-primary bg-opacity-10 d-flex align-items-center justify-content-center me-3 overflow-hidden"
                                            style="width: 40px; height: 40px; color: var(--bs-primary);">
                                            @if($coop->ruta_logo)
                                                <img src="{{ $coop->ruta_logo }}"
                                                    style="width: 100%; height: 100%; object-fit: contain; padding: 4px;">
                                            @else
                                                <i class="bi bi-building"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark">{{ $coop->nombre }}</div>
                                            <div class="small text-muted">Reg: {{ $coop->registro_cooperativas ?? 'N/A' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3">
                                    <div class="d-flex align-items-center text-muted">
                                        <i class="bi bi-geo-alt me-2 text-secondary"></i>
                                        {{ $coop->poblacion ?? '-' }}
                                    </div>
                                </td>
                                <td class="py-3 text-center">
                                    <span class="badge rounded-pill px-3 shadow-sm"
                                        style="background-color: {{ $coop->estado_color ?? '#6b7280' }}; color: white;">
                                        {{ $coop->estado_acronimo ?? 'S/E' }}
                                    </span>
                                </td>
                                <td class="py-3 text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        @if($coop->inmueble_acronimo)
                                            <span class="badge text-white shadow-sm"
                                                style="background-color: {{ $coop->inmueble_color ?? '#6c757d' }}; font-size: 0.65rem;">{{ $coop->inmueble_acronimo }}</span>
                                        @endif
                                        @if($coop->proteccion_acronimo)
                                            <span class="badge text-white shadow-sm"
                                                style="background-color: {{ $coop->proteccion_color ?? '#6c757d' }}; font-size: 0.65rem;">{{ $coop->proteccion_acronimo }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-3 text-center fw-bold text-primary" style="font-size: 0.85rem;">
                                    {{ $coop->num_socios_expectantes }}</td>
                                <td class="py-3 text-center fw-bold text-warning" style="font-size: 0.85rem;">
                                    {{ $coop->num_socios_espera }} / {{ $coop->num_socios_espera_max }}</td>
                                <td class="py-3" style="min-width: 150px;">
                                    @php
                                        $percent = ($coop->num_socios_max > 0) ? round(($coop->num_socios_registrados / $coop->num_socios_max) * 100, 2) : 0;
                                        $colorClass = 'danger';
                                        if ($percent >= 90)
                                            $colorClass = 'success';
                                        elseif ($percent >= 70)
                                            $colorClass = 'primary';
                                        elseif ($percent >= 50)
                                            $colorClass = 'warning';
                                    @endphp
                                    <div class="d-flex justify-content-between mb-1">
                                        <span
                                            class="small fw-bold">{{ $coop->num_socios_registrados }}/{{ $coop->num_socios_max }}</span>
                                        <span class="small fw-bold text-{{ $colorClass }}">{{ $percent }}%</span>
                                    </div>
                                    <div class="progress" style="height: 6px; border-radius: 4px;">
                                        <div class="progress-bar bg-{{ $colorClass }}" role="progressbar"
                                            style="width: {{ $percent }}%"></div>
                                    </div>
                                </td>
                                <td class="pe-4 py-3 text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        <button
                                            class="btn btn-sm btn-outline-primary rounded-pill border-0 bg-primary bg-opacity-10 text-primary"
                                            wire:click.stop="openMembersModal({{ $coop->id }})" title="Gestionar Miembros">
                                            <i class="bi bi-people-fill"></i>
                                        </button>
                                        <button
                                            class="btn btn-sm btn-outline-primary rounded-pill border-0 bg-primary bg-opacity-10 text-primary"
                                            wire:click.stop="editCooperativa({{ $coop->id }})" title="Editar">
                                            <i class="bi bi-pencil-fill"></i>
                                        </button>
                                        <button
                                            class="btn btn-sm btn-outline-danger rounded-pill border-0 bg-danger bg-opacity-10 text-danger"
                                            wire:click.stop="confirmDeleteCooperativa({{ $coop->id }})" title="Eliminar">
                                            <i class="bi bi-trash3-fill"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-5 text-center text-muted">
                                    No se encontraron resultados
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>