<!-- Modal de Gestión de Socios de Cooperativa -->
@if($showMembersModal)
    <div class="modal fade show"
        style="display: block !important; background: rgba(4, 42, 60, 0.4) !important; backdrop-filter: blur(12px) !important; z-index: 2000 !important;"
        role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-xl" style="z-index: 2001 !important;">
            <div class="modal-content border-0 shadow-lg"
                style="border-radius: 24px; background: rgba(255, 255, 255, 0.98); overflow: hidden;">
                <!-- Cabecera Azul Oscuro -->
                <div class="modal-header border-0 p-4 d-flex align-items-center"
                    style="background: linear-gradient(135deg, #36b37e 0%, #00875a 100%);">
                    <div class="me-3 bg-white rounded-3 p-2">
                        <i class="bi bi-people-fill fs-3" style="color: #36b37e;"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold text-white mb-0">Gestión de Socios:
                            {{ $selectedCoopNameForMembers }}
                        </h5>
                        <p class="text-white-50 small mb-0">Visualice, añada o desvincule socios de esta cooperativa.
                        </p>
                    </div>
                    <button type="button" class="btn-close btn-close-white ms-auto" wire:click="closeMembersModal"></button>
                </div>

                <div class="modal-body p-4">
                    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
                        <!-- Buscador de Miembros -->
                        <div class="input-group shadow-sm border rounded-pill overflow-hidden bg-white"
                            style="max-width: 400px; flex: 1;">
                            <span class="input-group-text bg-transparent border-0 ps-3 text-muted"><i
                                    class="bi bi-search"></i></span>
                            <input type="text" class="form-control border-0 ps-1 py-2"
                                placeholder="Buscar por nombre, CIF, email..." wire:model.debounce.300ms="searchMember"
                                style="box-shadow: none;">
                        </div>

                        <button type="button" class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold"
                            wire:click="openLinkSocioModal">
                            <i class="bi bi-person-plus me-2"></i>Vincular Expectante
                        </button>
                    </div>

                    <div class="table-responsive bg-white rounded-4 shadow-sm border">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 py-3" style="cursor: pointer;"
                                        wire:click="sortMembersBy('entidades.nombre')">
                                        Socio
                                        @if($sortMemberField === 'entidades.nombre')
                                            <i
                                                class="bi bi-sort-{{ $sortMemberDirection === 'asc' ? 'alpha-down' : 'alpha-up' }} ms-1"></i>
                                        @endif
                                    </th>
                                    <th class="py-3">DNI / CIF</th>
                                    <th class="py-3">Tipo de Socio</th>
                                    <th class="py-3">Contacto</th>
                                    <th class="pe-4 py-3 text-end">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sociosCoop as $socio)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-bold text-dark">{{ $socio->nombre }}</div>
                                            <div class="small text-muted">{{ $socio->razon_social }}</div>
                                        </td>
                                        <td><span class="badge bg-light text-dark border">{{ $socio->cif }}</span></td>
                                        <td>
                                            @if($socio->tipo_socio_acronimo)
                                                <span class="badge shadow-sm text-white"
                                                    style="background-color: {{ $socio->tipo_socio_color ?? '#6c757d' }}; font-size: 0.75rem; padding: 6px 12px;">
                                                    {{ $socio->tipo_socio_acronimo }}
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="small"><i class="bi bi-envelope me-1"></i> {{ $socio->mail_ppal }}
                                            </div>
                                            <div class="small"><i class="bi bi-telephone me-1"></i> {{ $socio->tlf_ppal }}
                                            </div>
                                        </td>
                                        <td class="pe-4 text-end">
                                            <div class="d-flex gap-2 justify-content-end">
                                                @if($socio->tipo_socio_id == 1)
                                                    {{-- Botón INSCRIBIR para socios expectantes --}}
                                                    <button class="btn btn-sm btn-success rounded-pill px-3"
                                                        wire:click="confirmInscribir({{ $socio->socio_table_id }}, '{{ $socio->nombre }}')">
                                                        <i class="bi bi-pencil-square me-1"></i> Inscribir
                                                    </button>
                                                @endif
                                                <button class="btn btn-sm btn-outline-danger rounded-pill px-3"
                                                    wire:click="confirmUnlinkMember({{ $socio->socio_table_id }})">
                                                    <i class="bi bi-person-dash me-1"></i> Desvincular
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-muted">
                                            No hay socios registrados en esta cooperativa.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="modal-footer border-0 p-4" style="background: #f1f3f5;">
                    <button type="button" class="btn btn-secondary rounded-pill px-5 fw-bold"
                        wire:click="closeMembersModal">Cerrar Gestión</button>
                </div>
            </div>
        </div>
    </div>
@endif

<!-- Modal de Selección de Socio para Vincular -->
@if($showLinkModal)
    <div class="modal fade show"
        style="display: block !important; background: rgba(0, 0, 0, 0.4) !important; backdrop-filter: blur(8px) !important; z-index: 2100 !important;"
        role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" style="z-index: 2101 !important;">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                <div class="modal-header border-0 p-4">
                    <h5 class="modal-title fw-bold">Vincular Socio Expectante</h5>
                    <button type="button" class="btn-close" wire:click="$set('showLinkModal', false)"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="input-group mb-4 shadow-sm rounded-pill overflow-hidden border">
                        <span class="input-group-text bg-white border-0 ps-3"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control border-0 py-2"
                            placeholder="Buscar entre socios expectantes..." wire:model="searchLinkSocio">
                    </div>

                    <div class="list-group rounded-4 overflow-hidden border">
                        @forelse($availableExpectantes as $exp)
                            <button type="button"
                                class="list-group-item list-group-item-action border-0 d-flex justify-content-between align-items-center p-3"
                                wire:click="linkSocio({{ $exp->id }})">
                                <div>
                                    <div class="fw-bold">{{ $exp->nombre }}</div>
                                    <div class="small text-muted">{{ $exp->cif }} · {{ $exp->mail_ppal }}</div>
                                </div>
                                <i class="bi bi-plus-circle-fill text-primary fs-5"></i>
                            </button>
                        @empty
                            <div class="p-5 text-center text-muted">No se encontraron socios disponibles.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif



