{{-- Vista: Socios Expectantes --}}
<div class="d-flex justify-content-end mb-4">
    <button type="button" class="btn btn-warning rounded-pill px-4 shadow-sm fw-bold text-dark"
        wire:click="openExpModal">
        <i class="bi bi-person-plus me-2"></i>Nuevo Socio Expectante
    </button>
</div>

<div class="row g-4">
    <div class="col-md-8">
        <div class="widget-card p-0"
            style="border: 2px solid #ff9800; box-shadow: 8px 8px 15px rgba(255, 152, 0, 0.3);">
            <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-white"
                style="border-radius: 16px 16px 0 0;">
                <h5 class="mb-0 fw-bold" style="color: #e65100;">Lista de Espera Global</h5>
                <div class="d-flex gap-2">
                    <input type="text" class="form-control form-control-sm" placeholder="Buscar interesado..."
                        wire:model.debounce.300ms="search">
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead style="background: #fff8e1;">
                        <tr>
                            <th class="ps-4" style="cursor: pointer;" wire:click="sortBy('entidades.nombre')">
                                Socio Expectante
                                @if($sortField === 'entidades.nombre')
                                    <i
                                        class="bi bi-sort-{{ $sortDirection === 'asc' ? 'alpha-down' : 'alpha-up' }} ms-1"></i>
                                @else
                                    <i class="bi bi-arrow-down-up text-muted opacity-25 ms-1"
                                        style="font-size: 0.8rem;"></i>
                                @endif
                            </th>
                            <th style="cursor: pointer;" wire:click="sortBy('entidades.mail_ppal')">
                                Contacto
                                @if($sortField === 'entidades.mail_ppal')
                                    <i
                                        class="bi bi-sort-{{ $sortDirection === 'asc' ? 'alpha-down' : 'alpha-up' }} ms-1"></i>
                                @else
                                    <i class="bi bi-arrow-down-up text-muted opacity-25 ms-1"
                                        style="font-size: 0.8rem;"></i>
                                @endif
                            </th>
                            <th style="cursor: pointer;" wire:click="sortBy('entidades.cif')">
                                DNI
                                @if($sortField === 'entidades.cif')
                                    <i
                                        class="bi bi-sort-{{ $sortDirection === 'asc' ? 'alpha-down' : 'alpha-up' }} ms-1"></i>
                                @else
                                    <i class="bi bi-arrow-down-up text-muted opacity-25 ms-1"
                                        style="font-size: 0.8rem;"></i>
                                @endif
                            </th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($expectantes as $exp)
                            <tr class="align-middle" style="cursor: pointer;"
                                wire:click="editExpectante({{ $exp->exp_id }})">
                                <td class="ps-4">
                                    <div class="fw-bold text-dark">{{ $exp->nombre }}</div>
                                    <small class="text-muted">{{ Str::limit($exp->comentario, 40) }}</small>
                                </td>
                                <td>
                                    <div class="small"><i class="bi bi-envelope me-1"></i> {{ $exp->mail_ppal }}</div>
                                    <div class="small"><i class="bi bi-telephone me-1"></i> {{ $exp->tlf_ppal }}</div>
                                </td>
                                <td><span class="badge bg-light text-dark border">{{ $exp->cif ?? '-' }}</span></td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <button class="btn btn-sm btn-outline-warning rounded-pill"
                                            wire:click.stop="editExpectante({{ $exp->exp_id }})">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger rounded-pill"
                                            wire:click.stop="confirmDeleteExpectante({{ $exp->exp_id }})">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    No hay socios expectantes registrados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="widget-card border-0 text-white"
            style="background: linear-gradient(135deg, #ff9800 0%, #e65100 100%); box-shadow: 8px 8px 15px rgba(230, 81, 0, 0.4);">
            <div class="d-flex align-items-center mb-3">
                <i class="bi bi-clock-history fs-1 me-3"></i>
                <h5 class="mb-0 fw-bold">Total Expectantes</h5>
            </div>
            <h2 class="display-4 fw-bold mb-2">{{ count($expectantes) }}</h2>
            <p class="mb-0 opacity-75">Interesados activos en el sistema.</p>
            <hr class="my-4 opacity-25">
            <div class="d-grid">
                <button class="btn btn-outline-light rounded-pill fw-bold" wire:click="openExpModal">Lanzar
                    Convocatoria</button>
            </div>
        </div>
    </div>
</div>