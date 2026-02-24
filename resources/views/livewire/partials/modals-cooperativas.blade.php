<!-- Modal de Creación Premium -->
@if($showModal)
    <div class="modal fade show"
        style="display: block !important; background: rgba(4, 42, 60, 0.4) !important; backdrop-filter: blur(12px) !important; z-index: 2000 !important;"
        role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" style="z-index: 2001 !important; max-width: 850px;">
            <div class="modal-content border-0 shadow-lg"
                style="border-radius: 24px; background: rgba(255, 255, 255, 0.95); overflow: hidden;">
                <!-- Cabecera con degradado -->
                <div class="modal-header border-0 p-4 d-flex align-items-center"
                    style="background: linear-gradient(135deg, #ccff00 0%, #99aa00 100%);">
                    <div class="me-3 bg-white rounded-3 p-2">
                        <i class="bi bi-building-fill-add fs-3" style="color: #99aa00;"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold text-dark mb-0">
                            {{ $selectedCoopId ? 'Editar Cooperativa' : 'Nueva Cooperativa' }}
                        </h5>
                        <p class="text-dark-50 small mb-0">
                            {{ $selectedCoopId ? 'Modifique los datos necesarios de la entidad.' : 'Complete los datos fiscales y operativos para dar de alta la entidad.' }}
                        </p>
                    </div>
                    <button type="button" class="btn-close btn-close-dark ms-auto" wire:click="closeModal"></button>
                </div>

                <form wire:submit.prevent="saveCooperativa">
                    <div class="modal-body p-4" style="max-height: 70vh; overflow-y: auto;">
                        <!-- Sección 1: Datos Identificativos -->
                        <div class="mb-4">
                            <h6 class="text-primary fw-bold mb-3 d-flex align-items-center">
                                <span
                                    class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2"
                                    style="width: 24px; height: 24px;">1</span>
                                Datos Fiscales e Identificación
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-8">
                                    <label class="form-label fw-semibold small text-dark">Nombre Comercial</label>
                                    <input type="text" class="form-control form-control-lg border-light shadow-sm"
                                        style="border-radius: 12px; font-size: 0.95rem;" wire:model.defer="coopNombre"
                                        placeholder="Ej: Amanecer Madrid S.C.A.">
                                    @error('coopNombre') <span class="text-danger x-small">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold small text-dark">CIF / NIF</label>
                                    <input type="text" class="form-control form-control-lg border-light shadow-sm"
                                        style="border-radius: 12px; font-size: 0.95rem;" wire:model.defer="coopCIF"
                                        placeholder="F00000000">
                                    @error('coopCIF') <span class="text-danger x-small">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small text-dark">Tipología de Inmueble</label>
                                    <select class="form-select border-light shadow-sm" style="border-radius: 10px;"
                                        wire:model.defer="coopTipoInmuebleId">
                                        <option value="">-- Seleccionar --</option>
                                        @foreach($tiposInmueble as $tipo)
                                            <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small text-dark">Tipo de Protección</label>
                                    <select class="form-select border-light shadow-sm" style="border-radius: 10px;"
                                        wire:model.defer="coopTipoProteccionId">
                                        <option value="">-- Seleccionar --</option>
                                        @foreach($tiposProteccion as $tipo)
                                            <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold small text-dark">Razón Social</label>
                                    <input type="text" class="form-control border-light shadow-sm"
                                        style="border-radius: 10px;" wire:model.defer="coopRazonSocial"
                                        placeholder="Nombre legal completo">
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold small text-dark">Estado de la
                                        Cooperativa</label>
                                    <select class="form-select border-light shadow-sm" style="border-radius: 10px;"
                                        wire:model.defer="coopEstadoId">
                                        <option value="">-- Seleccionar Estado --</option>
                                        @foreach($estados as $estado)
                                            <option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Sección 2: Ubicación -->
                        <div class="mb-4">
                            <h6 class="text-primary fw-bold mb-3 d-flex align-items-center">
                                <span
                                    class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2"
                                    style="width: 24px; height: 24px;">2</span>
                                Ubicación y Gestión
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold small text-dark">Población</label>
                                    <input type="text" class="form-control border-light shadow-sm"
                                        style="border-radius: 10px;" wire:model.defer="coopPoblacion">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold small text-dark">Provincia</label>
                                    <input type="text" class="form-control border-light shadow-sm"
                                        style="border-radius: 10px;" wire:model.defer="coopProvincia">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold small text-dark">País</label>
                                    <input type="text" class="form-control border-light shadow-sm"
                                        style="border-radius: 10px;" wire:model.defer="coopPais">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small text-dark">Nº Registro
                                        Cooperativas</label>
                                    <input type="text" class="form-control border-light shadow-sm"
                                        style="border-radius: 10px;" wire:model.defer="coopRegistro"
                                        placeholder="REG-123456">
                                </div>
                            </div>
                        </div>

                        <!-- Sección 3: Datos de Socios (Métricas) -->
                        <div class="mb-4">
                            <h6 class="text-primary fw-bold mb-3 d-flex align-items-center">
                                <span
                                    class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2"
                                    style="width: 24px; height: 24px;">3</span>
                                Planificación de Socios
                            </h6>
                            <div class="row g-3">
                                <!-- Fila 1: Valores Máximos -->
                                <div class="col-md-6">
                                    <div
                                        class="p-3 rounded-4 border border-success border-opacity-25 bg-success bg-opacity-10">
                                        <label class="form-label fw-bold small text-success mb-1">Capacidad
                                            Máxima</label>
                                        <input type="number" class="form-control border-0 bg-white shadow-sm"
                                            style="border-radius: 8px;" wire:model.defer="coopSociosMax">
                                        <small class="text-muted d-block mt-1">Límite para viviendas del
                                            proyecto</small>
                                        @error('coopSociosMax') <span class="text-danger x-small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div
                                        class="p-3 rounded-4 border border-secondary border-opacity-25 bg-secondary bg-opacity-10">
                                        <label class="form-label fw-bold small text-secondary mb-1">Máximo Lista de
                                            Espera</label>
                                        <input type="number" class="form-control border-0 bg-white shadow-sm"
                                            style="border-radius: 8px;" wire:model.defer="coopSociosEsperaMax">
                                        <small class="text-muted d-block mt-1">Capacidad límite para espera</small>
                                    </div>
                                </div>

                                <!-- Fila 2: Valores Actuales -->
                                <div class="col-md-4">
                                    <div
                                        class="p-3 rounded-4 border border-primary border-opacity-25 bg-primary bg-opacity-10">
                                        <label class="form-label fw-bold small text-primary mb-1">Expectantes</label>
                                        <input type="number" class="form-control border-0 bg-white shadow-sm"
                                            style="border-radius: 8px;" wire:model.defer="coopSociosExpectantes">
                                        <small class="text-muted d-block mt-1">Interesados</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="p-3 rounded-4 border border-info border-opacity-25 bg-info bg-opacity-10">
                                        <label class="form-label fw-bold small text-info mb-1">Registrados</label>
                                        <input type="number" class="form-control border-0 bg-white shadow-sm"
                                            style="border-radius: 8px;" wire:model.defer="coopSociosReg">
                                        <small class="text-muted d-block mt-1">Socios alta</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div
                                        class="p-3 rounded-4 border border-warning border-opacity-25 bg-warning bg-opacity-10">
                                        <label class="form-label fw-bold small text-warning mb-1">En Espera</label>
                                        <input type="number" class="form-control border-0 bg-white shadow-sm"
                                            style="border-radius: 8px;" wire:model.defer="coopSociosEspera">
                                        <small class="text-muted d-block mt-1">Cola actual</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold small text-dark">Observaciones adicionales</label>
                            <textarea class="form-control border-light shadow-sm" style="border-radius: 12px;" rows="3"
                                wire:model.defer="coopComentario"></textarea>
                        </div>

                        @if (session()->has('error'))
                            <div class="alert alert-danger mt-3 border-0 shadow-sm" style="border-radius: 12px;">
                                {{ session('error') }}
                            </div>
                        @endif
                    </div>

                    <!-- Footer Moderno -->
                    <div class="modal-footer border-0 p-4" style="background: #f1f3f5;">
                        <button type="button" class="btn btn-link text-muted fw-bold text-decoration-none me-auto"
                            wire:click="closeModal">Descartar cambios</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-5 py-2 fw-bold shadow"
                            style="background: linear-gradient(90deg, #042a3c, #0d4a66); border: none;">
                            <i
                                class="bi bi-check-circle me-2"></i>{{ $selectedCoopId ? 'Registrar Modificaciones' : 'Finalizar Alta' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif

<!-- Modal de Confirmación de Borrado Cooperativa -->
@if($showDeleteCoopModal)
    <div class="modal fade show"
        style="display: block !important; background: rgba(0, 0, 0, 0.5) !important; backdrop-filter: blur(4px) !important; z-index: 2100 !important;"
        role="dialog">
        <div class="modal-dialog modal-dialog-centered" style="z-index: 2101 !important;">
            <div class="modal-content border-0 shadow" style="border-radius: 20px;">
                <div class="modal-body p-4 text-center">
                    <div class="mb-4">
                        <i class="bi bi-trash3-fill text-danger" style="font-size: 4rem;"></i>
                    </div>
                    <h4 class="fw-bold mb-2">Eliminar Cooperativa</h4>
                    <p class="text-muted">¿Está seguro de que desea eliminar la cooperativa seleccionada y todos sus datos
                        asociados? Esta acción no se puede deshacer.</p>

                    <div class="d-flex justify-content-center gap-3 mt-4">
                        <button type="button" class="btn btn-light rounded-pill px-4"
                            wire:click="$set('showDeleteCoopModal', false)">Cancelar</button>
                        <button type="button" class="btn btn-danger rounded-pill px-4 fw-bold shadow-sm"
                            wire:click="deleteCooperativa">
                            <i class="bi bi-trash me-2"></i>Sí, Eliminar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif