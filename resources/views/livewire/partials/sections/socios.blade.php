{{-- Vista: Socios Registrados --}}
<div class="d-flex justify-content-end mb-4">
    <button type="button" class="btn rounded-pill px-4 shadow-sm fw-bold text-white"
        style="background: linear-gradient(90deg, #36b37e, #00b894);" wire:click="openRegModal">
        <i class="bi bi-person-plus me-2"></i>Nuevo Socio Registrado
    </button>
</div>

<div class="row g-4">
    <div class="col-md-8">
        <div class="widget-card p-0"
            style="border: 2px solid #36b37e; box-shadow: 8px 8px 15px rgba(54, 179, 126, 0.3);">
            <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-white"
                style="border-radius: 16px 16px 0 0;">
                <h5 class="mb-0 fw-bold" style="color: #00875a;">Socios Registrados en Cooperativas</h5>
                <div class="d-flex gap-2">
                    <input type="text" class="form-control form-control-sm" placeholder="Buscar socio..."
                        wire:model.debounce.300ms="searchReg">
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead style="background: #e3fcef;">
                        <tr>
                            <th class="ps-4" style="cursor: pointer;" wire:click="sortRegBy('entidades.nombre')">
                                Socio Registrado
                                @if($sortRegField === 'entidades.nombre')
                                    <i
                                        class="bi bi-sort-{{ $sortRegDirection === 'asc' ? 'alpha-down' : 'alpha-up' }} ms-1"></i>
                                @else
                                    <i class="bi bi-arrow-down-up text-muted opacity-25 ms-1"
                                        style="font-size: 0.8rem;"></i>
                                @endif
                            </th>
                            <th style="cursor: pointer;" wire:click="sortRegBy('entidades.mail_ppal')">
                                Contacto
                                @if($sortRegField === 'entidades.mail_ppal')
                                    <i
                                        class="bi bi-sort-{{ $sortRegDirection === 'asc' ? 'alpha-down' : 'alpha-up' }} ms-1"></i>
                                @else
                                    <i class="bi bi-arrow-down-up text-muted opacity-25 ms-1"
                                        style="font-size: 0.8rem;"></i>
                                @endif
                            </th>
                            <th style="cursor: pointer;" wire:click="sortRegBy('entidades.cif')">
                                DNI / CIF
                                @if($sortRegField === 'entidades.cif')
                                    <i
                                        class="bi bi-sort-{{ $sortRegDirection === 'asc' ? 'alpha-down' : 'alpha-up' }} ms-1"></i>
                                @else
                                    <i class="bi bi-arrow-down-up text-muted opacity-25 ms-1"
                                        style="font-size: 0.8rem;"></i>
                                @endif
                            </th>
                            <th class="text-center">Cooperativas</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($registrados as $reg)
                            <tr class="align-middle">
                                <td class="ps-4">
                                    <div class="fw-bold text-dark">{{ $reg->nombre }}</div>
                                    @if($reg->tipos_socio)
                                        <small class="text-muted">Tipos: {{ $reg->tipos_socio }}</small>
                                    @endif
                                </td>
                                <td>
                                    <div class="small"><i class="bi bi-envelope me-1"></i> {{ $reg->mail_ppal }}</div>
                                    <div class="small"><i class="bi bi-telephone me-1"></i> {{ $reg->tlf_ppal }}</div>
                                </td>
                                <td><span class="badge bg-light text-dark border">{{ $reg->cif ?? '-' }}</span></td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-info rounded-pill px-3"
                                        wire:click="openSocioCoopsModal({{ $reg->id }}, '{{ $reg->nombre }}')">
                                        <i class="bi bi-building me-1"></i> {{ $reg->num_cooperativas }}
                                    </button>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <button class="btn btn-sm btn-outline-success rounded-pill"
                                            wire:click="editRegistrado({{ $reg->id }})" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-info rounded-pill"
                                            wire:click="openUploadFileModal({{ $reg->id }}, '{{ $reg->nombre }}')"
                                            title="Subir Documento">
                                            <i class="bi bi-file-earmark-arrow-up"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger rounded-pill"
                                            wire:click="confirmDeleteRegistrado({{ $reg->id }})" title="Eliminar">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    No hay socios registrados en cooperativas.
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
            style="background: linear-gradient(135deg, #36b37e 0%, #00875a 100%); box-shadow: 8px 8px 15px rgba(0, 135, 90, 0.4);">
            <div class="d-flex align-items-center mb-3">
                <i class="bi bi-people-fill fs-1 me-3"></i>
                <h5 class="mb-0 fw-bold">Total Socios Registrados</h5>
            </div>
            <h2 class="display-4 fw-bold mb-2">{{ count($registrados) }}</h2>
            <p class="mb-0 opacity-75">Socios activos en el sistema vinculados a cooperativas.</p>
            <hr class="my-4 opacity-25">
            <div class="d-grid">
                <button class="btn btn-outline-light rounded-pill fw-bold" wire:click="openRegModal">
                    <i class="bi bi-plus-circle me-2"></i>Añadir Nuevo Socio
                </button>
            </div>
        </div>
    </div>
</div>