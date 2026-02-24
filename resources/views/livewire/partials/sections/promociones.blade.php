{{-- Vista: Promociones --}}
<div class="d-flex justify-content-end mb-4">
    <button type="button" class="btn rounded-pill px-4 shadow-sm fw-bold text-white"
        style="background: linear-gradient(90deg, #d412b3, #b01094);" wire:click="openPromocionModal">
        <i class="bi bi-plus-circle me-2"></i>Nueva Promoción
    </button>
</div>

<div class="row g-4">
    <div class="col-md-9">
        <div class="widget-card p-0"
            style="border: 2px solid #d412b3; box-shadow: 8px 8px 15px rgba(212, 18, 179, 0.2);">
            <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-white"
                style="border-radius: 16px 16px 0 0;">
                <h5 class="mb-0 fw-bold" style="color: #b01094;">Listado de Promociones</h5>
                <div class="d-flex gap-2">
                    <input type="text" class="form-control form-control-sm"
                        placeholder="Buscar promoción o cooperativa..." wire:model.debounce.300ms="searchPromocion">
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead style="background: #fdf2f8;">
                        <tr>
                            <th class="ps-4" style="cursor: pointer;"
                                wire:click="sortPromocionesBy('mod110_coop_promociones.nombre_promocion')">
                                Nombre de la Promoción
                                @if($sortPromocionField === 'mod110_coop_promociones.nombre_promocion')
                                    <i
                                        class="bi bi-sort-{{ $sortPromocionDirection === 'asc' ? 'alpha-down' : 'alpha-up' }} ms-1"></i>
                                @endif
                            </th>
                            <th style="cursor: pointer;" wire:click="sortPromocionesBy('entidades.nombre')">
                                Cooperativa
                                @if($sortPromocionField === 'entidades.nombre')
                                    <i
                                        class="bi bi-sort-{{ $sortPromocionDirection === 'asc' ? 'alpha-down' : 'alpha-up' }} ms-1"></i>
                                @endif
                            </th>
                            <th class="text-center">Inmuebles</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($promocionesList as $promo)
                            <tr class="align-middle">
                                <td class="ps-4">
                                    <div class="fw-bold text-dark">{{ $promo->nombre_promocion }}</div>
                                    <small class="text-muted">{{ Str::limit($promo->comentario, 50) }}</small>
                                </td>
                                <td>
                                    <div class="fw-bold">{{ $promo->coop_nombre }}</div>
                                </td>
                                <td class="text-center">
                                    <span class="badge rounded-pill bg-light text-dark border px-3">
                                        {{ $promo->num_inmuebles }} unidades
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <button class="btn btn-sm btn-outline-warning rounded-pill"
                                            wire:click="editPromocion({{ $promo->id }})" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger rounded-pill"
                                            wire:click="confirmDeletePromocion({{ $promo->id }})" title="Eliminar">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    No hay promociones registradas bajo estos criterios.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="widget-card border-0 text-white"
            style="background: linear-gradient(135deg, #d412b3 0%, #b01094 100%); box-shadow: 8px 8px 15px rgba(176, 16, 148, 0.4);">
            <div class="d-flex align-items-center mb-3">
                <i class="bi bi-layers-fill fs-1 me-3"></i>
                <h5 class="mb-0 fw-bold">Resumen de Promociones</h5>
            </div>
            <h2 class="display-4 fw-bold mb-2">{{ count($promocionesList) }}</h2>
            <p class="mb-0 opacity-75">Promociones activas vinculadas a cooperativas.</p>
            <hr class="my-4 opacity-25">
            <div class="d-grid gap-2">
                <button class="btn btn-outline-light rounded-pill fw-bold" wire:click="openPromocionModal">
                    <i class="bi bi-plus-circle me-2"></i>Nueva Promoción
                </button>
            </div>
        </div>
    </div>
</div>